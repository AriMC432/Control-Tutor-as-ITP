<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Estudiante;
use App\Models\TutoriaIndividual;
use App\Models\TutoriaGrupal;
use App\Models\Canalizacion;
use App\Models\Periodo;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlumnoController extends Controller
{
    /**
     * DASHBOARD: Estadísticas del semestre ACTUAL.
     */
    public function inicioalumno()
    {
        $studentId = Session::get('user_id');

        if (!$studentId) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        $nombre = Session::get('user_name', 'Estudiante');

        // Recuperar datos del estudiante para saber su grupo
        $estudiante = Estudiante::find($studentId);
        $idGrupo = $estudiante ? $estudiante->id_grupo : null;

        // 1. OBTENER PERIODO ACTUAL
        $periodoActual = Periodo::where('activo', 1)->first();
        $nombrePeriodo = 'Sin Periodo Activo';

        // Valores por defecto
        $totalAsistidas = 0;
        $porcentajeAsistencia = '100%';
        $totalCanalizaciones = 0;
        $tutoriasRecientes = collect();

        if ($periodoActual) {
            $nombrePeriodo = $periodoActual->nombre;
            $inicio = $periodoActual->fecha_inicio;
            $fin = $periodoActual->fecha_fin;

            // --- 2. OBTENCIÓN DE DATOS (CONSULTAS) ---

            // A. Individuales (Directo del alumno)
            $tutoriasInd = TutoriaIndividual::where('id_estudiante', $studentId)
                ->whereBetween('fecha', [$inicio, $fin])
                ->with('docente')
                ->get();

            // B. Grupales (Del grupo del alumno)
            // Traemos TODAS las sesiones del grupo, y cargamos la asistencia de ESTE alumno si existe
            $tutoriasGrup = collect();
            if ($idGrupo) {
                $tutoriasGrup = TutoriaGrupal::where('id_grupo', $idGrupo)
                    ->whereBetween('fecha', [$inicio, $fin])
                    ->with(['docente', 'detalles' => function ($q) use ($studentId) {
                        // Solo cargamos el detalle de ESTE alumno
                        $q->where('id_estudiante', $studentId);
                    }])
                    ->get();
            }

            // --- 3. CÁLCULO DE ESTADÍSTICAS ---

            // Contadores Individuales
            $asistidasInd = $tutoriasInd->where('asistencia', 1)->count();
            $evaluablesInd = $tutoriasInd->whereNotNull('asistencia')->count();

            // Contadores Grupales (Procesando la colección)
            $asistidasGrup = 0;
            $evaluablesGrup = 0;

            foreach ($tutoriasGrup as $tg) {
                // Obtenemos el registro de asistencia del alumno para esta sesión
                $detalle = $tg->detalles->first();

                if ($detalle && !is_null($detalle->asistencia)) {
                    $evaluablesGrup++; // Sí se tomó lista
                    if ($detalle->asistencia == 1) {
                        $asistidasGrup++; // Y asistió
                    }
                }
            }

            // Totales Finales
            $totalAsistidas = $asistidasInd + $asistidasGrup;
            $universoEvaluable = $evaluablesInd + $evaluablesGrup;

            // Porcentaje (Solo sobre lo evaluado)
            if ($universoEvaluable > 0) {
                $porcentajeAsistencia = round(($totalAsistidas / $universoEvaluable) * 100) . '%';
            }

            // C. Canalizaciones
            $totalCanalizaciones = Canalizacion::whereHas('tutoria', function ($q) use ($studentId, $inicio, $fin) {
                $q->where('id_estudiante', $studentId)
                    ->whereBetween('fecha', [$inicio, $fin]);
            })->count();


            // --- 4. LISTA DE ACTIVIDAD RECIENTE ---

            $listaInd = $tutoriasInd->map(function ($t) {
                return (object)[
                    'tipo' => 'Individual',
                    'tema' => $t->motivo,
                    'fecha' => $t->fecha,
                    'tutor' => optional($t->docente)->nombre . ' ' . optional($t->docente)->paterno,
                    'estado_clase' => is_null($t->asistencia) ? 'warning' : ($t->asistencia == 1 ? 'success' : 'danger'),
                    'estado_texto' => is_null($t->asistencia) ? 'Pendiente' : ($t->asistencia == 1 ? 'Asistió' : 'Faltó')
                ];
            });

            $listaGrup = $tutoriasGrup->map(function ($tg) {
                $detalle = $tg->detalles->first();
                $asistencia = $detalle ? $detalle->asistencia : null; // Si no hay detalle, es null (Pendiente)

                return (object)[
                    'tipo' => 'Grupal',
                    'tema' => $tg->tema,
                    'fecha' => $tg->fecha,
                    'tutor' => optional($tg->docente)->nombre . ' ' . optional($tg->docente)->paterno,
                    'estado_clase' => is_null($asistencia) ? 'warning' : ($asistencia == 1 ? 'success' : 'danger'),
                    'estado_texto' => is_null($asistencia) ? 'Pendiente' : ($asistencia == 1 ? 'Asistió' : 'Faltó')
                ];
            });

            $tutoriasRecientes = $listaInd->concat($listaGrup)->sortByDesc('fecha')->take(5);
        }

        return view('alumno.index', [
            'nombre' => $nombre,
            'totalTutorias' => $totalAsistidas,
            'asistencia' => $porcentajeAsistencia,
            'totalCanalizaciones' => $totalCanalizaciones,
            'tutorias' => $tutoriasRecientes,
            'periodo' => $nombrePeriodo
        ]);
    }

    /**
     * PERFIL
     */
    public function perfil()
    {
        $studentId = Session::get('user_id');
        if (!$studentId) return redirect()->route('login');

        $estudiante = Estudiante::with('grupo')->find($studentId);
        if (!$estudiante) return redirect()->route('login');

        return view('alumno.perfil', compact('estudiante'));
    }

    /**
     * UPDATE PASSWORD
     */
    public function updatePasswordAlumno(Request $request)
    {
        $studentId = Session::get('user_id');
        $estudiante = Estudiante::findOrFail($studentId);

        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($estudiante) {
                if (!Hash::check($value, $estudiante->contrasena)) {
                    $fail('La contraseña actual ingresada no es correcta.');
                }
            }],
            'password' => 'required|string|min:6|confirmed',
        ]);

        $estudiante->contrasena = Hash::make($request->password);
        $estudiante->save();

        return back()->with('success', 'Contraseña actualizada exitosamente.');
    }

    /**
     * CANALIZACIONES
     */
    public function canalizaciones()
    {
        $studentId = Session::get('user_id');
        if (!$studentId) return redirect()->route('login');

        $periodoActual = Periodo::where('activo', 1)->first();
        $canalizaciones = collect();

        if ($periodoActual) {
            $inicio = $periodoActual->fecha_inicio;
            $fin = $periodoActual->fecha_fin;

            $canalizaciones = Canalizacion::whereHas('tutoria', function ($q) use ($studentId, $inicio, $fin) {
                $q->where('id_estudiante', $studentId)
                    ->whereBetween('fecha', [$inicio, $fin]);
            })
                ->with('area')
                ->orderBy('fecha', 'desc')
                ->get()
                ->map(function ($c) {

                    $clase = 'secondary';
                    switch ($c->estatus) {
                        case 'Pendiente':
                            $clase = 'warning text-dark';
                            break;
                        case 'En Proceso':
                            $clase = 'primary';
                            break;
                        case 'Atendido':
                            $clase = 'success';
                            break;
                        case 'Cancelado':
                            $clase = 'danger';
                            break;
                    }

                    return [
                        'fecha' => $c->fecha,
                        'area' => optional($c->area)->nombre,
                        'estatus' => $c->estatus,
                        'observaciones' => $c->observaciones,
                        'clase_estatus' => $clase
                    ];
                });
        }

        return view('alumno.canalizaciones', compact('canalizaciones', 'periodoActual'));
    }

    /**
     * HISTORIAL COMPLETO
     */
    public function tutorias()
    {
        $studentId = Session::get('user_id');
        if (!$studentId) return redirect()->route('login');

        // Recuperar Grupo
        $estudiante = Estudiante::find($studentId);
        $idGrupo = $estudiante ? $estudiante->id_grupo : null;

        $periodoActual = Periodo::where('activo', 1)->first();
        $todas = collect();

        if ($periodoActual) {
            $inicio = $periodoActual->fecha_inicio;
            $fin = $periodoActual->fecha_fin;

            // 1. Individuales
            $individuales = TutoriaIndividual::where('id_estudiante', $studentId)
                ->whereBetween('fecha', [$inicio, $fin])
                ->with('docente')
                ->get()
                ->map(function ($t) {
                    $estado = is_null($t->asistencia) ? 'Pendiente' : ($t->asistencia == 1 ? 'Asistió' : 'Faltó');
                    $clase = is_null($t->asistencia) ? 'warning' : ($t->asistencia == 1 ? 'success' : 'danger');

                    return [
                        'tipo' => 'Individual',
                        'tema' => $t->motivo,
                        'fecha' => $t->fecha,
                        'tutor' => optional($t->docente)->nombre . ' ' . optional($t->docente)->paterno,
                        'asistencia' => $estado,
                        'observaciones' => $t->observaciones ?? 'N/A',
                        'clase_asistencia' => $clase,
                    ];
                });

            // 2. Grupales (Consulta al Grupo + Detalle)
            $grupales = collect();
            if ($idGrupo) {
                $grupales = TutoriaGrupal::where('id_grupo', $idGrupo)
                    ->whereBetween('fecha', [$inicio, $fin])
                    ->with(['docente', 'detalles' => function ($q) use ($studentId) {
                        $q->where('id_estudiante', $studentId);
                    }])
                    ->get()
                    ->map(function ($tg) {
                        $detalle = $tg->detalles->first();
                        $asistencia = $detalle ? $detalle->asistencia : null;

                        $estado = is_null($asistencia) ? 'Pendiente' : ($asistencia == 1 ? 'Asistió' : 'Faltó');
                        $clase = is_null($asistencia) ? 'warning' : ($asistencia == 1 ? 'success' : 'danger');

                        return [
                            'tipo' => 'Grupal',
                            'tema' => $tg->tema,
                            'fecha' => $tg->fecha,
                            'tutor' => optional($tg->docente)->nombre . ' ' . optional($tg->docente)->paterno,
                            'asistencia' => $estado,
                            'observaciones' => $detalle->observaciones ?? 'N/A',
                            'clase_asistencia' => $clase,
                        ];
                    });
            }

            $todas = $individuales->concat($grupales)->sortByDesc('fecha')->values();
        }

        return view('alumno.tutorias', ['tutorias' => $todas, 'periodo' => $periodoActual]);
    }

    // Formulario para editar foto -- ALUMNO
    public function editarFoto()
    {
        $studentId = Session::get('user_id');
        $estudiante = Estudiante::findOrFail($studentId);

        return view('alumno.editar-foto', compact('estudiante'));
    }

    // Actualizar foto -- ALUMNO
    public function actualizarFoto(Request $request)
    {
        $studentId = Session::get('user_id');
        $estudiante = Estudiante::findOrFail($studentId);

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'foto.required' => 'Debes seleccionar una imagen.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif.',
            'foto.max' => 'La imagen no debe pesar más de 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($estudiante->foto && file_exists(storage_path('app/public/fotos/estudiantes/' . $estudiante->foto))) {
                unlink(storage_path('app/public/fotos/estudiantes/' . $estudiante->foto));
            }

            // Generar nombre del archivo: numero_control + extension
            $extension = $request->file('foto')->getClientOriginalExtension();
            $nombreArchivo = $estudiante->num_control . '.' . $extension;

            // Guardar en storage/app/public/fotos/estudiantes/
            $path = $request->file('foto')->storeAs('fotos/estudiantes', $nombreArchivo, 'public');

            // Actualizar base de datos
            $estudiante->foto = $nombreArchivo;
            $estudiante->save();

            return redirect()->route('alumno.perfil')->with('success', 'Foto actualizada correctamente.');
        }

        return back()->with('error', 'No se pudo subir la foto.');
    }

    // ELIMINAR Foto -- ALUMNO

    public function eliminarFoto()
    {
        $studentId = Session::get('user_id');
        $estudiante = Estudiante::findOrFail($studentId);

        if ($estudiante->foto) {
            // Eliminar archivo físico
            $rutaArchivo = storage_path('app/public/fotos/estudiantes/' . $estudiante->foto);
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }

            // Actualizar BD
            $estudiante->foto = null;
            $estudiante->save();

            return redirect()->route('alumno.perfil')->with('success', 'Foto eliminada correctamente.');
        }

        return back()->with('error', 'No hay foto para eliminar.');
    }
}
