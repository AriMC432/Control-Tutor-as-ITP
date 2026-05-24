<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Anexo 19 - Reporte semestral del tutor(a)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 20px;
        }

        .encabezado {
            text-align: center;
            margin-bottom: 20px;
        }

        .encabezado img {
            max-width: 100%;
            height: auto;
        }

        .info-tutor {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-tutor td,
        .info-tutor th {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .info-tutor th {
            background-color: #FFF1CC;
            text-align: left;
            width: 25%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #FFF1CC;
            text-align: center;
            font-weight: bold;
        }

        .info-tutor tr:last-child th {
            border-bottom: none;
        }


        .text-center {
            text-align: center;
        }

        .pie {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
        }

        .pie img {
            max-width: 100%;
            height: auto;
        }

        .firmas {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .firma {
            text-align: center;
            width: 30%;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    {{-- encabezado con imagen desde base de datos --}}
    @php
        $idPeriodo = \App\Models\Periodo::where('nombre', $tutor['periodo'])->first()->id_periodo ?? null;

        // buscar encabezado SOLO para anexo 19
        $encabezado = null;
        if ($idPeriodo) {
            $encabezado = \App\Models\EncabezadoReporte::where('id_periodo', $idPeriodo)
                ->where('tipo_reporte', 'anexo19')
                ->where('activo', true)
                ->first();
        }

        // si no hay encabezado para anexo 19 en este periodo, buscar uno global (sin periodo)
        if (!$encabezado) {
            $encabezado = \App\Models\EncabezadoReporte::whereNull('id_periodo')
                ->where('tipo_reporte', 'anexo19')
                ->where('activo', true)
                ->first();
        }

        $rutaImagen = $encabezado 
            ? public_path('storage/' . $encabezado->ruta_imagen) 
            : null;
    @endphp

    @if($rutaImagen && file_exists($rutaImagen))
        <div class="encabezado">
            <img src="{{ $rutaImagen }}" alt="Encabezado institucional" style="max-width: 100%;">
        </div>
    @else
        <div class="encabezado">
            <h3>Instituto Tecnologico de Pachuca</h3>
            <h4>Reporte de Accion Tutorial</h4>
            <h4>Anexo 19</h4>
        </div>
    @endif


    {{-- informacion de universidad, tutor y grupo --}}
    <table class="info-tutor" style="margin-bottom: 0; border-bottom: none;">
        <tr>
            <th colspan="7" class="text-center">Instituto Tecnológico de Pachuca</th>
        </tr>
        <tr>
            <th colspan="1"><strong>Nombre del Tutor: </strong>{{ $tutor['nombre'] }}</th>
            <th colspan="3"><strong>Fecha de llenado: </strong>{{ $tutor['fecha_llenado'] }}</th>
            <th colspan="3"><strong>Periodo de entrega: </strong>{{ $tutor['periodo'] }}</th>
        </tr>
        <tr>
            <th colspan="1"><strong>Programa educativo: </strong>{{ $tutor['programa'] }}</th>
            <th colspan="2"><strong>Grupo: </strong>{{ $tutor['grupo'] }}</th>
            <th colspan="1"><strong>Semestre: </strong>{{ $tutor['semestre'] }}</th>
            <th colspan="3"><strong>Medio o Canal de comunicación utilizado para la atención de estudiantes en el semestre: </strong>{{ $tutor['medio_comunicacion'] }}</th>

        </tr>
    </table>
    {{-- tabla de estudiantes --}}
    <table class="tabla-estudiantes" style="width: 100%; border-collapse: collapse; margin-top: 0; border-top: none;">
        <thead>
            <tr>
                <th rowspan="2">Nombre del estudiante</th>
                <th colspan="2">Estudiantes atendidos en el semestre</th>
                <th rowspan="2">Estudiantes canalizados en el semestre</th>
                <th rowspan="2">Área canalizada</th>
                <th rowspan="2">Deserción (Si/No)</th>
                <th rowspan="2">Motivo de deserción</th>
            </tr>
            <tr>
                <th class="text-center">Tutoria grupal</th>
                <th class="text-center">Tutoria individual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datosEstudiantes as $index => $est)
            <tr>
                <td><strong>{{ $index + 1 . ' ' }}</strong>{{ $est->nombre_completo }}</td>
                <td class="text-center">{{ $est->tutorias_grupales }}</td>
                <td class="text-center">{{ $est->tutorias_individuales }}</td>
                <td class="text-center">{{ $est->canalizado }}</td>
                <td>{{ $est->area_canalizacion }}</td>
                <td class="text-center">{{ $est->desercion }}</td>
                <td class="text-center"></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- problemas detectados --}}
    <table>
        <thead>
            <tr>
                <th colspan="4">Enumere los principales problemas de rendimiento detectados con sus estudiantes durante el semestre
                    Causas posibles: Reprobación por asignatura, inasistencia, problemas económicos, falta de apoyo familiar, indisciplina, accidente, enfermedad, etc.
                </th>
            </tr>
            <tr>
                <th>Descripcion del problema</th>
                <th>Soluciones recomendadas o accione tomadas</th>
                <th class="text-center">Número de estudiantes</th>
                <th class="text-center">%</th>
            </tr>
        </thead>
        <tbody>
            @forelse($problemas as $problema)
            <tr>
                <td>{{ $problema->descripcion_problema }}</td>
                <td>{{ $problema->solucion_recomendada }}</td>
                <td class="text-center">{{ $problema->numero_estudiantes }}</td>
                <td class="text-center">{{ $totalEstudiantes > 0 ? round(($problema->numero_estudiantes / $totalEstudiantes) * 100) : 0 }}%</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No se registraron problemas en este periodo</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{-- indicadores --}}
    <table>
        <thead>
            <tr>
                <th colspan="3">Anotar los siguientes indicadores, considerando el semestre de atención que está concluyendo</th>
            </tr>
            <tr>
                <th>Indicador</th>
                <th class="text-center">Cantidad de estudiantes</th>
                <th class="text-center">% de estudiantes sobre el total de tutorados</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Índice de canalizacion psicologica</td>
                <td class="text-center">{{ $canalizacionesPorArea['psicologica'] }}</td>
                <td class="text-center">{{ $totalEstudiantes > 0 ? round(($canalizacionesPorArea['psicologica'] / $totalEstudiantes) * 100) : 0 }}%</td>
            </tr>
            <tr>
                <td>Índice de apoyo a canalizacion al area de extraescolares</td>
                <td class="text-center">{{ $canalizacionesPorArea['extraescolares'] }}</td>
                <td class="text-center">{{ $totalEstudiantes > 0 ? round(($canalizacionesPorArea['extraescolares'] / $totalEstudiantes) * 100) : 0 }}%</td>
            </tr>
            <tr>
                <td>Índice de apoyo en gestion de becas</td>
                <td class="text-center">{{ $canalizacionesPorArea['becas'] }}</td>
                <td class="text-center">{{ $totalEstudiantes > 0 ? round(($canalizacionesPorArea['becas'] / $totalEstudiantes) * 100) : 0 }}%</td>
            </tr>
            <tr>
                <td>Índice de apoyo en areas academicas</td>
                <td class="text-center">{{ $canalizacionesPorArea['academica'] }}</td>
                <td class="text-center">{{ $porcentajeCanalizacionAcademica }}%</td>
            </tr>
            <tr>
                <td>Índice de deserción</td>
                <td class="text-center">{{ $desercionCount }}</td>
                <td class="text-center">{{ $porcentajeDesercion }}%</td>
            </tr>
        </tbody>
    </table>

    {{-- instructivo y observaciones unificados --}}
    <div style="border: 1.5px solid #000; padding: 10px; margin-top: 15px;">
        <strong>Instructivo de llenado:</strong>
        <ul style="margin-top: 10px; margin-bottom: 15px; padding-left: 20px;">
            <li>Anote los datos correspondientes en los apartados del encabezado</li>
            <li>En el apartado de observaciones anotar las actividades adicionales más importantes realizadas en el semestre.</li>
            <li>Este reporte deberá ser llenado por el tutor</li>
            <li>Este reporte deberá ser entregado al coordinador de tutoría del Departamento Académico con copia para el tutor, siendo evidencia como parte de sus actividades tutorales para recibir su constancia de participación.</li>
        </ul>

        <strong>Observaciones:</strong>
        <div style="border: 1px solid #ccc; height: 120px; margin-top: 10px; padding: 5px;">
            @if(is_array($observaciones))
            {{ implode(' ', $observaciones) }}
            @else
            {{ $observaciones ?? '' }}
            @endif
        </div>
    </div>

    {{-- firmas --}}

    <div style="margin-top:35px; font-size:13px; font-family:Arial;">
        Fecha de entrega de este reporte:
        <span style="border-bottom:1px solid #000; display:inline-block; width:180px; text-align:center;">
            {{ $tutor['fecha_entrega'] }}
        </span>
    </div>

    <!-- FIRMAS -->
    <div style="width:100%; margin-top:90px; font-family:Arial; font-size:13px;">
        <table style="width:100%; text-align:center; border:none;">
            <tr style="border:none;">
                <!-- IZQUIERDA: Coordinador de Tutoría -->
                <td style="width:50%; padding-right:40px; border:none;">
                    <div style="border-top:1px solid #000000; width:85%; margin:0 auto 5px auto;"></div>
                    <div style="font-weight:bold;">{{ $nombreCoordinador }}</div>
                    <div style="font-size:12px;">{{ $cargoCoordinador }}</div>
                </td>

                <!-- DERECHA: Jefe de Departamento -->
                <td style="width:50%; padding-left:40px; border:none;">
                    <div style="border-top:1px solid #000000; width:85%; margin:0 auto 5px auto;"></div>
                    <div style="font-weight:bold;">{{ $nombreJefe }}</div>
                    <div style="font-size:12px;">{{ $cargoJefe }}</div>
                </td>
            </tr>
        </table>

        <!-- FIRMA CENTRAL: Tutor -->
        <div style="width:45%; margin:70px auto 0 auto; text-align:center;">
            <div style="border-top:1px solid #000; width:100%; margin-bottom:5px;"></div>
            <div style="font-weight:bold;">{{ $tutor['nombre'] }}</div>
            <div style="font-size:12px;">Tutor</div>
        </div>
    </div>

    {{-- pie de pagina con numeracion --}}
    <script type="text/php">
        if (isset($pdf)) {
        $font = $fontMetrics->get_font("Arial", "normal");
        $color = array(0, 0, 0);
        $anchoPagina = $pdf->get_width();
        
        $texto1 = "ITPAC-AC-PO-010-04 Pagina {PAGE_NUM} de {PAGE_COUNT}";
        $texto2 = '"Toda copia en PAPEL o ARCHIVO ELECTRONICO es un Documento No Controlado a excepcion del original"';
        
        $ancho1 = $fontMetrics->get_text_width($texto1, $font, 9);
        $ancho2 = $fontMetrics->get_text_width($texto2, $font, 8);
        
        $x1 = ($anchoPagina - $ancho1) / 2;
        $x2 = ($anchoPagina - $ancho2) / 2;
        
        $pdf->page_text($x1, 760, $texto1, $font, 9, $color);
        $pdf->page_text($x2, 775, $texto2, $font, 8, $color);
    }
</script>
</body>

</html>