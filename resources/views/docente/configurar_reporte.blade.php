@extends('layouts.app')

@section('title', 'Configurar reporte anexo 19')

@includeWhen(true, 'docente._subnav')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        
        {{-- ========================================================= --}}
        {{-- COLUMNA 1: DATOS DEL GRUPO Y MEDIO DE COMUNICACION       --}}
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
                </div>
            </div>
            
            {{-- boton para generar pdf --}}
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body p-4 text-center">
                    <a href="{{ route('docente.reporte.anexo19', [$grupo->id_grupo, $periodo->id_periodo]) }}" class="btn btn-success w-100 fw-bold" target="_blank">
                        <i class="bi bi-file-pdf me-2"></i> Generar reporte PDF
                    </a>
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
                    
                    {{-- lista de problemas existentes con boton de editar --}}
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
                                        {{-- modo vista --}}
                                        <td class="ps-3 vista-{{ $problema->id_problema }}">
                                            {{ $problema->descripcion_problema }}
                                        </td>
                                        <td class="vista-{{ $problema->id_problema }}">
                                            {{ $problema->solucion_recomendada }}
                                        </td>
                                        <td class="text-center vista-{{ $problema->id_problema }}">
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">{{ $problema->numero_estudiantes }}</span>
                                        </td>
                                        <td class="text-center vista-{{ $problema->id_problema }}">
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
                                        
                                        {{-- modo edicion (oculto por defecto) --}}
                                        <td class="ps-3 edicion-{{ $problema->id_problema }}" style="display: none;">
                                            <textarea class="form-control form-control-sm" id="edit_descripcion_{{ $problema->id_problema }}" rows="2">{{ $problema->descripcion_problema }}</textarea>
                                        </td>
                                        <td class="edicion-{{ $problema->id_problema }}" style="display: none;">
                                            <textarea class="form-control form-control-sm" id="edit_solucion_{{ $problema->id_problema }}" rows="2">{{ $problema->solucion_recomendada }}</textarea>
                                        </td>
                                        <td class="text-center edicion-{{ $problema->id_problema }}" style="display: none;">
                                            <input type="number" class="form-control form-control-sm text-center" id="edit_estudiantes_{{ $problema->id_problema }}" value="{{ $problema->numero_estudiantes }}" min="0" style="width: 80px; margin: 0 auto;">
                                        </td>
                                        <td class="text-center edicion-{{ $problema->id_problema }}" style="display: none;">
                                            <button type="button" class="btn btn-sm btn-success" onclick="guardarEdicion({{ $problema->id_problema }})">
                                                <i class="bi bi-check-lg me-1"></i> Guardar
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="cancelarEdicion({{ $problema->id_problema }})">
                                                <i class="bi bi-x-lg me-1"></i> Cancelar
                                            </button>
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
        // ocultar modo vista
        document.querySelectorAll('.vista-' + id).forEach(el => {
            el.style.display = 'none';
        });
        // mostrar modo edicion
        document.querySelectorAll('.edicion-' + id).forEach(el => {
            el.style.display = 'table-cell';
        });
    }
    
    function cancelarEdicion(id) {
        // mostrar modo vista
        document.querySelectorAll('.vista-' + id).forEach(el => {
            el.style.display = 'table-cell';
        });
        // ocultar modo edicion
        document.querySelectorAll('.edicion-' + id).forEach(el => {
            el.style.display = 'none';
        });
    }
    
    function guardarEdicion(id) {
        // obtener valores editados
        let descripcion = document.getElementById('edit_descripcion_' + id).value;
        let solucion = document.getElementById('edit_solucion_' + id).value;
        let estudiantes = document.getElementById('edit_estudiantes_' + id).value;
        
        // enviar via fetch (ajax)
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
                // actualizar valores en modo vista
                document.querySelector('.vista-' + id).innerHTML = descripcion;
                document.querySelector('.vista-' + id + ':nth-child(2)').innerHTML = solucion;
                document.querySelector('.vista-' + id + ':nth-child(3) .badge').innerHTML = estudiantes;
                
                // volver a modo vista
                cancelarEdicion(id);
                
                // mostrar mensaje de exito
                mostrarMensajeExito('Problema actualizado correctamente');
            } else {
                mostrarMensajeError('Error al actualizar el problema');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensajeError('Error de conexion');
        });
    }
    
    function mostrarMensajeExito(mensaje) {
        let alert = document.createElement('div');
        alert.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
        alert.style.zIndex = '9999';
        alert.innerHTML = '<i class="bi bi-check-circle me-2"></i>' + mensaje + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.body.appendChild(alert);
        setTimeout(() => alert.remove(), 3000);
    }
    
    function mostrarMensajeError(mensaje) {
        let alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
        alert.style.zIndex = '9999';
        alert.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>' + mensaje + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.body.appendChild(alert);
        setTimeout(() => alert.remove(), 3000);
    }
</script>
@endsection