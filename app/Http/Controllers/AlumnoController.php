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
use Illuminate\Validation\Rules\Password;

class AlumnoController extends Controller
{
    /**
     * =========================================================
     * DASHBOARD DEL ALUMNO
     * =========================================================
     */
    public function inicioalumno()
    {
        // =====================================================
        // 1. OBTENER ID DEL ALUMNO
        // =====================================================
        $studentId = Session::get('user_id');

        if (!$studentId) {
            return redirect()
                ->route('login')
                ->with('error', 'Debes iniciar sesión.');
        }

        // =====================================================
        // 2. OBTENER ALUMNO
        // =====================================================
        $estudiante = Estudiante::with('grupo')->find($studentId);

        if (!$estudiante) {
            Session::flush();

            return redirect()
                ->route('login')
                ->with('error', 'No se encontró el estudiante.');
        }

        // =====================================================
        // 3. ACTUALIZAR DATOS DE SESIÓN
        // =====================================================

        // Nombre
        $nombre = trim(
            ($estudiante->nombre ?? '') . ' ' .
            ($estudiante->paterno ?? '') . ' ' .
            ($estudiante->materno ?? '')
        );

        if (empty(trim($nombre))) {
            $nombre = Session::get('user_name', 'Estudiante');
        }

        Session::put('user_name', $nombre);

        // FOTO
        $foto = $estudiante->foto ?? null;

        Session::put('user_photo', $foto);

        // Tipo de usuario
        Session::put('user_role', 'Estudiante');

        // =====================================================
        // 4. GRUPO DEL ALUMNO
        // =====================================================
        $idGrupo = $estudiante->id_grupo ?? null;

        // =====================================================
        // 5. PERIODO ACTIVO
        // =====================================================
        $periodoActivo = DB::table('periodo')
            ->where('activo', 1)
            ->first();

        $periodoActual = Periodo::where('activo', 1)->first();

        $nombrePeriodo = 'Sin Periodo Activo';

        // =====================================================
        // 6. VALORES POR DEFECTO
        // =====================================================
        $totalAsistidas = 0;
        $porcentajeAsistencia = '100%';
        $totalCanalizaciones = 0;
        $tutoriasRecientes = collect();

        // =====================================================
        // 7. SI EXISTE PERIODO ACTIVO
        // =====================================================
        if ($periodoActual) {

            $nombrePeriodo = $periodoActual->nombre;

            $inicio = $periodoActual->fecha_inicio;
            $fin = $periodoActual->fecha_fin;

            // =================================================
            // TUTORÍAS INDIVIDUALES
            // =================================================
            $tutoriasInd = TutoriaIndividual::where(
                    'id_estudiante',
                    $studentId
                )
                ->whereBetween('fecha', [$inicio, $fin])
                ->with('docente')
                ->get();

            // =================================================
            // TUTORÍAS GRUPALES
            // =================================================
            $tutoriasGrup = collect();

            if ($idGrupo) {

                $tutoriasGrup = TutoriaGrupal::where(
                        'id_grupo',
                        $idGrupo
                    )
                    ->whereBetween('fecha', [$inicio, $fin])
                    ->with([
                        'docente',
                        'detalles' => function ($q) use ($studentId) {

                            $q->where(
                                'id_estudiante',
                                $studentId
                            );
                        }
                    ])
                    ->get();
            }

            // =================================================
            // ESTADÍSTICAS INDIVIDUALES
            // =================================================
            $asistidasInd = $tutoriasInd
                ->where('asistencia', 1)
                ->count();

            $evaluablesInd = $tutoriasInd
                ->whereNotNull('asistencia')
                ->count();

            // =================================================
            // ESTADÍSTICAS GRUPALES
            // =================================================
            $asistidasGrup = 0;
            $evaluablesGrup = 0;

            foreach ($tutoriasGrup as $tg) {

                $detalle = $tg->detalles->first();

                if (
                    $detalle &&
                    !is_null($detalle->asistencia)
                ) {

                    $evaluablesGrup++;

                    if ($detalle->asistencia == 1) {
                        $asistidasGrup++;
                    }
                }
            }

            // =================================================
            // TOTALES
            // =================================================
            $totalAsistidas =
                $asistidasInd +
                $asistidasGrup;

            $universoEvaluable =
                $evaluablesInd +
                $evaluablesGrup;

            // =================================================
            // PORCENTAJE
            // =================================================
            if ($universoEvaluable > 0) {

                $porcentajeAsistencia =
                    round(
                        ($totalAsistidas / $universoEvaluable) * 100
                    ) . '%';
            }

            // =================================================
            // CANALIZACIONES
            // =================================================
            $totalCanalizaciones =
                Canalizacion::whereHas(
                    'tutoria',
                    function ($q) use (
                        $studentId,
                        $inicio,
                        $fin
                    ) {

                        $q->where(
                            'id_estudiante',
                            $studentId
                        )
                        ->whereBetween(
                            'fecha',
                            [$inicio, $fin]
                        );
                    }
                )->count();

            // =================================================
            // ACTIVIDAD INDIVIDUAL
            // =================================================
            $listaInd = $tutoriasInd->map(
                function ($t) {

                    return (object) [

                        'tipo' => 'Individual',

                        'tema' => $t->motivo,

                        'fecha' => $t->fecha,

                        'tutor' =>
                            optional($t->docente)->nombre .
                            ' ' .
                            optional($t->docente)->paterno,

                        'estado_clase' =>
                            is_null($t->asistencia)
                                ? 'warning'
                                : (
                                    $t->asistencia == 1
                                        ? 'success'
                                        : 'danger'
                                ),

                        'estado_texto' =>
                            is_null($t->asistencia)
                                ? 'Pendiente'
                                : (
                                    $t->asistencia == 1
                                        ? 'Asistió'
                                        : 'Faltó'
                                )
                    ];
                }
            );

            // =================================================
            // ACTIVIDAD GRUPAL
            // =================================================
            $listaGrup = $tutoriasGrup->map(
                function ($tg) {

                    $detalle =
                        $tg->detalles->first();

                    $asistencia =
                        $detalle
                            ? $detalle->asistencia
                            : null;

                    return (object) [

                        'tipo' => 'Grupal',

                        'tema' => $tg->tema,

                        'fecha' => $tg->fecha,

                        'tutor' =>
                            optional($tg->docente)->nombre .
                            ' ' .
                            optional($tg->docente)->paterno,

                        'estado_clase' =>
                            is_null($asistencia)
                                ? 'warning'
                                : (
                                    $asistencia == 1
                                        ? 'success'
                                        : 'danger'
                                ),

                        'estado_texto' =>
                            is_null($asistencia)
                                ? 'Pendiente'
                                : (
                                    $asistencia == 1
                                        ? 'Asistió'
                                        : 'Faltó'
                                )
                    ];
                }
            );

            // =================================================
            // ÚLTIMAS 5 ACTIVIDADES
            // =================================================
            $tutoriasRecientes =
                $listaInd
                    ->concat($listaGrup)
                    ->sortByDesc('fecha')
                    ->take(5);
        }

        // =====================================================
        // 8. VISTA DEL ALUMNO
        // =====================================================
        return view(
            'alumno.index',
            compact(
                'nombre',
                'foto',
                'periodoActivo',
                'totalAsistidas',
                'porcentajeAsistencia',
                'totalCanalizaciones',
                'tutoriasRecientes'
            )
        );
    }


    /**
     * =========================================================
     * PERFIL
     * =========================================================
     */
    public function perfil()
    {
        $studentId = Session::get('user_id');

        if (!$studentId) {
            return redirect()->route('login');
        }

        // =====================================================
        // OBTENER ESTUDIANTE
        // =====================================================
        $estudiante =
            Estudiante::with('grupo')
                ->find($studentId);

        if (!$estudiante) {

            Session::flush();

            return redirect()->route('login');
        }

        // =====================================================
        // ACTUALIZAR FOTO EN SESIÓN
        // =====================================================
        $foto = $estudiante->foto ?? null;

        Session::put('user_photo', $foto);

        // =====================================================
        // ASEGURAR ROL
        // =====================================================
        Session::put('user_role', 'Estudiante');

        // =====================================================
        // PERIODO
        // =====================================================
        $periodoActual =
            Periodo::where('activo', 1)->first();

        return view(
            'alumno.perfil',
            compact(
                'estudiante',
                'periodoActual',
                'foto'
            )
        );
    }


    /**
     * =========================================================
     * ACTUALIZAR CONTRASEÑA
     * =========================================================
     */
    public function updatePasswordAlumno(
        Request $request
    ) {

        $studentId =
            Session::get('user_id');

        $estudiante =
            Estudiante::findOrFail($studentId);

        $request->validate(
            [

                'current_password' => [

                    'required',

                    function (
                        $attribute,
                        $value,
                        $fail
                    ) use ($estudiante) {

                        if (
                            !Hash::check(
                                $value,
                                $estudiante->contrasena
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

                'password.required' =>
                    'La nueva contraseña es obligatoria.',

                'password.confirmed' =>
                    'La confirmación de la contraseña no coincide.',

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
                    'Esta contraseña es poco segura por filtraciones externas. Intenta con otra.',
            ]
        );

        // =====================================================
        // GUARDAR CONTRASEÑA
        // =====================================================
        $estudiante->contrasena =
            Hash::make(
                $request->password
            );

        $estudiante->save();

        return back()->with(
            'success',
            '¡Tu contraseña ha sido actualizada con éxito!'
        );
    }


    /**
     * =========================================================
     * CANALIZACIONES
     * =========================================================
     */
    public function canalizaciones()
    {
        $studentId =
            Session::get('user_id');

        if (!$studentId) {
            return redirect()->route('login');
        }

        // =====================================================
        // ACTUALIZAR FOTO DE SESIÓN
        // =====================================================
        $estudiante =
            Estudiante::find($studentId);

        if ($estudiante) {

            Session::put(
                'user_photo',
                $estudiante->foto ?? null
            );

            Session::put(
                'user_role',
                'Estudiante'
            );
        }

        // =====================================================
        // PERIODO
        // =====================================================
        $periodoActual =
            Periodo::where('activo', 1)->first();

        $canalizaciones =
            collect();

        if ($periodoActual) {

            $inicio =
                $periodoActual->fecha_inicio;

            $fin =
                $periodoActual->fecha_fin;

            $canalizaciones =
                Canalizacion::whereHas(
                    'tutoria',
                    function ($q) use (
                        $studentId,
                        $inicio,
                        $fin
                    ) {

                        $q->where(
                            'id_estudiante',
                            $studentId
                        )
                        ->whereBetween(
                            'fecha',
                            [$inicio, $fin]
                        );
                    }
                )
                ->with('area')
                ->orderBy(
                    'fecha',
                    'desc'
                )
                ->get()
                ->map(
                    function ($c) {

                        $clase =
                            'secondary';

                        switch (
                            $c->estatus
                        ) {

                            case 'Pendiente':

                                $clase =
                                    'warning text-dark';

                                break;

                            case 'En Proceso':

                                $clase =
                                    'primary';

                                break;

                            case 'Atendido':

                                $clase =
                                    'success';

                                break;

                            case 'Cancelado':

                                $clase =
                                    'danger';

                                break;
                        }

                        return [

                            'fecha' =>
                                $c->fecha,

                            'area' =>
                                optional(
                                    $c->area
                                )->nombre,

                            'estatus' =>
                                $c->estatus,

                            'observaciones' =>
                                $c->observaciones,

                            'clase_estatus' =>
                                $clase
                        ];
                    }
                );
        }

        return view(
            'alumno.canalizaciones',
            compact(
                'canalizaciones',
                'periodoActual'
            )
        );
    }


    /**
     * =========================================================
     * HISTORIAL DE TUTORÍAS
     * =========================================================
     */
    public function tutorias()
    {
        $studentId =
            Session::get('user_id');

        if (!$studentId) {
            return redirect()->route('login');
        }

        // =====================================================
        // ACTUALIZAR FOTO DE SESIÓN
        // =====================================================
        $estudiante =
            Estudiante::find($studentId);

        $idGrupo =
            $estudiante
                ? $estudiante->id_grupo
                : null;

        if ($estudiante) {

            Session::put(
                'user_photo',
                $estudiante->foto ?? null
            );

            Session::put(
                'user_role',
                'Estudiante'
            );
        }

        // =====================================================
        // PERIODO
        // =====================================================
        $periodoActual =
            Periodo::where('activo', 1)->first();

        $todas =
            collect();

        if ($periodoActual) {

            $inicio =
                $periodoActual->fecha_inicio;

            $fin =
                $periodoActual->fecha_fin;

            // =================================================
            // INDIVIDUALES
            // =================================================
            $individuales =
                TutoriaIndividual::where(
                    'id_estudiante',
                    $studentId
                )
                ->whereBetween(
                    'fecha',
                    [$inicio, $fin]
                )
                ->with('docente')
                ->get()
                ->map(
                    function ($t) {

                        $estado =
                            is_null($t->asistencia)
                                ? 'Pendiente'
                                : (
                                    $t->asistencia == 1
                                        ? 'Asistió'
                                        : 'Faltó'
                                );

                        $clase =
                            is_null($t->asistencia)
                                ? 'warning'
                                : (
                                    $t->asistencia == 1
                                        ? 'success'
                                        : 'danger'
                                );

                        return [

                            'tipo' =>
                                'Individual',

                            'tema' =>
                                $t->motivo,

                            'fecha' =>
                                $t->fecha,

                            'tutor' =>
                                optional(
                                    $t->docente
                                )->nombre .
                                ' ' .
                                optional(
                                    $t->docente
                                )->paterno,

                            'asistencia' =>
                                $estado,

                            'observaciones' =>
                                $t->observaciones
                                    ?? 'N/A',

                            'clase_asistencia' =>
                                $clase
                        ];
                    }
                );

            // =================================================
            // GRUPALES
            // =================================================
            $grupales =
                collect();

            if ($idGrupo) {

                $grupales =
                    TutoriaGrupal::where(
                        'id_grupo',
                        $idGrupo
                    )
                    ->whereBetween(
                        'fecha',
                        [$inicio, $fin]
                    )
                    ->with([

                        'docente',

                        'detalles' =>
                            function ($q)
                            use ($studentId) {

                                $q->where(
                                    'id_estudiante',
                                    $studentId
                                );
                            }
                    ])
                    ->get()
                    ->map(
                        function ($tg) {

                            $detalle =
                                $tg->detalles->first();

                            $asistencia =
                                $detalle
                                    ? $detalle->asistencia
                                    : null;

                            $estado =
                                is_null($asistencia)
                                    ? 'Pendiente'
                                    : (
                                        $asistencia == 1
                                            ? 'Asistió'
                                            : 'Faltó'
                                    );

                            $clase =
                                is_null($asistencia)
                                    ? 'warning'
                                    : (
                                        $asistencia == 1
                                            ? 'success'
                                            : 'danger'
                                    );

                            return [

                                'tipo' =>
                                    'Grupal',

                                'tema' =>
                                    $tg->tema,

                                'fecha' =>
                                    $tg->fecha,

                                'tutor' =>
                                    optional(
                                        $tg->docente
                                    )->nombre .
                                    ' ' .
                                    optional(
                                        $tg->docente
                                    )->paterno,

                                'asistencia' =>
                                    $estado,

                                'observaciones' =>
                                    $detalle
                                        ? (
                                            $detalle->observaciones
                                                ?? 'N/A'
                                        )
                                        : 'N/A',

                                'clase_asistencia' =>
                                    $clase
                            ];
                        }
                    );
            }

            // =================================================
            // UNIR
            // =================================================
            $todas =
                $individuales
                    ->concat($grupales)
                    ->sortByDesc('fecha')
                    ->values();
        }

        return view(
            'alumno.tutorias',
            [
                'tutorias' =>
                    $todas,

                'periodoActual' =>
                    $periodoActual
            ]
        );
    }


    /**
     * =========================================================
     * EDITAR FOTO
     * =========================================================
     */
    public function editarFoto()
    {
        $studentId =
            Session::get('user_id');

        if (!$studentId) {
            return redirect()->route('login');
        }

        $estudiante =
            Estudiante::findOrFail(
                $studentId
            );

        // Mantener foto actualizada
        Session::put(
            'user_photo',
            $estudiante->foto ?? null
        );

        Session::put(
            'user_role',
            'Estudiante'
        );

        return view(
            'alumno.editar-foto',
            compact('estudiante')
        );
    }


    /**
     * =========================================================
     * ACTUALIZAR FOTO
     * =========================================================
     */
    public function actualizarFoto(
        Request $request
    ) {

        $studentId =
            Session::get('user_id');

        $estudiante =
            Estudiante::findOrFail(
                $studentId
            );

        // =====================================================
        // VALIDAR
        // =====================================================
        $request->validate(
            [
                'foto' =>
                    'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ],
            [

                'foto.required' =>
                    'Debes seleccionar una imagen.',

                'foto.image' =>
                    'El archivo debe ser una imagen.',

                'foto.mimes' =>
                    'La imagen debe ser de tipo: jpeg, png, jpg, gif o webp.',

                'foto.max' =>
                    'La imagen no debe pesar más de 2MB.',
            ]
        );

        // =====================================================
        // SI EXISTE ARCHIVO
        // =====================================================
        if ($request->hasFile('foto')) {

            // =================================================
            // ELIMINAR FOTO ANTERIOR
            // =================================================
            if ($estudiante->foto) {

                $rutaAnterior =
                    storage_path(
                        'app/public/fotos/estudiantes/' .
                        $estudiante->foto
                    );

                if (
                    file_exists(
                        $rutaAnterior
                    )
                ) {

                    unlink(
                        $rutaAnterior
                    );
                }
            }

            // =================================================
            // OBTENER EXTENSIÓN
            // =================================================
            $extension =
                strtolower(
                    $request
                        ->file('foto')
                        ->getClientOriginalExtension()
                );

            // =================================================
            // NOMBRE DEL ARCHIVO
            // =================================================
            $nombreArchivo =
                $estudiante->num_control .
                '.' .
                $extension;

            // =================================================
            // GUARDAR ARCHIVO
            // =================================================
            $request
                ->file('foto')
                ->storeAs(
                    'fotos/estudiantes',
                    $nombreArchivo,
                    'public'
                );

            // =================================================
            // GUARDAR EN BD
            // =================================================
            $estudiante->foto =
                $nombreArchivo;

            $estudiante->save();

            // =================================================
            // ACTUALIZAR SESIÓN
            // =================================================
            Session::put(
                'user_photo',
                $nombreArchivo
            );

            Session::put(
                'user_role',
                'Estudiante'
            );

            // =================================================
            // REDIRECCIÓN
            // =================================================
            return redirect()
                ->route('alumno.perfil')
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


    /**
     * =========================================================
     * ELIMINAR FOTO
     * =========================================================
     */
    public function eliminarFoto()
    {
        $studentId =
            Session::get('user_id');

        $estudiante =
            Estudiante::findOrFail(
                $studentId
            );

        // =====================================================
        // SI EXISTE FOTO
        // =====================================================
        if ($estudiante->foto) {

            // =================================================
            // RUTA FÍSICA
            // =================================================
            $rutaArchivo =
                storage_path(
                    'app/public/fotos/estudiantes/' .
                    $estudiante->foto
                );

            // =================================================
            // ELIMINAR ARCHIVO
            // =================================================
            if (
                file_exists(
                    $rutaArchivo
                )
            ) {

                unlink(
                    $rutaArchivo
                );
            }

            // =================================================
            // ELIMINAR DE BD
            // =================================================
            $estudiante->foto = null;

            $estudiante->save();

            // =================================================
            // ELIMINAR DE SESIÓN
            // =================================================
            Session::forget(
                'user_photo'
            );

            // Mantener rol
            Session::put(
                'user_role',
                'Estudiante'
            );

            return redirect()
                ->route('alumno.perfil')
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
}