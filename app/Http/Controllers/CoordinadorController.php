<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Estudiante;
use App\Models\TutoriaIndividual;
use App\Models\TutoriaGrupal;
use App\Models\DetalleTutoriaGrupal;
use App\Models\Canalizacion;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\Grupo;

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
    // INFORMES DE TUTORES
    // =========================================================

    public function informes()
    {
        // Obtener el periodo escolar activo
        $periodoActivo = DB::table('periodo')
            ->where('activo', 1)
            ->first();

        // Obtener los docentes
        $tutores = DB::table('docente as d')
    ->join('grupo as g', 'd.id_docente', '=', 'g.id_docente')
    ->where('d.id_rol', 2)
    ->select('d.id_docente', 'd.nombre', 'd.paterno')
    ->distinct()
    ->orderBy('d.nombre')
    ->get();

        // Obtener los informes registrados
        $informes = DB::table('informes_tutores as i')
            ->join('docente as d', 'i.id_docente', '=', 'd.id_docente')
            ->select(
                'i.*',
                'd.nombre',
                'd.paterno'
            )
            ->orderByDesc('i.created_at')
            ->get();

        // Enviar toda la información a la vista
        return view('coordinador.informes', compact(
            'periodoActivo',
            'tutores',
            'informes'
        ));
    }


    // =========================================================
    // SUBIR INFORME DE TUTOR
    // =========================================================

    public function subirInforme(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'id_docente' => 'required|exists:docente,id_docente',
            'periodo' => 'required|date_format:Y-m',
            'informe' => 'required|file|mimes:pdf,xlsx,xls|max:10240',
        ]);

        // Obtener el archivo seleccionado
        $archivo = $request->file('informe');

        // Guardar el archivo en storage/app/public/informes_tutores
        $ruta = $archivo->store('informes_tutores', 'public');

        try {

            // Registrar el informe en MySQL
            DB::table('informes_tutores')->insert([
                'id_docente' => $request->id_docente,
                'periodo' => $request->periodo,
                'archivo' => $ruta,
                'nombre_original' => $archivo->getClientOriginalName(),
                'estatus' => 'En revisión',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()
                ->route('coord.informes')
                ->with('success', 'El informe se subió correctamente.');

        } catch (\Throwable $e) {

            // Eliminar el archivo si no pudo registrarse en la base de datos
            Storage::disk('public')->delete($ruta);

            return back()->with(
                'error',
                'No fue posible registrar el informe. Inténtalo nuevamente.'
            );
        }
    }


// =========================================================
// GENERAR CONSOLIDADO DE INFORMES EN PDF
// =========================================================

public function generarConsolidado()
{
    // Obtener el periodo activo
    $periodoActivo = DB::table('periodo')
        ->where('activo', 1)
        ->first();

    if (!$periodoActivo) {
        return redirect()
            ->route('coord.informes')
            ->with('error', 'No hay un periodo escolar activo.');
    }

    // Obtener los meses de inicio y fin del periodo
    $fechaInicio = \Carbon\Carbon::parse($periodoActivo->fecha_inicio)
        ->format('Y-m');

    $fechaFin = \Carbon\Carbon::parse($periodoActivo->fecha_fin)
        ->format('Y-m');

    // Obtener los informes correspondientes al periodo activo
    $informes = DB::table('informes_tutores as i')
        ->join('docente as d', 'i.id_docente', '=', 'd.id_docente')
        ->select(
            'i.id_informe',
            'i.periodo',
            'i.nombre_original',
            'i.estatus',
            'i.created_at',
            'd.nombre',
            'd.paterno'
        )
        ->whereBetween('i.periodo', [$fechaInicio, $fechaFin])
        ->orderBy('d.nombre')
        ->orderBy('i.periodo')
        ->get();

    // Generar el PDF
    $pdf = Pdf::loadView('coordinador.consolidado_pdf', [
        'periodoActivo' => $periodoActivo,
        'informes' => $informes
    ]);

    $pdf->setPaper('a4', 'landscape');

    // Descargar el archivo
    return $pdf->download(
        'Consolidado_' . str_replace(' ', '_', $periodoActivo->nombre) . '.pdf'
    );
}
 
// =========================================================
// ACEPTAR O RECHAZAR INFORMES DE TUTORES
// =========================================================

public function actualizarEstatusInforme(Request $request, $id)
{
    $request->validate([
        'estatus' => 'required|in:Aceptado,Rechazado',
    ]);

    $informe = DB::table('informes_tutores')
        ->where('id_informe', $id)
        ->first();

    if (!$informe) {
        return redirect()
            ->route('coord.informes')
            ->with('error', 'El informe no existe.');
    }

    DB::table('informes_tutores')
        ->where('id_informe', $id)
        ->update([
            'estatus' => $request->estatus,
            'updated_at' => now(),
        ]);

    return redirect()
        ->route('coord.informes')
        ->with('success', 'El informe se marcó como ' . $request->estatus . ' correctamente.');
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

  
    // =========================================================
   
public function seguimiento(Request $request)
{
    // Obtener el periodo escolar activo
    $periodoActual = Periodo::where('activo', 1)->first();

    // Obtener las carreras
    $carreras = DB::table('carreras')
        ->orderBy('nombre')
        ->get();

    // Si no hay periodo activo, mostrar la vista vacía
    if (!$periodoActual) {
        return view('coordinador.seguimiento', [
            'seguimiento' => collect(),
            'periodoActual' => null,
            'carreras' => $carreras,
            'meses' => [],
        ]);
    }

    // Fechas del periodo escolar
    $fechaInicio = \Carbon\Carbon::parse($periodoActual->fecha_inicio)->startOfDay();
    $fechaFin = \Carbon\Carbon::parse($periodoActual->fecha_fin)->endOfDay();

    // Generar meses automáticamente según el periodo activo
    $meses = [];
    $cursor = $fechaInicio->copy()->startOfMonth();

    while ($cursor <= $fechaFin) {
        $mesNumero = $cursor->format('m');

        // Evitar repetir el mismo mes en el selector
        if (!collect($meses)->contains('valor', $mesNumero)) {
            $meses[] = [
                'valor' => $mesNumero,
                'nombre' => ucfirst($cursor->locale('es')->translatedFormat('F')),
            ];
        }

        $cursor->addMonth();
    }

    // Obtener filtros seleccionados
    $mesSeleccionado = $request->input('mes', '');
    $carreraSeleccionada = $request->input('carrera', '');

    // Validar el mes seleccionado
    if (
        $mesSeleccionado !== '' &&
        !collect($meses)->contains('valor', $mesSeleccionado)
    ) {
        $mesSeleccionado = '';
    }

    // Obtener los grupos del periodo activo
    $grupos = Grupo::where('id_periodo', $periodoActual->id_periodo)
        ->when($carreraSeleccionada, function ($query) use ($carreraSeleccionada) {
            $query->where('id_carrera', $carreraSeleccionada);
        })
        ->with(['docente', 'carrera'])
        ->get();

    // Construir seguimiento por grupo
    $seguimiento = $grupos->map(function ($grupo) use (
        $fechaInicio,
        $fechaFin,
        $mesSeleccionado
    ) {

        // Consulta de tutorías grupales
        $grupalesQuery = TutoriaGrupal::where('id_grupo', $grupo->id_grupo)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin]);

        // Consulta de tutorías individuales
        $individualesQuery = TutoriaIndividual::where(
            'id_docente',
            $grupo->id_docente
        )->whereBetween('fecha', [$fechaInicio, $fechaFin]);

        // Aplicar filtro de mes
        if ($mesSeleccionado !== '') {
            $grupalesQuery->whereMonth('fecha', (int) $mesSeleccionado);
            $individualesQuery->whereMonth('fecha', (int) $mesSeleccionado);
        }

        // Contar tutorías
        $grupales = $grupalesQuery->count();
        $individuales = $individualesQuery->count();

        // Obtener última sesión dentro del periodo
        $ultimaGQuery = TutoriaGrupal::where(
            'id_grupo',
            $grupo->id_grupo
        )->whereBetween('fecha', [$fechaInicio, $fechaFin]);

        $ultimaIQuery = TutoriaIndividual::where(
            'id_docente',
            $grupo->id_docente
        )->whereBetween('fecha', [$fechaInicio, $fechaFin]);

        if ($mesSeleccionado !== '') {
            $ultimaGQuery->whereMonth('fecha', (int) $mesSeleccionado);
            $ultimaIQuery->whereMonth('fecha', (int) $mesSeleccionado);
        }

        $ultimaG = $ultimaGQuery->max('fecha');
        $ultimaI = $ultimaIQuery->max('fecha');

        $ultimaSesion = max($ultimaG, $ultimaI);

        // Calcular asistencia promedio
        $asistenciaQuery = TutoriaIndividual::where(
            'id_docente',
            $grupo->id_docente
        )
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->whereNotNull('asistencia');

        if ($mesSeleccionado !== '') {
            $asistenciaQuery->whereMonth('fecha', (int) $mesSeleccionado);
        }

        $asistenciaProm = $asistenciaQuery->avg('asistencia') ?? 0;

        return (object) [
            'tutor' => ($grupo->docente?->nombre ?? 'Sin')
                . ' '
                . ($grupo->docente?->paterno ?? 'Asignar'),

            'grupo' => $grupo->nombre,

            'carrera' => $grupo->carrera->nombre ?? 'N/A',

            'tutorias_mes' => $grupales + $individuales,

            'asistencia_prom' => round($asistenciaProm * 100, 0),

            'ultima_sesion' => $ultimaSesion
                ? \Carbon\Carbon::parse($ultimaSesion)->format('d/m/Y')
                : 'Sin sesiones',

            'estado' => ($grupales + $individuales > 0)
                ? 'Activo'
                : 'Pendiente',
        ];
    });

    return view('coordinador.seguimiento', compact(
        'seguimiento',
        'periodoActual',
        'carreras',
        'meses'
    ));
}
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