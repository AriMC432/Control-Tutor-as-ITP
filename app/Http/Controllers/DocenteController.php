<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

// Importación de modelos
use App\Models\Grupo;
use App\Models\Estudiante;
use App\Models\TutoriaGrupal;
use App\Models\TutoriaIndividual;
use App\Models\Canalizacion;
use App\Models\AreaCanalizacion;
use App\Models\DetalleTutoriaGrupal;
use App\Models\Docente;
use App\Models\Periodo;

class DocenteController extends Controller
{
    /**
     * 1. DASHBOARD PRINCIPAL
     */
    public function docente()
    {
        $idDocente = Session::get('user_id');
        $periodoActual = Periodo::where('activo', 1)->first();

        if (!$periodoActual) {
            return view('docente.index', [
                'grupos' => [],
                'tutorias' => collect(),
                'error' => 'No hay periodo escolar activo configurado en el sistema.'
            ]);
        }

        $fechaInicio = $periodoActual->fecha_inicio;
        $fechaFin = $periodoActual->fecha_fin;

        // A. Grupos del periodo actual
        $grupos = Grupo::where('id_docente', $idDocente)
            ->where('id_periodo', $periodoActual->id_periodo)
            ->with('carrera')
            ->get();

        // B. Historial (Dashboard)
        $grupales = TutoriaGrupal::where('id_docente', $idDocente)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get()
            ->map(function ($t) {
                $grupo = Grupo::find($t->id_grupo);
                return (object)[
                    'fecha' => $t->fecha,
                    'hora'  => $t->hora,
                    'tema'  => $t->tema,
                    'tipo'  => 'Grupal',
                    'info'  => $grupo ? $grupo->nombre : 'Grupo N/A',
                    'orden' => $t->fecha . ' ' . $t->hora
                ];
            });

        $individuales = TutoriaIndividual::where('id_docente', $idDocente)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->with('estudiante')
            ->get()
            ->map(function ($t) {
                $nombreEstudiante = $t->estudiante ? $t->estudiante->nombre . ' ' . $t->estudiante->paterno : 'Alumno N/A';
                return (object)[
                    'fecha' => $t->fecha,
                    'hora'  => $t->hora,
                    'tema'  => $t->motivo,
                    'tipo'  => 'Individual',
                    'info'  => $nombreEstudiante,
                    'orden' => $t->fecha . ' ' . $t->hora
                ];
            });

        $tutorias = $grupales->concat($individuales)->sortByDesc('orden')->take(10);

        return view('docente.index', compact('grupos', 'tutorias', 'periodoActual'));
    }

    /**
     * 2. VISTA: AGENDAR Y GESTIONAR TUTORÍAS
     */
    public function viewTutorias()
    {
        $idDocente = Session::get('user_id');
        $periodoActual = Periodo::where('activo', 1)->first();

        if (!$periodoActual) {
            return view('docente.tutorias', [
                'gruposAsignados' => [],
                'misTutoriasGrupales' => [],
                'misTutoriasIndividuales' => []
            ])->with('error', 'No hay periodo activo.');
        }

        $fechaInicio = $periodoActual->fecha_inicio;
        $fechaFin = $periodoActual->fecha_fin;

        // 1. Grupos para el select
        $gruposAsignados = Grupo::where('id_docente', $idDocente)
            ->where('id_periodo', $periodoActual->id_periodo)
            ->with(['estudiantes' => function ($query) {
                $query->orderBy('paterno', 'asc');
            }, 'carrera'])
            ->get();

        // 2. Listas para editar
        $misTutoriasGrupales = TutoriaGrupal::where('id_docente', $idDocente)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->with(['grupo.estudiantes' => function ($q) {
                $q->orderBy('paterno', 'asc');
            }, 'detalles'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();

        $misTutoriasIndividuales = TutoriaIndividual::where('id_docente', $idDocente)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->with(['estudiante.grupo'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();

        return view('docente.tutorias', compact('gruposAsignados', 'misTutoriasGrupales', 'misTutoriasIndividuales'));
    }

    /**
     * 3. GUARDAR TUTORÍA (POST) - CON VALIDACIÓN DE HORARIO
     */
    public function storeTutoria(Request $request)
    {
        $idDocente = Session::get('user_id');

        // Validar Hora
        if (!$this->verificarDisponibilidad($idDocente, $request->fecha, $request->hora)) {
            return back()
                ->withInput() // Mantiene los datos que el usuario escribió
                ->withErrors(['hora' => 'Ya tienes otra tutoría agendada en esta fecha y hora.']);
        }

        if ($request->tipo === 'grupal') {
            $request->validate([
                'grupo_id' => 'required|exists:GRUPO,id_grupo',
                'fecha' => 'required|date',
                'hora' => 'required',
                'tema' => 'required|string|max:200'
            ]);

            TutoriaGrupal::create([
                'tema' => $request->tema,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'id_docente' => $idDocente,
                'id_grupo' => $request->grupo_id
            ]);
        } else {
            $request->validate([
                'estudiante_id' => 'required|exists:ESTUDIANTE,id_estudiante',
                'fecha' => 'required|date',
                'hora' => 'required',
                'motivo' => 'required|string|max:255',
                'observaciones' => 'nullable|string',
                'asistencia' => 'nullable|boolean'
            ]);

            $estadoAsistencia = $request->has('asistencia') ? $request->asistencia : null;

            TutoriaIndividual::create([
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'motivo' => $request->motivo,
                'asistencia' => $estadoAsistencia,
                'observaciones' => $request->observaciones ?? 'Sin observaciones registradas',
                'id_estudiante' => $request->estudiante_id,
                'id_docente' => $idDocente
            ]);
        }

        return back()->with('success', 'Tutoría registrada exitosamente.');
    }

    /**
     * 4. ACTUALIZAR TUTORÍA (POST) - CON VALIDACIÓN DE HORARIO
     */
    public function updateTutoria(Request $request)
    {
        $idDocente = Session::get('user_id');

        // Validar Hora (Ignorando la tutoría actual para que no choque consigo misma)
        if (!$this->verificarDisponibilidad($idDocente, $request->fecha, $request->hora, $request->tipo, $request->id_tutoria)) {
            return back()
                ->withErrors(['error' => 'No se pudo actualizar: Ya tienes otra tutoría en ese horario.']);
        }

        if ($request->tipo === 'grupal') {
            $request->validate([
                'id_tutoria' => 'required|exists:tutoria_grupal,id_tutoria_grupal',
                'fecha' => 'required|date',
                'hora' => 'required',
                'tema' => 'required|string|max:200',
                'asistencias' => 'nullable|array'
            ]);

            $tutoria = TutoriaGrupal::where('id_tutoria_grupal', $request->id_tutoria)
                ->where('id_docente', $idDocente)
                ->firstOrFail();

            $tutoria->update([
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'tema' => $request->tema
            ]);

            if ($request->has('asistencias')) {
                foreach ($request->asistencias as $idEstudiante => $estadoAsistencia) {
                    DetalleTutoriaGrupal::updateOrCreate(
                        [
                            'id_tutoria' => $tutoria->id_tutoria_grupal,
                            'id_estudiante' => $idEstudiante
                        ],
                        [
                            'asistencia' => $estadoAsistencia,
                            'observaciones' => ''
                        ]
                    );
                }
            }
        } else {
            $request->validate([
                'id_tutoria' => 'required|exists:tutoria_individual,id_tutoria_individual',
                'fecha' => 'required|date',
                'hora' => 'required',
                'motivo' => 'required|string|max:255',
                'observaciones' => 'nullable|string',
                'asistencia' => 'nullable|boolean'
            ]);

            $tutoria = TutoriaIndividual::where('id_tutoria_individual', $request->id_tutoria)
                ->where('id_docente', $idDocente)
                ->firstOrFail();

            $estadoAsistencia = $request->has('asistencia') ? $request->asistencia : null;

            $tutoria->update([
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'motivo' => $request->motivo,
                'observaciones' => $request->observaciones,
                'asistencia' => $estadoAsistencia
            ]);
        }

        return back()->with('success', 'Tutoría actualizada correctamente.');
    }

    /**
     * FUNCIÓN AUXILIAR: Verifica si hay choque de horario
     */
    private function verificarDisponibilidad($idDocente, $fecha, $hora, $ignorarTipo = null, $ignorarId = null)
    {
        // 1. Buscar en Grupales
        $queryGrupal = TutoriaGrupal::where('id_docente', $idDocente)
            ->where('fecha', $fecha)
            ->where('hora', $hora);

        // Si estamos editando una grupal, ignoramos ese ID para que no choque consigo misma
        if ($ignorarTipo === 'grupal' && $ignorarId) {
            $queryGrupal->where('id_tutoria_grupal', '!=', $ignorarId);
        }

        if ($queryGrupal->exists()) {
            return false; // No disponible
        }

        // 2. Buscar en Individuales
        $queryIndividual = TutoriaIndividual::where('id_docente', $idDocente)
            ->where('fecha', $fecha)
            ->where('hora', $hora);

        if ($ignorarTipo === 'individual' && $ignorarId) {
            $queryIndividual->where('id_tutoria_individual', '!=', $ignorarId);
        }

        if ($queryIndividual->exists()) {
            return false; // No disponible
        }

        return true; // Disponible
    }

    /**
     * 5. VISTA: GESTIONAR CANALIZACIONES
     */
    public function viewCanalizaciones()
    {
        $idDocente = Session::get('user_id');
        $periodoActual = Periodo::where('activo', 1)->first();

        if (!$periodoActual) {
            return view('docente.canalizaciones', [
                'listaTutorias' => collect(),
                'areasCanalizacion' => [],
                'historialCanalizaciones' => collect()
            ])->with('error', 'No hay periodo activo.');
        }

        $fechaInicio = $periodoActual->fecha_inicio;
        $fechaFin = $periodoActual->fecha_fin;

        $tutoriasRaw = TutoriaIndividual::where('id_docente', $idDocente)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->with('estudiante')
            ->orderBy('fecha', 'desc')
            ->get();

        $listaTutorias = $tutoriasRaw->map(function ($t) {
            $nombreEst = $t->estudiante ? ($t->estudiante->nombre . ' ' . $t->estudiante->paterno) : 'Estudiante desconocido';
            $horaFormat = $t->hora ? \Carbon\Carbon::parse($t->hora)->format('H:i') : '';
            return (object)[
                'id' => $t->id_tutoria_individual,
                'descripcion' => $t->fecha . " " . $horaFormat . " - " . $nombreEst
            ];
        });

        $areasCanalizacion = AreaCanalizacion::all();

        $historialCanalizaciones = Canalizacion::whereHas('tutoria', function ($query) use ($idDocente) {
            $query->where('id_docente', $idDocente);
        })
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->with(['tutoria.estudiante', 'area'])
            ->orderBy('fecha', 'desc')
            ->get();

        return view('docente.canalizaciones', compact('listaTutorias', 'areasCanalizacion', 'historialCanalizaciones'));
    }

    /**
     * 6. GUARDAR CANALIZACIÓN (POST)
     */
    public function storeCanalizacion(Request $request)
    {
        $request->validate([
            'id_tutoria' => 'required|exists:tutoria_individual,id_tutoria_individual',
            'area_id' => 'required|exists:areas_canalizacion,id_area',
            'observaciones' => 'required|string'
        ]);

        Canalizacion::create([
            'fecha' => Carbon::now()->toDateString(),
            'estatus' => 'Pendiente',
            'observaciones' => $request->observaciones,
            'id_tutoria' => $request->id_tutoria,
            'id_area' => $request->area_id
        ]);

        return back()->with('success', 'Canalización enviada correctamente.');
    }

    /**
     * 7. ACTUALIZAR CANALIZACIÓN (PUT)
     */
    public function updateCanalizacion(Request $request, $id)
    {
        $request->validate([
            'area_id' => 'required|exists:areas_canalizacion,id_area',
            'observaciones' => 'required|string',
            'estatus' => 'required|string'
        ]);

        $canalizacion = Canalizacion::findOrFail($id);

        $canalizacion->update([
            'id_area' => $request->area_id,
            'observaciones' => $request->observaciones,
            'estatus' => $request->estatus
        ]);

        return back()->with('success', 'Canalización actualizada correctamente.');
    }

    // ==========================================
    // SECCIÓN PERFIL Y SEGURIDAD
    // ==========================================

    public function viewPerfil()
    {
        $idDocente = Session::get('user_id');
        $usuario = Docente::with('rol')->findOrFail($idDocente);
        return view('docente.perfil', compact('usuario'));
    }

    public function updatePassword(Request $request)
    {
        $idDocente = Session::get('user_id');
        $usuario = Docente::findOrFail($idDocente);

        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($usuario) {
                if (!Hash::check($value, $usuario->contrasena)) {
                    $fail('La contraseña actual ingresada no es correcta.');
                }
            }],
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Debes ingresar tu contraseña actual.',
            'password.confirmed' => 'La confirmación no coincide.',
        ]);

        $usuario->contrasena = Hash::make($request->password);
        $usuario->save();

        return back()->with('success', 'Contraseña actualizada exitosamente.');
    }

    // Formulario para editar foto -- DOCENTE
    public function editarFoto()
    {
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

        return view('docente.editar-foto', compact('usuario'));
    }

    // editar foto -- DOCENTE
    public function actualizarFoto(Request $request)
    {
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

       $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'foto.required' => 'Debes seleccionar una imagen.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif.',
            'foto.max' => 'La imagen no debe pesar más de 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior
            if ($usuario->foto && file_exists(storage_path('app/public/fotos/docentes/' . $usuario->foto))) {
                unlink(storage_path('app/public/fotos/docentes/' . $usuario->foto));
            }

            // Guardar nueva foto
            $extension = $request->file('foto')->getClientOriginalExtension();
            $nombreArchivo = $usuario->num_control . '.' . $extension;
            $path = $request->file('foto')->storeAs('fotos/docentes', $nombreArchivo, 'public');

            $usuario->foto = $nombreArchivo;
            $usuario->save();

            return redirect()->route('docente.perfil.view')->with('success', 'Foto actualizada correctamente.');
        }

        return back()->with('error', 'No se pudo subir la foto.');
    }

    // Eliminar foto -- DOCENTE
    public function eliminarFoto()
    {
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

        if ($usuario->foto) {
            $rutaArchivo = storage_path('app/public/fotos/docentes/' . $usuario->foto);
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }

            $usuario->foto = null;
            $usuario->save();

            return redirect()->route('docente.perfil.view')->with('success', 'Foto eliminada correctamente.');
        }

        return back()->with('error', 'No hay foto para eliminar.');
    }
}
