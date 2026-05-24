<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Grupo;
use App\Models\Periodo;
use App\Models\Estudiante;
use App\Models\TutoriaIndividual;
use App\Models\TutoriaGrupal;
use App\Models\Canalizacion;
use App\Models\DetalleTutoriaGrupal;
use App\Models\ProblemaPeriodo;
use App\Models\DesercionEstudiante;

class ReporteAnexo19Controller extends Controller
{
    /**
     * generar reporte anexo 19 en formato pdf
     */
    public function generate(Request $request, $id_grupo, $id_periodo)
    {

        // obtener datos del docente logueado
        $idDocente = Session::get('user_id');
        $nombreDocente = Session::get('user_name');

        // obtener informacion del grupo y periodo
        $grupo = Grupo::with('carrera')->findOrFail($id_grupo);
        $periodo = Periodo::findOrFail($id_periodo);

        // validar fechas 
        $request->validate([
            'fecha_llenado' => 'required|date',
            'fecha_entrega' => 'required|date|after_or_equal:fecha_llenado'
        ], [
            'fecha_llenado.required' => 'La fecha de llenado es obligatoria',
            'fecha_entrega.required' => 'La fecha de entrega es obligatoria',
            'fecha_entrega.after_or_equal' => 'La fecha de entrega debe ser mayor o igual a la fecha de llenado'
        ]);

        // obtener fecha de llenado desde el request 
        $fechaLlenado = $request->fecha_llenado;
        $fechaEntrega = $request->fecha_entrega;

        // procesar firmas seleccionadas
        $firmaCoordinador = $request->get('firma_coordinador', '');
        $firmaJefe = $request->get('firma_jefe', '');

        // separar nombre y cargo de las firmas
        $partesCoordinador = explode('|', $firmaCoordinador);
        $nombreCoordinador = $partesCoordinador[0] ?? '';
        $cargoCoordinador = $partesCoordinador[1] ?? '';
        
        $partesJefe = explode('|', $firmaJefe);
        $nombreJefe = $partesJefe[0] ?? '';
        $cargoJefe = $partesJefe[1] ?? '';

        // obtener lista de estudiantes del grupo
        $estudiantes = Estudiante::where('id_grupo', $id_grupo)->get();

        // procesar datos de cada estudiante
        $datosEstudiantes = [];
        $totalCanalizaciones = 0;
        $canalizacionesPorArea = [
            'psicologica' => 0,
            'extraescolares' => 0,
            'becas' => 0,
            'academica' => 0
        ];

        foreach ($estudiantes as $estudiante) {
            // contar tutorias grupales del estudiante en el periodo
            $tutoriasGrupales = DetalleTutoriaGrupal::where('id_estudiante', $estudiante->id_estudiante)
                ->whereHas('tutoriaGrupal', function ($q) use ($periodo) {
                    $q->whereBetween('fecha', [$periodo->fecha_inicio, $periodo->fecha_fin]);
                })
                ->count();

            // contar tutorias individuales del estudiante en el periodo
            $tutoriasIndividuales = TutoriaIndividual::where('id_estudiante', $estudiante->id_estudiante)
                ->whereBetween('fecha', [$periodo->fecha_inicio, $periodo->fecha_fin])
                ->count();

            // obtener canalizaciones del estudiante
            $canalizaciones = Canalizacion::whereHas('tutoria', function ($q) use ($estudiante, $periodo) {
                $q->where('id_estudiante', $estudiante->id_estudiante)
                    ->whereBetween('fecha', [$periodo->fecha_inicio, $periodo->fecha_fin]);
            })->with('area')->get();

            $canalizado = $canalizaciones->count() > 0 ? 'si' : 'no';
            $areaCanalizacion = $canalizaciones->first() ? $canalizaciones->first()->area->nombre : '';

            // contar canalizaciones por area
            foreach ($canalizaciones as $canal) {
                $totalCanalizaciones++;
                $areaNombre = strtolower($canal->area->nombre);
                if (strpos($areaNombre, 'psicologia') !== false) {
                    $canalizacionesPorArea['psicologica']++;
                } elseif (strpos($areaNombre, 'extraescolares') !== false) {
                    $canalizacionesPorArea['extraescolares']++;
                } elseif (strpos($areaNombre, 'becas') !== false) {
                    $canalizacionesPorArea['becas']++;
                } else {
                    $canalizacionesPorArea['academica']++;
                }
            }

            // verificar desercion del estudiante
            $desercion = DesercionEstudiante::where('id_estudiante', $estudiante->id_estudiante)
                ->where('id_periodo', $id_periodo)
                ->first();

            $tipoDesercion = 'no';
            if ($desercion && $desercion->tipo_desercion != 'activo') {
                $tipoDesercion = $desercion->tipo_desercion == 'baja_definitiva' ? 'baja definitiva' : 'baja temporal';
            }

            $datosEstudiantes[] = (object)[
                'nombre_completo' => $estudiante->nombre . ' ' . $estudiante->paterno . ' ' . ($estudiante->materno ?? ''),
                'tutorias_grupales' => $tutoriasGrupales,
                'tutorias_individuales' => $tutoriasIndividuales,
                'canalizado' => $canalizado,
                'area_canalizacion' => $areaCanalizacion,
                'desercion' => $tipoDesercion
            ];
        }

        // obtener problemas detectados por el docente en este periodo
        $problemas = ProblemaPeriodo::where('id_docente', $idDocente)
            ->where('id_periodo', $id_periodo)
            ->where('id_grupo', $id_grupo)
            ->orderBy('orden', 'asc')
            ->get();


        // obtener el encabezado activo para guardarlo
        $encabezadoActivo = \App\Models\EncabezadoReporte::where('id_periodo', $id_periodo)
            ->where('tipo_reporte', 'anexo19')
            ->where('activo', true)
            ->first();
        
        $encabezadoRuta = $encabezadoActivo ? $encabezadoActivo->ruta_imagen : null;
        $idEncabezado = $encabezadoActivo ? $encabezadoActivo->id_encabezado : null;

        // datos del tutor para el encabezado
        $tutor = [
            'nombre' => $nombreDocente,
            'fecha_llenado' => \Carbon\Carbon::parse($fechaLlenado)->locale('es')->isoFormat('D \d\e MMMM \d\e YYYY'),
            'fecha_entrega' => \Carbon\Carbon::parse($fechaEntrega)->locale('es')->isoFormat('D \d\e MMMM \d\e YYYY'),
            'periodo' => $periodo->nombre,
            'programa' => $grupo->carrera->nombre,
            'grupo' => $grupo->nombre,
            'semestre' => $grupo->semestre,
            'medio_comunicacion' => $grupo->medio_comunicacion ?? 'personal, whatsapp y sesiones virtuales'
        ];

        // calcular porcentajes basicos
        $totalEstudiantes = count($estudiantes);
        $porcentajeCanalizacionAcademica = $totalEstudiantes > 0 ? round(($canalizacionesPorArea['academica'] / $totalEstudiantes) * 100) : 0;

        // calcular cantidad de estudiantes con desercion
        $desercionCount = 0;
        foreach ($datosEstudiantes as $est) {
            if ($est->desercion != 'no') {
                $desercionCount++;
            }
        }
        $porcentajeDesercion = $totalEstudiantes > 0 ? round(($desercionCount / $totalEstudiantes) * 100) : 0;
        $observaciones = ''; // o puedes obtenerlas de alguna tabla si existen

        // GUARDAR EN BASE DE DATOS ---- IMPORTANTISIMOOOOO para q no lo olvide
        $reporte = \App\Models\ReporteAnexo19::updateOrCreate(
            [
                'id_docente' => $idDocente,
                'id_grupo' => $id_grupo,
                'id_periodo' => $id_periodo
            ],
            [
                'datos_estudiantes' => json_encode($datosEstudiantes),
                'problemas' => json_encode($problemas),
                'indicadores' => json_encode($canalizacionesPorArea),
                'medio_comunicacion' => $grupo->medio_comunicacion,
                'fecha_llenado' => $fechaLlenado,
                'fecha_entrega' => $fechaEntrega,
                'firma_coordinador_nombre' => $nombreCoordinador,
                'firma_coordinador_cargo' => $cargoCoordinador,
                'firma_jefe_nombre' => $nombreJefe,
                'firma_jefe_cargo' => $cargoJefe,
                'id_encabezado_usado' => $idEncabezado,
                'encabezado_ruta' => $encabezadoRuta,
                'pdf_generado' => true,
                'editado' => true,
                'ultima_edicion' => now()
            ]
        );

        // generar el pdf con la vista
        $pdf = Pdf::loadView('reportes.anexo19', compact(
            'datosEstudiantes',
            'tutor',
            'problemas',
            'canalizacionesPorArea',
            'porcentajeCanalizacionAcademica',
            'totalCanalizaciones',
            'totalEstudiantes',
            'desercionCount',
            'porcentajeDesercion',
            'observaciones',
            'nombreCoordinador',
            'cargoCoordinador',
            'nombreJefe',
            'cargoJefe'
        ));

        // configurar tamaño de pagina y orientacion
        $pdf->setPaper('carta', 'portrait');

        // descargar el archivo pdf
        return $pdf->download('anexo19_' . $grupo->nombre . '_' . $periodo->nombre . '.pdf');
    }

    /**
     * mostrar formulario para configurar el reporte anexo 19
     */
    public function configurar($id_grupo, $id_periodo)
    {
        $idDocente = Session::get('user_id');

        $grupo = Grupo::findOrFail($id_grupo);
        $periodo = Periodo::findOrFail($id_periodo);

        // obtener problemas ya registrados
        $problemas = ProblemaPeriodo::where('id_docente', $idDocente)
            ->where('id_periodo', $id_periodo)
            ->where('id_grupo', $id_grupo)
            ->orderBy('orden', 'asc')
            ->get();

        return view('docente.configurar_reporte', compact('grupo', 'periodo', 'problemas'));
    }

    /**
     * guardar medio de comunicacion del grupo
     */
    public function guardarMedioComunicacion(Request $request, $id_grupo)
    {
        $grupo = Grupo::findOrFail($id_grupo);

        $request->validate([
            'medio_comunicacion' => 'nullable|string|max:255'
        ]);

        $grupo->medio_comunicacion = $request->medio_comunicacion;
        $grupo->save();

        return back()->with('success', 'medio de comunicacion guardado');
    }

    /**
     * agregar un nuevo problema
     */
    public function agregarProblema(Request $request)
    {
        $idDocente = Session::get('user_id');

        $request->validate([
            'id_grupo' => 'required|exists:grupo,id_grupo',
            'id_periodo' => 'required|exists:periodo,id_periodo',
            'descripcion_problema' => 'required|string',
            'solucion_recomendada' => 'required|string',
            'numero_estudiantes' => 'required|integer|min:0'
        ]);

        // obtener el ultimo orden
        $ultimoOrden = ProblemaPeriodo::where('id_grupo', $request->id_grupo)
            ->where('id_periodo', $request->id_periodo)
            ->max('orden');

        ProblemaPeriodo::create([
            'id_docente' => $idDocente,
            'id_periodo' => $request->id_periodo,
            'id_grupo' => $request->id_grupo,
            'descripcion_problema' => $request->descripcion_problema,
            'solucion_recomendada' => $request->solucion_recomendada,
            'numero_estudiantes' => $request->numero_estudiantes,
            'orden' => ($ultimoOrden ?? 0) + 1
        ]);

        return back()->with('success', 'problema agregado correctamente');
    }

    /**
     * editar un problema
     */
    public function editarProblema(Request $request)
    {
        $idDocente = Session::get('user_id');

        $request->validate([
            'id_problema' => 'required|exists:problemas_periodo,id_problema',
            'descripcion_problema' => 'required|string',
            'solucion_recomendada' => 'required|string',
            'numero_estudiantes' => 'required|integer|min:0'
        ]);

        $problema = ProblemaPeriodo::findOrFail($request->id_problema);

        // verificar que el problema pertenece al docente logueado
        if ($problema->id_docente != $idDocente) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $problema->update([
            'descripcion_problema' => $request->descripcion_problema,
            'solucion_recomendada' => $request->solucion_recomendada,
            'numero_estudiantes' => $request->numero_estudiantes
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * eliminar un problema
     */
    public function eliminarProblema($id_problema)
    {
        $problema = ProblemaPeriodo::findOrFail($id_problema);
        $problema->delete();

        return back()->with('success', 'problema eliminado');
    }
}
