
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consolidado de informes</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #333;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 5px;
        }

        h2 {
            text-align: center;
            font-size: 13px;
            font-weight: normal;
            margin-top: 0;
        }

        .fecha {
            text-align: right;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #999;
            padding: 7px;
            text-align: left;
        }

        th {
            background-color: #e8edf3;
        }

        .vacio {
            text-align: center;
            padding: 20px;
        }

        .resumen {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1>CONSOLIDADO DE INFORMES DE TUTORES</h1>

    <h2>{{ $periodoActivo->nombre }}</h2>

    <p class="fecha">
        Fecha de generación: {{ now()->format('d/m/Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tutor</th>
                <th>Periodo del informe</th>
                <th>Archivo</th>
                <th>Fecha de recepción</th>
                <th>Estatus</th>
            </tr>
        </thead>

        <tbody>
            @forelse($informes as $index => $informe)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>
                        {{ $informe->nombre }} {{ $informe->paterno }}
                    </td>

                    <td>{{ $informe->periodo }}</td>

                    <td>{{ $informe->nombre_original }}</td>

                    <td>
                        {{ $informe->created_at
                            ? \Carbon\Carbon::parse($informe->created_at)->format('d/m/Y')
                            : '—' }}
                    </td>

                    <td>{{ $informe->estatus }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="vacio">
                        No hay informes registrados para este periodo.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="resumen">
        Total de informes recibidos: {{ $informes->count() }}
    </p>

</body>
</html>
