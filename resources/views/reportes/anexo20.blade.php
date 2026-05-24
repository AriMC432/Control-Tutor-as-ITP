<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Anexo 20 - Reporte semestral del coordinador de tutoria</title>
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

        .info-coordinador {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-coordinador td,
        .info-coordinador th {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .info-coordinador th {
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

        .text-center {
            text-align: center;
        }

        .firmas {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .firma {
            text-align: center;
            width: 30%;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>

<body>

       {{-- encabezado con imagen desde base de datos --}}
    @php
        $idPeriodo = \App\Models\Periodo::where('nombre', $coordinador['periodo'])->first()->id_periodo ?? null;

        // buscar encabezado SOLO para anexo 20
        $encabezado = null;
        if ($idPeriodo) {
            $encabezado = \App\Models\EncabezadoReporte::where('id_periodo', $idPeriodo)
                ->where('tipo_reporte', 'anexo20')
                ->where('activo', true)
                ->first();
        }

        // si no hay encabezado para anexo 20 en este periodo, buscar uno global (sin periodo)
        if (!$encabezado) {
            $encabezado = \App\Models\EncabezadoReporte::whereNull('id_periodo')
                ->where('tipo_reporte', 'anexo20')
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
            <h4>Reporte Semestral del Coordinador de Tutoria</h4>
            <h4>Anexo 20</h4>
        </div>
    @endif

    {{-- informacion del coordinador y carrera --}}
    <table class="info-coordinador" style="margin-bottom: 0; border-bottom: none;">
        <tr>
            <th colspan="6" class="text-center">Instituto Tecnologico de Pachuca</th>
        </tr>
        <tr>
            <th colspan="3"><strong>Nombre del Coordinador de Tutoria del Departamento Académico: </strong>{{ $coordinador['nombre'] }}</th>
            <th colspan="3"><strong>Fecha: </strong>{{ $coordinador['fecha_llenado'] }}</th>
        </tr>
        <tr>
            <th colspan="3"><strong>Programa educativo: </strong>{{ $coordinador['programa'] }}</th>
            <th colspan="3"><strong>Hora: </strong>{{ $coordinador['hora_actual'] }}</th>
        </tr>
    </table>

    {{-- tabla de docentes --}}
    <table style="width: 100%; border-collapse: collapse; margin-top: 0; border-top: none;">
        <thead>
            <tr>
                <th rowspan="2">Nombre del tutor</th>
                <th rowspan="2">Grupo</th>
                <th colspan="3">Estudiantes atendidos en el semestre</th>
                <th rowspan="2">Área canalizada</th>
            </tr>
            <tr>
                <th class="text-center">Tutoria grupal</th>
                <th class="text-center">Tutoria individual</th>
                <th class="text-center">Estudiantes canalizadose</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datosDocentes as $index => $docente)
            <tr style="background-color: {{ $index % 2 == 0 ? '#fff' : '#f9f9f9' }};">
                <td><strong>{{ $index + 1 }}</strong> {{ $docente->nombre_completo }}</td>
                <td class="text-center">{{ $docente->grupo }}</td>
                <td class="text-center">{{ $docente->tutorias_grupales }}</td>
                <td class="text-center">{{ $docente->tutorias_individuales }}</td>
                <td class="text-center"><strong>{{ $docente->total_tutorias }}</strong></td>
                <td class="text-center">{{ $docente->canalizaciones }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #FFF1CC;">
                <td colspan="2" class="text-center"><strong>TOTALES</strong></td>
                <td class="text-center"><strong>{{ $totalTutorias }}</strong></td>
                <td class="text-center">—</td>
                <td class="text-center"><strong>{{ $totalTutorias }}</strong></td>
                <td class="text-center"><strong>{{ $totalCanalizaciones }}</strong></td>
            </tr>
        </tfoot>
    </table>

    {{-- indicadores de apoyo --}}
    <div style="margin-top: 15px;">
        <strong>Indicadores de apoyo del semestre:</strong>
        <table style="margin-top: 10px;">
            <thead>
                <tr>
                    <th>Indicador</th>
                    <th class="text-center">Cantidad de canalizaciones</th>
                    <th class="text-center">% sobre estudiantes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Indice de canalizacion psicologica</td>
                    <td class="text-center">{{ $canalizacionesPsicologica ?? 0 }}</td>
                    <td class="text-center">{{ $porcentajePsicologica ?? 0 }}%</td>
                </tr>
                <tr>
                    <td>Indice de apoyo a canalizacion al area de extraescolares</td>
                    <td class="text-center">{{ $canalizacionesExtraescolares ?? 0 }}</td>
                    <td class="text-center">{{ $porcentajeExtraescolares ?? 0 }}%</td>
                </tr>
                <tr>
                    <td>Indice de apoyo en gestion de becas</td>
                    <td class="text-center">{{ $canalizacionesBecas ?? 0 }}</td>
                    <td class="text-center">{{ $porcentajeBecas ?? 0 }}%</td>
                </tr>
                <tr>
                    <td>Indice de apoyo en areas academicas</td>
                    <td class="text-center">{{ $canalizacionesAcademica ?? 0 }}</td>
                    <td class="text-center">{{ $porcentajeAcademica ?? 0 }}%</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- instructivo y observaciones unificados --}}
    <div style="border: 1.5px solid #000; padding: 10px; margin-top: 15px;">
        <strong>Instructivo de llenado:</strong>
        <ul style="margin-top: 10px; margin-bottom: 15px; padding-left: 20px;">
            <li>Anote los datos correspondientes en los apartados del encabezado</li>
            <li>En el apartado de Observaciones anotar las actividades adicionales mas importantes realizadas en el semestre</li>
            <li>Este reporte debera ser llenado por el Coordinador de Tutoria del Departamento Academico</li>
            <li>Debera ser entregada al Jefe de Departamento Academico con copia para el Coordinador Institucional de Tutoria</li>
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
            {{ $coordinador['fecha_entrega'] }}
        </span>
    </div>

    <div style="width:100%; margin-top: 50px;">
        <table style="width:100%; text-align:center; border:none;">
            <tr style="border:none;">
                <td style="width:50%; padding-right:20px; border:none;">
                    <div style="border-top:1px solid #000; width:80%; margin:0 auto 5px auto;"></div>
                    <div style="font-weight:bold;">{{ $nombreJefe ?? 'M.C. Anselmo Hernandez Ramirez' }}</div>
                    <div style="font-size:10px;">{{ $cargoJefe ?? 'Jefe de Departamento Academico' }}</div>
                </td>
                <td style="width:50%; padding-left:20px; border:none;">
                    <div style="border-top:1px solid #000; width:80%; margin:0 auto 5px auto;"></div>
                    <div style="font-weight:bold;">{{ $nombreCoordinadorFirma ?? 'Dr. Arturo Gonzalez Ceron' }}</div>
                    <div style="font-size:10px;">{{ $cargoCoordinadorFirma ?? 'Coordinador de Tutoría del Departamento Académico' }}</div>
                </td>
            </tr>
        </table>
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