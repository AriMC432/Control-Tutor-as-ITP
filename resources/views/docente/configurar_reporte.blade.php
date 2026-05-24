@extends('layouts.app')

@section('title', 'Configurar reporte anexo 19')

@includeWhen(true, 'docente._subnav')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">

        {{-- ========================================================= --}}
        {{-- COLUMNA 1: DATOS DEL GRUPO, MEDIO DE COMUNICACION Y FIRMAS --}}
        {{-- ========================================================= --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-info-circle me-2"></i>Informacion del grupo
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Grupo</label>
                        <p class="fw-semibold mb-0 text-dark">{{ $grupo->nombre }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Carrera</label>
                        <p class="fw-semibold mb-0 text-dark">{{ $grupo->carrera->nombre ?? 'n/a' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Semestre</label>
                        <p class="fw-semibold mb-0 text-dark">{{ $grupo->semestre }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Periodo</label>
                        <p class="fw-semibold mb-0 text-dark">{{ $periodo->nombre }}</p>
                    </div>

                    <hr>

                    {{-- formulario para guardar medio de comunicacion --}}
                    <form action="{{ route('docente.reporte.guardar_medio', $grupo->id_grupo) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="medio_comunicacion" class="form-label fw-medium text-secondary">Medio o canal de comunicacion</label>
                            <input type="text" class="form-control" id="medio_comunicacion" name="medio_comunicacion" value="{{ $grupo->medio_comunicacion }}" placeholder="ej: whatsapp, zoom, personal, correo">
                            <small class="text-muted">Como se comunica con sus estudiantes</small>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold">
                                <i class="bi bi-save me-1"></i> Guardar
                            </button>
                        </div>
                    </form>

                    <hr>

                    {{-- formulario para fecha y firmas (se envia al generar PDF) --}}
                    <form action="{{ route('docente.reporte.anexo19', [$grupo->id_grupo, $periodo->id_periodo]) }}" method="POST" target="_self">
                        @csrf

                        <div class="mb-3">
                            <label for="fecha_llenado" class="form-label fw-medium text-secondary">Fecha de llenado</label>
                            <input type="date" class="form-control @error('fecha_llenado') is-invalid @enderror"
                                id="fecha_llenado" name="fecha_llenado"
                                value="{{ old('fecha_llenado', date('Y-m-d')) }}" required>
                            <small class="text-muted">Fecha en que se llena el reporte</small>
                            @error('fecha_llenado')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fecha_entrega" class="form-label fw-medium text-secondary">Fecha de entrega</label>
                            <input type="date" class="form-control @error('fecha_entrega') is-invalid @enderror"
                                id="fecha_entrega" name="fecha_entrega"
                                value="{{ old('fecha_entrega', date('Y-m-d')) }}" required>
                            <small class="text-muted">Fecha en que se entrega el reporte (debe ser mayor o igual a la de llenado)</small>
                            @error('fecha_entrega')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="firma_coordinador" class="form-label fw-medium text-secondary">Coordinador de Tutoría</label>
                            <select class="form-select" id="firma_coordinador" name="firma_coordinador" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach(\App\Models\FirmaReporte::where('tipo', 'coordinador_tutoria')->get() as $firma)
                                <option value="{{ $firma->nombre }}|{{ $firma->cargo }}"
                                    {{ old('firma_coordinador') == $firma->nombre . '|' . $firma->cargo ? 'selected' : '' }}>
                                    {{ $firma->nombre }} - {{ $firma->cargo }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Persona que firma como Coordinador de Tutoría</small>
                        </div>

                        <div class="mb-3">
                            <label for="firma_jefe" class="form-label fw-medium text-secondary">Jefe de Departamento</label>
                            <select class="form-select" id="firma_jefe" name="firma_jefe" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach(\App\Models\FirmaReporte::where('tipo', 'jefe_departamento')->get() as $firma)
                                <option value="{{ $firma->nombre }}|{{ $firma->cargo }}"
                                    {{ old('firma_jefe') == $firma->nombre . '|' . $firma->cargo ? 'selected' : '' }}>
                                    {{ $firma->nombre }} - {{ $firma->cargo }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Persona que firma como Jefe de Departamento</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold">
                                <i class="bi bi-file-pdf me-2"></i> Generar reporte PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- COLUMNA 2: PROBLEMAS DE RENDIMIENTO DETECTADOS           --}}
        {{-- ========================================================= --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-exclamation-triangle me-2"></i>Problemas de rendimiento detectados
                    </h5>
                    <p class="text-muted small mt-1 mb-0">Causas posibles: reprobacion por asignatura, inasistencia, problemas economicos, falta de apoyo familiar, indisciplina, accidente, enfermedad</p>
                </div>
                <div class="card-body p-4">

                    {{-- formulario para agregar nuevo problema --}}
                    <div class="bg-light p-3 rounded mb-4">
                        <h6 class="fw-bold mb-3 text-primary">Agregar nuevo problema</h6>
                        <form action="{{ route('docente.reporte.agregar_problema') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_grupo" value="{{ $grupo->id_grupo }}">
                            <input type="hidden" name="id_periodo" value="{{ $periodo->id_periodo }}">

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="descripcion_problema" class="form-label fw-medium">Descripcion del problema</label>
                                    <textarea class="form-control" id="descripcion_problema" name="descripcion_problema" rows="2" required placeholder="ej: reprobacion en varias materias, inasistencia, problemas familiares..."></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="solucion_recomendada" class="form-label fw-medium">Solucion recomendada o acciones tomadas</label>
                                    <textarea class="form-control" id="solucion_recomendada" name="solucion_recomendada" rows="2" required placeholder="ej: asesorias extras, canalizacion a psicologia, reunion con padres..."></textarea>
                                </div>
                                <div class="col-4">
                                    <label for="numero_estudiantes" class="form-label fw-medium">Numero de estudiantes afectados</label>
                                    <input type="number" class="form-control" id="numero_estudiantes" name="numero_estudiantes" min="0" required>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary fw-bold">
                                        <i class="bi bi-plus-circle me-1"></i> Agregar problema
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- lista de problemas existentes --}}
                    <h6 class="fw-bold mb-3 text-secondary">Problemas registrados</h6>

                    @if($problemas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-2 ps-3">Problema</th>
                                    <th class="py-2">Solucion</th>
                                    <th class="py-2 text-center">Estudiantes</th>
                                    <th class="py-2 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($problemas as $problema)
                                <tr id="fila-{{ $problema->id_problema }}">
                                    <td class="ps-3">{{ $problema->descripcion_problema }}</td>
                                    <td>{{ $problema->solucion_recomendada }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">{{ $problema->numero_estudiantes }}</span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editarProblema({{ $problema->id_problema }})">
                                            <i class="bi bi-pencil me-1"></i> Editar
                                        </button>
                                        <form action="{{ route('docente.reporte.eliminar_problema', $problema->id_problema) }}" method="POST" class="d-inline" onsubmit="return confirm('Eliminar este problema?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-light text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                        <p class="text-muted mb-0">No hay problemas registrados para este periodo</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- script para edicion de problemas --}}
<script>
    function editarProblema(id) {
        // obtener la fila
        let fila = document.getElementById('fila-' + id);
        let celdas = fila.querySelectorAll('td');

        // guardar valores originales
        let problemaOriginal = celdas[0].innerHTML;
        let solucionOriginal = celdas[1].innerHTML;
        let estudiantesOriginal = celdas[2].querySelector('span').innerHTML;

        // crear inputs de edicion
        celdas[0].innerHTML = '<textarea class="form-control form-control-sm" id="edit_desc_' + id + '" rows="2">' + problemaOriginal + '</textarea>';
        celdas[1].innerHTML = '<textarea class="form-control form-control-sm" id="edit_sol_' + id + '" rows="2">' + solucionOriginal + '</textarea>';
        celdas[2].innerHTML = '<input type="number" class="form-control form-control-sm text-center" id="edit_num_' + id + '" value="' + estudiantesOriginal + '" min="0" style="width: 80px; margin: 0 auto;">';
        celdas[3].innerHTML =
            '<button type="button" class="btn btn-sm btn-success" onclick="guardarEdicion(' + id + ')">Guardar</button> ' +
            '<button type="button" class="btn btn-sm btn-secondary" onclick="cancelarEdicion(' + id + ', \'' + problemaOriginal + '\', \'' + solucionOriginal + '\', ' + estudiantesOriginal + ')">Cancelar</button>';
    }

    function cancelarEdicion(id, problema, solucion, estudiantes) {
        let fila = document.getElementById('fila-' + id);
        let celdas = fila.querySelectorAll('td');

        celdas[0].innerHTML = problema;
        celdas[1].innerHTML = solucion;
        celdas[2].innerHTML = '<span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">' + estudiantes + '</span>';
        celdas[3].innerHTML =
            '<button type="button" class="btn btn-sm btn-outline-primary" onclick="editarProblema(' + id + ')">Editar</button> ' +
            '<form action="/docente/reporte/eliminar-problema/' + id + '" method="POST" class="d-inline" onsubmit="return confirm(\'Eliminar este problema?\')">' +
            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
            '<input type="hidden" name="_method" value="DELETE">' +
            '<button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>' +
            '</form>';
    }

    function guardarEdicion(id) {
        let descripcion = document.getElementById('edit_desc_' + id).value;
        let solucion = document.getElementById('edit_sol_' + id).value;
        let estudiantes = document.getElementById('edit_num_' + id).value;

        fetch('{{ route("docente.reporte.editar_problema") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id_problema: id,
                    descripcion_problema: descripcion,
                    solucion_recomendada: solucion,
                    numero_estudiantes: estudiantes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al guardar');
                }
            })
            .catch(error => {
                console.error(error);
                alert('Error de conexion');
            });
    }
</script>
@endsection