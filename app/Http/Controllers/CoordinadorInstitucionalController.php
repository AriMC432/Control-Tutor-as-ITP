<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Estudiante;
use App\Models\Docente;
use App\Models\TutoriaIndividual;
use App\Models\TutoriaGrupal;
use App\Models\Canalizacion;
use App\Models\Grupo;
use App\Models\Periodo;
use App\Models\Carrera;
use App\Models\Rol;
use App\Models\AreaCanalizacion;
use Illuminate\Validation\Rules\Password;

class CoordinadorInstitucionalController extends Controller
{
    /**
     * mostrar dashboard principal con metricas institucionales
     */
    public function index()
    {
        // obtener totales basicos
        $totalEstudiantes = Estudiante::count();
        $totalDocentes = Docente::count();
        $totalGrupos = Grupo::count();
        $totalCarreras = Carrera::count();

        // obtener totales de tutorias
        $totalTutoriasIndividuales = TutoriaIndividual::count();
        $totalTutoriasGrupales = TutoriaGrupal::count();

        // obtener total de canalizaciones
        $totalCanalizaciones = Canalizacion::count();

        // obtener periodo activo
        $periodoActivo = Periodo::where('activo', 1)->first();

        // calcular tutorias del periodo activo
        $tutoriasIndividualesPeriodo = 0;
        $tutoriasGrupalesPeriodo = 0;

        if ($periodoActivo) {
            $tutoriasIndividualesPeriodo = TutoriaIndividual::whereBetween('fecha', [$periodoActivo->fecha_inicio, $periodoActivo->fecha_fin])->count();
            $tutoriasGrupalesPeriodo = TutoriaGrupal::whereBetween('fecha', [$periodoActivo->fecha_inicio, $periodoActivo->fecha_fin])->count();
        }

        // enviar datos a la vista
        return view('coordinador_institucional.index', compact(
            'totalEstudiantes',
            'totalDocentes',
            'totalGrupos',
            'totalCarreras',
            'totalTutoriasIndividuales',
            'totalTutoriasGrupales',
            'totalCanalizaciones',
            'periodoActivo',
            'tutoriasIndividualesPeriodo',
            'tutoriasGrupalesPeriodo'
        ));
    }

    /**
     * mostrar metricas de estudiantes 
     */
    public function estudiantes()
    {
        // obtener periodo activo
        $periodoActivo = Periodo::where('activo', 1)->first();

        // calcular metricas basicas
        $totalEstudiantes = Estudiante::count();
        $totalCarreras = Carrera::count();
        $totalGrupos = Grupo::count();

        // calcular promedio de estudiantes por grupo
        $promedioPorGrupo = $totalGrupos > 0 ? round($totalEstudiantes / $totalGrupos, 1) : 0;

        // calcular distribucion de estudiantes por carrera con porcentaje
        $carreras = Carrera::all();
        $estudiantesPorCarrera = [];

        foreach ($carreras as $carrera) {
            // contar estudiantes por carrera mediante relacion con grupo
            $total = Estudiante::whereHas('grupo', function ($q) use ($carrera) {
                $q->where('id_carrera', $carrera->id_carrera);
            })->count();

            if ($total > 0) {
                // calcular porcentaje respecto al total
                $porcentaje = $totalEstudiantes > 0 ? round(($total / $totalEstudiantes) * 100, 1) : 0;

                $estudiantesPorCarrera[] = (object) [
                    'nombre' => $carrera->nombre,
                    'total' => $total,
                    'porcentaje' => $porcentaje
                ];
            }
        }

        // ordenar de mayor a menor por cantidad
        usort($estudiantesPorCarrera, function ($a, $b) {
            return $b->total <=> $a->total;
        });

        // enviar datos a la vista
        return view('coordinador_institucional.estudiantes', compact(
            'periodoActivo',
            'totalEstudiantes',
            'totalCarreras',
            'promedioPorGrupo',
            'estudiantesPorCarrera'
        ));
    }

    /**
     * mostrar metricas de docentes
     */

    public function docentes()
    {
        // obtener periodo activo
        $periodoActivo = Periodo::where('activo', 1)->first();

        // calcular metricas basicas
        $totalDocentes = Docente::count();

        // contar docentes con grupos asignados (usando DB directo)
        $docentesConGrupo = DB::table('grupo')
            ->whereNotNull('id_docente')
            ->distinct('id_docente')
            ->count('id_docente');

        // calcular promedio de grupos por docente
        $totalGrupos = Grupo::count();
        $promedioGruposPorDocente = $totalDocentes > 0 ? round($totalGrupos / $totalDocentes, 1) : 0;

        // calcular distribucion de docentes por rol
        $roles = Rol::all();
        $docentesPorRol = [];

        foreach ($roles as $rol) {
            $total = Docente::where('id_rol', $rol->id_rol)->count();

            if ($total > 0) {
                $porcentaje = $totalDocentes > 0 ? round(($total / $totalDocentes) * 100, 1) : 0;

                $docentesPorRol[] = (object) [
                    'nombre' => $rol->nombre,
                    'total' => $total,
                    'porcentaje' => $porcentaje
                ];
            }
        }

        // ordenar de mayor a menor por cantidad
        usort($docentesPorRol, function ($a, $b) {
            return $b->total <=> $a->total;
        });

        // enviar datos a la vista
        return view('coordinador_institucional.docentes', compact(
            'periodoActivo',
            'totalDocentes',
            'docentesConGrupo',
            'promedioGruposPorDocente',
            'docentesPorRol'
        ));
    }

    /**
     * mostrar metricas de tutorias 
     */
        /**
     * mostrar metricas de tutorias 
     */
    public function tutorias()
    {
        // obtener periodo activo
        $periodoActivo = Periodo::where('activo', 1)->first();

        // calcular totales de tutorias
        $totalTutoriasIndividuales = TutoriaIndividual::count();
        $totalTutoriasGrupales = TutoriaGrupal::count();
        $totalTutorias = $totalTutoriasIndividuales + $totalTutoriasGrupales;

        // calcular asistencia promedio en tutorias individuales
        $asistenciaPromedio = TutoriaIndividual::whereNotNull('asistencia')
            ->selectRaw('AVG(CASE WHEN asistencia = 1 THEN 100 ELSE 0 END) as promedio')
            ->value('promedio');
        $asistenciaPromedio = round($asistenciaPromedio ?? 0);

        // calcular tutorias por mes con nombres en español
        $tutoriasIndividualesPorMes = TutoriaIndividual::select(
                DB::raw('YEAR(fecha) as anio'),
                DB::raw('MONTH(fecha) as mes_numero'),
                DB::raw("
                    ELT(MONTH(fecha),
                        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ) as mes_nombre
                "),
                DB::raw('COUNT(*) as total_individuales')
            )
            ->groupBy('anio', 'mes_numero', 'mes_nombre')
            ->orderBy('anio', 'desc')
            ->orderBy('mes_numero', 'desc')
            ->get();

        $tutoriasGrupalesPorMes = TutoriaGrupal::select(
                DB::raw('YEAR(fecha) as anio'),
                DB::raw('MONTH(fecha) as mes_numero'),
                DB::raw("
                    ELT(MONTH(fecha),
                        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ) as mes_nombre
                "),
                DB::raw('COUNT(*) as total_grupales')
            )
            ->groupBy('anio', 'mes_numero', 'mes_nombre')
            ->orderBy('anio', 'desc')
            ->orderBy('mes_numero', 'desc')
            ->get();

        // combinar resultados en una sola coleccion
        $tutoriasPorMes = collect();
        
        foreach ($tutoriasIndividualesPorMes as $item) {
            $grupales = $tutoriasGrupalesPorMes->firstWhere(function($g) use ($item) {
                return $g->anio == $item->anio && $g->mes_numero == $item->mes_numero;
            });
            
            $tutoriasPorMes->push((object)[
                'mes' => $item->mes_nombre . ' ' . $item->anio,
                'individuales' => $item->total_individuales,
                'grupales' => $grupales ? $grupales->total_grupales : 0,
                'total' => $item->total_individuales + ($grupales ? $grupales->total_grupales : 0)
            ]);
        }
        
        // agregar meses donde solo hay tutorias grupales
        foreach ($tutoriasGrupalesPorMes as $item) {
            $yaExiste = $tutoriasPorMes->firstWhere(function($t) use ($item) {
                return strpos($t->mes, $item->mes_nombre) !== false && strpos($t->mes, (string)$item->anio) !== false;
            });
            
            if (!$yaExiste) {
                $tutoriasPorMes->push((object)[
                    'mes' => $item->mes_nombre . ' ' . $item->anio,
                    'individuales' => 0,
                    'grupales' => $item->total_grupales,
                    'total' => $item->total_grupales
                ]);
            }
        }
        
        // ordenar por fecha descendente
        $tutoriasPorMes = $tutoriasPorMes->sortByDesc(function($item) {
            preg_match('/([A-Za-z]+) (\d{4})/', $item->mes, $matches);
            if (count($matches) == 3) {
                $mesesNumeros = [
                    'Enero' => 1, 'Febrero' => 2, 'Marzo' => 3, 'Abril' => 4,
                    'Mayo' => 5, 'Junio' => 6, 'Julio' => 7, 'Agosto' => 8,
                    'Septiembre' => 9, 'Octubre' => 10, 'Noviembre' => 11, 'Diciembre' => 12
                ];
                $anio = (int)$matches[2];
                $mesNumero = $mesesNumeros[$matches[1]] ?? 0;
                return $anio * 100 + $mesNumero;
            }
            return 0;
        })->values();

        // calcular tutorias por docente (sin nombres)
        $tutoriasPorDocente = TutoriaIndividual::select('id_docente', DB::raw('count(*) as total'))
            ->groupBy('id_docente')
            ->get();

        $totalDocentesConTutorias = $tutoriasPorDocente->count();
        $promedioTutoriasPorDocente = $totalDocentesConTutorias > 0
            ? round($totalTutorias / $totalDocentesConTutorias, 1)
            : 0;

        // enviar datos a la vista
        return view('coordinador_institucional.tutorias', compact(
            'periodoActivo',
            'totalTutoriasIndividuales',
            'totalTutoriasGrupales',
            'totalTutorias',
            'asistenciaPromedio',
            'tutoriasPorMes',
            'promedioTutoriasPorDocente',
            'totalDocentesConTutorias'
        ));
    }

    /**
     * mostrar metricas de canalizaciones
     */
    public function canalizaciones()
    {
        // obtener periodo activo
        $periodoActivo = Periodo::where('activo', 1)->first();

        // calcular metricas basicas
        $totalCanalizaciones = Canalizacion::count();

        // calcular canalizaciones por estatus
        $atendidas = Canalizacion::where('estatus', 'Atendido')->count();
        $enProceso = Canalizacion::where('estatus', 'En Proceso')->count();
        $pendientes = Canalizacion::where('estatus', 'Pendiente')->count();

        // calcular tasa de atencion
        $tasaAtencion = $totalCanalizaciones > 0 ? round(($atendidas / $totalCanalizaciones) * 100, 1) : 0;

        // calcular canalizaciones por area
        $areas = AreaCanalizacion::all();
        $canalizacionesPorArea = [];

        foreach ($areas as $area) {
            $total = Canalizacion::where('id_area', $area->id_area)->count();

            if ($total > 0) {
                $porcentaje = $totalCanalizaciones > 0 ? round(($total / $totalCanalizaciones) * 100, 1) : 0;

                $canalizacionesPorArea[] = (object) [
                    'nombre' => $area->nombre,
                    'total' => $total,
                    'porcentaje' => $porcentaje,
                    'descripcion' => $area->descripcion
                ];
            }
        }

        // ordenar de mayor a menor por cantidad
        usort($canalizacionesPorArea, function ($a, $b) {
            return $b->total <=> $a->total;
        });

        // enviar datos a la vista
        return view('coordinador_institucional.canalizaciones', compact(
            'periodoActivo',
            'totalCanalizaciones',
            'atendidas',
            'enProceso',
            'pendientes',
            'tasaAtencion',
            'canalizacionesPorArea'
        ));
    }

    /**
     * mostrar perfil del coordinador institucional
     */
    public function perfil()
    {
        // obtener usuario de sesion
        $idUsuario = Session::get('user_id');
        $usuario = Docente::with('rol')->findOrFail($idUsuario);
        $periodoActivo = Periodo::where('activo', 1)->first();

        // construir url de foto
        if ($usuario->foto) {
            $usuario->foto_url = asset('storage/fotos/docentes/' . $usuario->foto);
        } else {
            $usuario->foto_url = asset('images/default-avatar.png');
        }

        // enviar datos a la vista
        return view('coordinador_institucional.perfil', compact('usuario'));
    }

    /**
     * actualizar perfil del coordinador institucional
     */
    public function updatePerfil(Request $request)
    {
        // obtener usuario de sesion
        $idUsuario = Session::get('user_id');
        $usuario = Docente::findOrFail($idUsuario);

        // validar datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'paterno' => 'required|string|max:100',
            'materno' => 'nullable|string|max:100',
            'correo' => 'required|email|max:100|unique:docente,correo,' . $idUsuario . ',id_docente',
        ]);

        // actualizar datos
        $usuario->nombre = $request->nombre;
        $usuario->paterno = $request->paterno;
        $usuario->materno = $request->materno;
        $usuario->correo = $request->correo;
        $usuario->save();

        // actualizar nombre en sesion
        Session::put('user_name', $usuario->nombre . ' ' . $usuario->paterno);

        // redirigir con mensaje de exito
        return back()->with('success', 'perfil actualizado correctamente');
    }

    /**
     * actualizar contrasena del coordinador institucional
     */
    public function updatePassword(Request $request)
    {
        $idUsuario = Session::get('user_id');
        $usuario = Docente::findOrFail($idUsuario);

        // 1. Validación de datos con reglas de alta seguridad
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($usuario) {
                    if (!Hash::check($value, $usuario->contrasena)) {
                        $fail('La contraseña actual ingresada no es correcta.');
                    }
                }
            ],

            // Nueva contraseña: Reglas robustas (8 caracteres + complejidad)
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()      // Requiere al menos una letra
                    ->mixedCase()    // Requiere mayúsculas y minúsculas
                    ->numbers()      // Requiere al menos un número
                    ->symbols()      // Requiere al menos un símbolo (!@#$%...)
                    ->uncompromised(), // Verifica que no haya sido filtrada en internet
            ],

        ], [
            // Mensajes de error personalizados en español
            'current_password.required' => 'Debes ingresar tu contraseña actual para confirmar el cambio.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.letters' => 'La contraseña debe contener al menos una letra.',
            'password.mixed' => 'La contraseña debe contener mayúsculas y minúsculas.',
            'password.numbers' => 'La contraseña debe contener al menos un número.',
            'password.symbols' => 'La contraseña debe contener al menos un símbolo.',
            'password.uncompromised' => 'Esta contraseña es poco segura por filtraciones previas. Elige otra.',
        ]);

        // 2. Actualizar la contraseña con Hash
        $usuario->contrasena = Hash::make($request->password);
        $usuario->save();

        // 3. Redireccionar con éxito
        return back()->with('success', 'Contraseña actualizada exitosamente.');
    }

    /**
     * mostrar formulario para editar foto de perfil
     */
    public function editarFoto()
    {
        // obtener usuario de sesion
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

        // construir url de foto
        if ($usuario->foto) {
            $usuario->foto_url = asset('storage/fotos/docentes/' . $usuario->foto);
        } else {
            $usuario->foto_url = asset('images/default-avatar.png');
        }

        // enviar datos a la vista
        return view('coordinador_institucional.editar-foto', compact('usuario'));
    }

    /**
     * actualizar foto de perfil del coordinador institucional
     */
    public function actualizarFoto(Request $request)
    {
        // obtener usuario de sesion
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

        // validar archivo de imagen
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // procesar archivo
        if ($request->hasFile('foto')) {
            // eliminar foto anterior si existe
            if ($usuario->foto && file_exists(storage_path('app/public/fotos/docentes/' . $usuario->foto))) {
                unlink(storage_path('app/public/fotos/docentes/' . $usuario->foto));
            }

            // guardar nueva foto
            $extension = $request->file('foto')->getClientOriginalExtension();
            $nombreArchivo = $usuario->num_control . '.' . $extension;
            $request->file('foto')->storeAs('fotos/docentes', $nombreArchivo, 'public');

            // actualizar registro en base de datos
            $usuario->foto = $nombreArchivo;
            $usuario->save();

            // redirigir con mensaje de exito
            return redirect()->route('coordinst.perfil.view')->with('success', 'foto actualizada correctamente');
        }

        // redirigir con mensaje de error
        return back()->with('error', 'no se pudo subir la foto');
    }

    /**
     * eliminar foto de perfil del coordinador institucional
     */
    public function eliminarFoto()
    {
        // obtener usuario de sesion
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

        // eliminar archivo si existe
        if ($usuario->foto) {
            $rutaArchivo = storage_path('app/public/fotos/docentes/' . $usuario->foto);
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }

            // actualizar registro en base de datos
            $usuario->foto = null;
            $usuario->save();

            // redirigir con mensaje de exito
            return redirect()->route('coordinst.perfil.view')->with('success', 'foto eliminada correctamente');
        }

        // redirigir con mensaje de error
        return back()->with('error', 'no hay foto para eliminar');
    }
}
