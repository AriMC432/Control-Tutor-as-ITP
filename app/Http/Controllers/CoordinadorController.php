<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\Estudiante;
use App\Models\TutoriaIndividual;
use App\Models\TutoriaGrupal;
use App\Models\DetalleTutoriaGrupal;
use App\Models\Canalizacion;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\Grupo;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Password;


class CoordinadorController extends Controller
{

    // =========================================================
    // INICIO DEL COORDINADOR
    // =========================================================

    public function inicio()
    {
    $periodoActivo = DB::table('periodo')
    ->where('activo', 1)
    ->first();

$idUsuario = Session::get('user_id');
$usuario = Docente::findOrFail($idUsuario);

if (!$periodoActivo) {
    return view('coordinador.index', [
        'periodoActivo' => null,
        'usuario' => $usuario
    ]);
}

$idPeriodo = $periodoActivo->id_periodo;

// =====================================================
// 2. Contar tutores únicos que tienen grupos
// =====================================================

$totalTutores = DB::table('grupo')
    ->where('id_periodo', $idPeriodo)
    ->whereNotNull('id_docente')
    ->distinct('id_docente')
    ->count('id_docente');

        // =====================================================
        // 2. Contar grupos del periodo
        // =====================================================

        $totalGrupos = DB::table('grupo')
            ->where('id_periodo', $idPeriodo)
            ->count();


        // =====================================================
        // 3. Contar tutorías del periodo
        // =====================================================

        $inicioPeriodo = $periodoActivo->fecha_inicio;
        $finPeriodo = $periodoActivo->fecha_fin;


        // Tutorías grupales
        $grupalesPeriodo = DB::table('tutoria_grupal')
            ->whereBetween('fecha', [
                $inicioPeriodo,
                $finPeriodo
            ])
            ->count();


        // Tutorías individuales
        $individualesPeriodo = DB::table('tutoria_individual')
            ->whereBetween('fecha', [
                $inicioPeriodo,
                $finPeriodo
            ])
            ->count();


        // Total de tutorías
        $tutoriasPeriodo =
            $grupalesPeriodo +
            $individualesPeriodo;


        // =====================================================
        // 4. Obtener IDs de grupos del periodo activo
        // =====================================================

        $gruposIds = DB::table('grupo')
            ->where('id_periodo', $idPeriodo)
            ->pluck('id_grupo');


        // =====================================================
        // 5. Calcular asistencia promedio
        // =====================================================


        // -----------------------------------------------------
        // Asistencia de tutorías individuales
        // -----------------------------------------------------

        $asistenciaIndividual = DB::table('tutoria_individual')
            ->join(
                'estudiante',
                'tutoria_individual.id_estudiante',
                '=',
                'estudiante.id_estudiante'
            )
            ->whereIn(
                'estudiante.id_grupo',
                $gruposIds
            )
            ->whereNotNull(
                'tutoria_individual.asistencia'
            )
            ->avg(
                'tutoria_individual.asistencia'
            );


        // -----------------------------------------------------
        // Asistencia de tutorías grupales
        // -----------------------------------------------------

        $asistenciaGrupal = DB::table('detalle_tutoria_grupal')
            ->join(
                'tutoria_grupal',
                'detalle_tutoria_grupal.id_tutoria',
                '=',
                'tutoria_grupal.id_tutoria_grupal'
            )
            ->whereIn(
                'tutoria_grupal.id_grupo',
                $gruposIds
            )
            ->whereNotNull(
                'detalle_tutoria_grupal.asistencia'
            )
            ->avg(
                'detalle_tutoria_grupal.asistencia'
            );


        // =====================================================
        // Cantidad de registros individuales
        // =====================================================

        $totalIndividuales = DB::table('tutoria_individual')
            ->join(
                'estudiante',
                'tutoria_individual.id_estudiante',
                '=',
                'estudiante.id_estudiante'
            )
            ->whereIn(
                'estudiante.id_grupo',
                $gruposIds
            )
            ->whereNotNull(
                'tutoria_individual.asistencia'
            )
            ->count();


        // =====================================================
        // Cantidad de registros grupales
        // =====================================================

        $totalGrupales = DB::table('detalle_tutoria_grupal')
            ->join(
                'tutoria_grupal',
                'detalle_tutoria_grupal.id_tutoria',
                '=',
                'tutoria_grupal.id_tutoria_grupal'
            )
            ->whereIn(
                'tutoria_grupal.id_grupo',
                $gruposIds
            )
            ->whereNotNull(
                'detalle_tutoria_grupal.asistencia'
            )
            ->count();


        // =====================================================
        // Total de registros de asistencia
        // =====================================================

        $totalRegistros =
        $totalIndividuales +
        $totalGrupales;


        // =====================================================
        // Calcular promedio final
        // =====================================================

        if ($totalRegistros > 0) {

            $sumaIndividual =
                ($asistenciaIndividual ?? 0) *
                $totalIndividuales;

            $sumaGrupal =
                ($asistenciaGrupal ?? 0) *
                $totalGrupales;


            $asistenciaPromedio = round(
                (
                    ($sumaIndividual + $sumaGrupal)
                    / $totalRegistros
                ) * 100,
                1
            );

        } else {

            $asistenciaPromedio = 0;
        }


        // =====================================================
        // Enviar información a la vista
        // =====================================================

        return view(
            'coordinador.index',
            compact(
            'periodoActivo',
            'usuario',
            'totalTutores',
            'totalGrupos',
            'tutoriasPeriodo',
            'asistenciaPromedio'
)
        );
    }


    // =========================================================
    // INFORMES
    // =========================================================
  
public function informes()
{
    $periodoActual = Periodo::where('activo', 1)->first();

    $tutores = Docente::whereHas('grupos', function ($query) use ($periodoActual) {
        if ($periodoActual) {
            $query->where('id_periodo', $periodoActual->id_periodo);
        }
    })
    ->orderBy('nombre')
    ->get();

    return view('coordinador.informes', compact(
        'periodoActual',
        'tutores'
    ));
}


    // =========================================================
    // SUBIR INFORME
   // =========================================================
    public function subirInforme(Request $request)
        {
            $request->validate([
                'id_docente' => 'required|exists:docentes,id_docente',
                'periodo' => 'required|date_format:Y-m',
                'informe' => 'required|file|mimes:pdf,xlsx,xls|max:10240',
            ]);

            // Por ahora, validar los datos no significa que el informe
            // ya esté registrado en la base de datos.
            return back()->with(
                'error',
                'El formulario ya recibió los datos, pero falta configurar el registro del informe en la base de datos.'
            );
        }

    // =========================================================
    // REPORTES
    // =========================================================

    public function reportes()
    {
        // Obtener carreras
        $carreras = \App\Models\Carrera::all();

        // Obtener periodos
        $periodos = \App\Models\Periodo::orderBy(
            'fecha_inicio',
            'desc'
        )->get();

        // Obtener periodo activo
        $periodoActivo = \App\Models\Periodo::where(
            'activo',
            1
        )->first();

        return view(
            'coordinador.reportes',
            compact(
                'carreras',
                'periodos',
                'periodoActivo'
            )
        );
    }


    // =========================================================
    // SEGUIMIENTO A TUTORES
    // =========================================================

    public function seguimiento(Request $request)
    {
        $periodoActual = Periodo::where(
            'activo',
            1
        )->first();


        if (!$periodoActual) {

            return view(
                'coordinador.seguimiento',
                [
                    'seguimiento' => [],
                    'periodoActual' => null
                ]
            );
        }


        // =====================================================
        // Rango del mes actual
        // =====================================================

        $inicioMes = now()->startOfMonth();

        $finMes = now()->endOfMonth();


        // =====================================================
        // Obtener grupos con docentes y carreras
        // =====================================================

        $seguimiento = Grupo::where(
            'id_periodo',
            $periodoActual->id_periodo
        )
        ->with([
            'docente',
            'carrera'
        ])
        ->get()
        ->map(
            function ($grupo) use (
                $inicioMes,
                $finMes
            ) {


                // =================================================
                // Tutorías grupales del mes
                // =================================================

                $grupales = TutoriaGrupal::where(
                    'id_grupo',
                    $grupo->id_grupo
                )
                ->whereBetween(
                    'fecha',
                    [
                        $inicioMes,
                        $finMes
                    ]
                )
                ->count();


                // =================================================
                // Tutorías individuales del mes
                // =================================================

                $individuales = TutoriaIndividual::where(
                    'id_docente',
                    $grupo->id_docente
                )
                ->whereBetween(
                    'fecha',
                    [
                        $inicioMes,
                        $finMes
                    ]
                )
                ->count();


                // =================================================
                // Última sesión grupal
                // =================================================

                $ultimaG = TutoriaGrupal::where(
                    'id_grupo',
                    $grupo->id_grupo
                )
                ->max('fecha');


                // =================================================
                // Última sesión individual
                // =================================================

                $ultimaI = TutoriaIndividual::where(
                    'id_docente',
                    $grupo->id_docente
                )
                ->max('fecha');


                // Última sesión registrada
                $ultimaSesion = max(
                    $ultimaG,
                    $ultimaI
                );


                // =================================================
                // Promedio de asistencia individual
                // =================================================

                $asistenciaProm =
                    TutoriaIndividual::where(
                        'id_docente',
                        $grupo->id_docente
                    )
                    ->whereNotNull('asistencia')
                    ->avg('asistencia')
                    ?? 0;


                // =================================================
                // Crear registro para la vista
                // =================================================

                return (object) [

                    'tutor' =>
                        ($grupo->docente?->nombre ?? 'Sin')
                        . ' ' .
                        ($grupo->docente?->paterno ?? 'Asignar'),

                    'grupo' =>
                        $grupo->nombre,

                    'carrera' =>
                        $grupo->carrera->nombre
                        ?? 'N/A',

                    'tutorias_mes' =>
                        $grupales + $individuales,

                    'asistencia_prom' =>
                        round(
                            $asistenciaProm * 100,
                            0
                        ),

                    'ultima_sesion' =>
                        $ultimaSesion
                        ? Carbon::parse(
                            $ultimaSesion
                        )->format('d/m/Y')
                        : 'Sin sesiones',

                    'estado' =>
                        (
                            $grupales + $individuales > 0
                        )
                        ? 'Activo'
                        : 'Pendiente'
                ];
            }
        );


        return view(
            'coordinador.seguimiento',
            compact(
                'seguimiento',
                'periodoActual'
            )
        );
    }


    // =========================================================
    // PERFIL DEL COORDINADOR
    // =========================================================

    public function viewPerfil()
    {
        // Obtener ID del usuario que inició sesión
        $idUsuario = Session::get('user_id');


        // Obtener periodo activo
        $periodoActual = Periodo::where(
            'activo',
            1
        )->first();


        // =====================================================
        // Buscar al coordinador
        // =====================================================

        $usuario = Docente::with('rol')
            ->findOrFail($idUsuario);


        // =====================================================
        // NUEVO:
        // Guardar la fotografía actual en la sesión.
        //
        // El encabezado app.blade.php utiliza:
        //
        // session('user_photo')
        //
        // para mostrar el avatar.
        // =====================================================

        Session::put(
            'user_photo',
            $usuario->foto ?? null
        );


        return view(
            'coordinador.perfil',
            compact(
                'usuario',
                'periodoActual'
            )
        );
    }


    // =========================================================
    // CAMBIAR CONTRASEÑA
    // =========================================================

    public function updatePassword(Request $request)
    {
        $idUsuario = Session::get('user_id');


        $usuario = Docente::findOrFail(
            $idUsuario
        );


        // =====================================================
        // Validación
        // =====================================================

        $request->validate(

            [
                'current_password' => [

                    'required',

                    function (
                        $attribute,
                        $value,
                        $fail
                    ) use ($usuario) {

                        if (
                            !Hash::check(
                                $value,
                                $usuario->contrasena
                            )
                        ) {

                            $fail(
                                'La contraseña actual ingresada no es correcta.'
                            );
                        }
                    }
                ],


                'password' => [

                    'required',

                    'string',

                    'confirmed',

                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised(),
                ],
            ],


            [
                'current_password.required' =>
                    'Debes ingresar tu contraseña actual para confirmar el cambio.',

                'password.required' =>
                    'La nueva contraseña es obligatoria.',

                'password.confirmed' =>
                    'La confirmación de la nueva contraseña no coincide.',

                'password.min' =>
                    'La contraseña debe tener al menos 8 caracteres.',

                'password.letters' =>
                    'La contraseña debe contener al menos una letra.',

                'password.mixed' =>
                    'La contraseña debe contener mayúsculas y minúsculas.',

                'password.numbers' =>
                    'La contraseña debe contener al menos un número.',

                'password.symbols' =>
                    'La contraseña debe contener al menos un símbolo.',

                'password.uncompromised' =>
                    'Esta contraseña es poco segura porque ha aparecido en filtraciones de datos. Elige una más original.',
            ]
        );


        // =====================================================
        // Actualizar contraseña
        // =====================================================

        $usuario->contrasena =
            Hash::make(
                $request->password
            );

        $usuario->save();


        return back()->with(
            'success',
            '¡Tu contraseña se cambió correctamente!'
        );
    }


    // =========================================================
    // FORMULARIO PARA EDITAR FOTO
    // =========================================================

    public function editarFoto()
    {
        $userId = Session::get(
            'user_id'
        );


        $usuario = Docente::findOrFail(
            $userId
        );


        return view(
            'coordinador.editar-foto',
            compact('usuario')
        );
    }


    // =========================================================
    // ACTUALIZAR FOTO
    // =========================================================

    public function actualizarFoto(Request $request)
    {
        $userId = Session::get(
            'user_id'
        );


        $usuario = Docente::findOrFail(
            $userId
        );


        // =====================================================
        // Validación de imagen
        // =====================================================

        $request->validate(

            [
                'foto' =>
                    'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],

            [
                'foto.required' =>
                    'Debes seleccionar una imagen.',

                'foto.image' =>
                    'El archivo debe ser una imagen.',

                'foto.mimes' =>
                    'La imagen debe ser de tipo: jpeg, png, jpg o gif.',

                'foto.max' =>
                    'La imagen no debe pesar más de 2MB.',
            ]
        );


        // =====================================================
        // Guardar fotografía
        // =====================================================

        if ($request->hasFile('foto')) {


            // -------------------------------------------------
            // Eliminar foto anterior
            // -------------------------------------------------

            if (
                $usuario->foto &&
                file_exists(
                    storage_path(
                        'app/public/fotos/docentes/'
                        . $usuario->foto
                    )
                )
            ) {

                unlink(
                    storage_path(
                        'app/public/fotos/docentes/'
                        . $usuario->foto
                    )
                );
            }


            // -------------------------------------------------
            // Obtener extensión
            // -------------------------------------------------

            $extension =
                $request
                    ->file('foto')
                    ->getClientOriginalExtension();


            // -------------------------------------------------
            // Nombre de archivo
            // -------------------------------------------------

            $nombreArchivo =
                $usuario->num_control
                . '.'
                . $extension;


            // -------------------------------------------------
            // Guardar archivo
            // -------------------------------------------------

            $path =
                $request
                    ->file('foto')
                    ->storeAs(
                        'fotos/docentes',
                        $nombreArchivo,
                        'public'
                    );


            // -------------------------------------------------
            // Guardar nombre en BD
            // -------------------------------------------------

            $usuario->foto =
                $nombreArchivo;

            $usuario->save();


            // =================================================
            // NUEVO:
            // Actualizar fotografía de la sesión.
            //
            // Esto hace que el encabezado cambie
            // inmediatamente al nuevo avatar.
            // =================================================

            Session::put(
                'user_photo',
                $nombreArchivo
            );


            return redirect()
                ->route(
                    'coordinador.perfil.view'
                )
                ->with(
                    'success',
                    'Foto actualizada correctamente.'
                );
        }


        return back()->with(
            'error',
            'No se pudo subir la foto.'
        );
    }


    // =========================================================
    // ELIMINAR FOTO
    // =========================================================

    public function eliminarFoto()
    {
        $userId = Session::get(
            'user_id'
        );


        $usuario = Docente::findOrFail(
            $userId
        );


        if ($usuario->foto) {


            // =================================================
            // Eliminar archivo físico
            // =================================================

            $rutaArchivo =
                storage_path(
                    'app/public/fotos/docentes/'
                    . $usuario->foto
                );


            if (file_exists($rutaArchivo)) {

                unlink($rutaArchivo);
            }


            // =================================================
            // Eliminar referencia de BD
            // =================================================

            $usuario->foto = null;

            $usuario->save();


            // =================================================
            // NUEVO:
            // Eliminar fotografía de la sesión.
            //
            // El encabezado volverá automáticamente
            // al ícono de usuario.
            // =================================================

            Session::forget(
                'user_photo'
            );


            return redirect()
                ->route(
                    'coordinador.perfil.view'
                )
                ->with(
                    'success',
                    'Foto eliminada correctamente.'
                );
        }


        return back()->with(
            'error',
            'No hay foto para eliminar.'
        );
    }


    // =========================================================
    // GENERAR ANEXO 20
    // =========================================================

    public function generarAnexo20(Request $request)
    {
        // Validar parámetros
        $request->validate(

            [
                'id_carrera' =>
                    'required|exists:carreras,id_carrera',

                'id_periodo' =>
                    'required|exists:periodo,id_periodo'
            ]
        );


        // Delegar al controlador específico
        $reporteController =
            new \App\Http\Controllers\ReporteAnexo20Controller();


        return $reporteController->generate(
            $request
        );
    }

}