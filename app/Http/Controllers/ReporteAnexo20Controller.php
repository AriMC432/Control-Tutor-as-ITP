<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Carrera;
use App\Models\Periodo;
use App\Models\Docente;
use App\Models\Grupo;
use App\Models\Estudiante;
use App\Models\TutoriaIndividual;
use App\Models\TutoriaGrupal;
use App\Models\Canalizacion;
use App\Models\DetalleTutoriaGrupal;
use App\Models\ReporteAnexo20;
use App\Models\EncabezadoReporte;

class ReporteAnexo20Controller extends Controller
{
    /**
     * generar reporte anexo 20 en formato pdf y guardar en base de datos
     */
    public function generate(Request $request)
    {
        // validar parametros
        $request->validate([
            'id_carrera' => 'required|exists:carreras,id_carrera',
            'id_periodo' => 'required|exists:periodo,id_periodo',
            'fecha_llenado' => 'required|date',
            'fecha_entrega' => 'required|date'
        ]);


        // obtener datos del coordinador logueado
        $idCoordinador = Session::get('user_id');
        $nombreCoordinador = Session::get('user_name');

        // obtener carrera y periodo
        $carrera = Carrera::findOrFail($request->id_carrera);
        $periodo = Periodo::findOrFail($request->id_periodo);

        // validar fechas
        $request->validate([
            'fecha_llenado' => 'required|date',
            'fecha_entrega' => 'required|date|after_or_equal:fecha_llenado'
        ], [
            'fecha_llenado.required' => 'La fecha de llenado es obligatoria',
            'fecha_entrega.required' => 'La fecha de entrega es obligatoria',
            'fecha_entrega.after_or_equal' => 'La fecha de entrega debe ser mayor o igual a la fecha de llenado'
        ]);

        $fechaLlenado = $request->fecha_llenado;
        $fechaEntrega = $request->fecha_entrega;
        
        // procesar firmas seleccionadas
        $firmaJefe = $request->get('firma_jefe', '');
        $firmaCoordinador = $request->get('firma_coordinador', '');
        
        $partesJefe = explode('|', $firmaJefe);
        $nombreJefe = $partesJefe[0] ?? '';
        $cargoJefe = $partesJefe[1] ?? '';
        
        $partesCoordinador = explode('|', $firmaCoordinador);
        $nombreCoordinadorFirma = $partesCoordinador[0] ?? '';
        $cargoCoordinadorFirma = $partesCoordinador[1] ?? '';

        // obtener docentes que tienen grupos en esta carrera
        $docentes = Docente::whereHas('gruposAsignados', function ($q) use ($carrera, $periodo) {
            $q->where('id_carrera', $carrera->id_carrera)
                ->where('id_periodo', $periodo->id_periodo);
        })->with(['gruposAsignados' => function ($q) use ($carrera, $periodo) {
            $q->where('id_carrera', $carrera->id_carrera)
                ->where('id_periodo', $periodo->id_periodo);
        }])->get();

        // procesar datos de cada docente
        $datosDocentes = [];
        $totalTutorias = 0;
        $totalCanalizaciones = 0;
        $totalEstudiantesAtendidos = 0;

        // contadores para indicadores por area
        $canalizacionesPsicologica = 0;
        $canalizacionesExtraescolares = 0;
        $canalizacionesBecas = 0;
        $canalizacionesAcademica = 0;

        foreach ($docentes as $docente) {
            // obtener grupos del docente
            $grupos = $docente->gruposAsignados;
            $nombreGrupos = $grupos->pluck('nombre')->implode(', ');
            $materias = $grupos->pluck('nombre')->implode(', ');

            // contar tutorias
            $tutoriasGrupales = TutoriaGrupal::where('id_docente', $docente->id_docente)
                ->whereBetween('fecha', [$periodo->fecha_inicio, $periodo->fecha_fin])
                ->count();

            $tutoriasIndividuales = TutoriaIndividual::where('id_docente', $docente->id_docente)
                ->whereBetween('fecha', [$periodo->fecha_inicio, $periodo->fecha_fin])
                ->count();

            $totalTutoriasDocente = $tutoriasGrupales + $tutoriasIndividuales;
            $totalTutorias += $totalTutoriasDocente;

            // contar estudiantes atendidos
            $estudiantesIndividuales = TutoriaIndividual::where('id_docente', $docente->id_docente)
                ->whereBetween('fecha', [$periodo->fecha_inicio, $periodo->fecha_fin])
                ->pluck('id_estudiante')
                ->unique()
                ->toArray();

            $estudiantesGrupales = DetalleTutoriaGrupal::whereHas('tutoriaGrupal', function ($q) use ($docente, $periodo) {
                $q->where('id_docente', $docente->id_docente)
                    ->whereBetween('fecha', [$periodo->fecha_inicio, $periodo->fecha_fin]);
            })->pluck('id_estudiante')
                ->unique()
                ->toArray();

            $todosEstudiantes = array_unique(array_merge($estudiantesIndividuales, $estudiantesGrupales));
            $estudiantesAtendidos = count($todosEstudiantes);
            $totalEstudiantesAtendidos += $estudiantesAtendidos;

            // contar canalizaciones
            $canalizaciones = Canalizacion::whereHas('tutoria', function ($q) use ($docente, $periodo) {
                $q->where('id_docente', $docente->id_docente)
                    ->whereBetween('fecha', [$periodo->fecha_inicio, $periodo->fecha_fin]);
            })->with('area')->get();

            $totalCanalizaciones += $canalizaciones->count();

            foreach ($canalizaciones as $canal) {
                $areaNombre = strtolower($canal->area->nombre ?? '');
                if (strpos($areaNombre, 'psicologia') !== false) {
                    $canalizacionesPsicologica++;
                } elseif (strpos($areaNombre, 'extraescolares') !== false) {
                    $canalizacionesExtraescolares++;
                } elseif (strpos($areaNombre, 'becas') !== false) {
                    $canalizacionesBecas++;
                } else {
                    $canalizacionesAcademica++;
                }
            }

            $datosDocentes[] = (object)[
                'nombre_completo' => $docente->nombre . ' ' . $docente->paterno . ' ' . ($docente->materno ?? ''),
                'materias' => $materias ?: 'N/A',
                'grupo' => $nombreGrupos ?: 'N/A',
                'tutorias_grupales' => $tutoriasGrupales,
                'tutorias_individuales' => $tutoriasIndividuales,
                'total_tutorias' => $totalTutoriasDocente,
                'canalizaciones' => $canalizaciones->count()
            ];
        }

        // obtener reporte guardado previamente
        $reporteGuardado = ReporteAnexo20::where('id_coordinador', $idCoordinador)
            ->where('id_carrera', $carrera->id_carrera)
            ->where('id_periodo', $periodo->id_periodo)
            ->first();

        $observaciones = $reporteGuardado ? ($reporteGuardado->observaciones ?? '') : '';

        // obtener el encabezado activo
        $encabezadoActivo = EncabezadoReporte::where('id_periodo', $periodo->id_periodo)
            ->where('tipo_reporte', 'anexo20')
            ->where('activo', true)
            ->first();
        
        $encabezadoRuta = $encabezadoActivo ? $encabezadoActivo->ruta_imagen : null;

        // datos para el encabezado del pdf
        $coordinador = [
            'nombre' => $nombreCoordinador,
            'fecha_llenado' => \Carbon\Carbon::parse($fechaLlenado)->locale('es')->isoFormat('D \d\e MMMM \d\e YYYY'),
            'fecha_entrega' => \Carbon\Carbon::parse($fechaEntrega)->locale('es')->isoFormat('D \d\e MMMM \d\e YYYY'),
            'hora_actual' => now()->format('g:i A'),
            'periodo' => $periodo->nombre,
            'programa' => $carrera->nombre
        ];

        // calcular estadisticas
        $totalDocentes = count($docentes);
        $totalEstudiantesSistema = Estudiante::count();
        
        $porcentajePsicologica = $totalEstudiantesSistema > 0 ? round(($canalizacionesPsicologica / $totalEstudiantesSistema) * 100, 1) : 0;
        $porcentajeExtraescolares = $totalEstudiantesSistema > 0 ? round(($canalizacionesExtraescolares / $totalEstudiantesSistema) * 100, 1) : 0;
        $porcentajeBecas = $totalEstudiantesSistema > 0 ? round(($canalizacionesBecas / $totalEstudiantesSistema) * 100, 1) : 0;
        $porcentajeAcademica = $totalEstudiantesSistema > 0 ? round(($canalizacionesAcademica / $totalEstudiantesSistema) * 100, 1) : 0;

        // guardar en base de datos ---- IMPORTANTISIMOOOOO para q no lo olvide
        ReporteAnexo20::updateOrCreate(
            [
                'id_coordinador' => $idCoordinador,
                'id_carrera' => $carrera->id_carrera,
                'id_periodo' => $periodo->id_periodo
            ],
            [
                'datos_docentes' => json_encode($datosDocentes),
                'observaciones' => $observaciones,
                'fecha_llenado' => $fechaLlenado,
                'fecha_entrega' => $fechaEntrega,
                'firma_jefe_nombre' => $nombreJefe,
                'firma_jefe_cargo' => $cargoJefe,
                'firma_coordinador_nombre' => $nombreCoordinadorFirma,
                'firma_coordinador_cargo' => $cargoCoordinadorFirma,
                'encabezado_ruta' => $encabezadoRuta,
                'pdf_generado' => true,
                'editado' => true,
                'ultima_edicion' => now()
            ]
        );

        // generar el pdf
        $pdf = Pdf::loadView('reportes.anexo20', compact(
            'datosDocentes',
            'coordinador',
            'observaciones',
            'totalDocentes',
            'totalTutorias',
            'totalCanalizaciones',
            'totalEstudiantesAtendidos',
            'canalizacionesPsicologica',
            'canalizacionesExtraescolares',
            'canalizacionesBecas',
            'canalizacionesAcademica',
            'porcentajePsicologica',
            'porcentajeExtraescolares',
            'porcentajeBecas',
            'porcentajeAcademica',
            'nombreJefe',
            'cargoJefe',
            'nombreCoordinadorFirma',
            'cargoCoordinadorFirma'
        ));

        $pdf->setPaper('carta', 'portrait');
        return $pdf->download('anexo20_' . $carrera->nombre . '_' . $periodo->nombre . '.pdf');
    }

    /**
     * guardar observaciones del reporte
     */
    public function guardarConfiguracion(Request $request)
    {
        $idCoordinador = Session::get('user_id');

        $request->validate([
            'id_carrera' => 'required|exists:carreras,id_carrera',
            'id_periodo' => 'required|exists:periodo,id_periodo',
            'observaciones' => 'nullable|string'
        ]);

        $reporte = ReporteAnexo20::updateOrCreate(
            [
                'id_coordinador' => $idCoordinador,
                'id_carrera' => $request->id_carrera,
                'id_periodo' => $request->id_periodo
            ],
            [
                'observaciones' => $request->observaciones ?? '',
                'editado' => true,
                'ultima_edicion' => now()
            ]
        );

        return response()->json(['success' => true, 'message' => 'Configuracion guardada correctamente']);
    }
}