@extends('layouts.app')

@section('title', 'Gestionar Tutorías')

@section('content')

@include('docente._subnav')

<div class="container py-4">
    <div class="row justify-content-center">

        
        {{-- COLUMNA 1: FORMULARIO DE ALTA (AGENDAR) --}}
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px; z-index: 1;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-calendar-plus me-2"></i>Agendar Nueva
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center small py-2">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger small py-2">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('docente.store_tutoria') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Tipo de Sesión</label>
                            <select class="form-select" name="tipo" id="tipoTutoria" onchange="toggleFormulario()">
                                <option value="grupal" selected>👥 Grupal (Todo el grupo)</option>
                                <option value="individual">👤 Individual (Un estudiante)</option>
                            </select>
                        </div>
                        <div id="camposGrupal">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Grupo</label>
                                <select class="form-select" name="grupo_id">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach($gruposAsignados as $grupo)
                                        <option value="{{ $grupo->id_grupo }}">
                                            {{ $grupo->nombre }} {{ $grupo->carrera ? '(' . $grupo->carrera->nombre . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Tema</label>
                                <input type="text" class="form-control" name="tema" placeholder="Ej. Integración...">
                            </div>
                        </div>
                        <div id="camposIndividual" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label fw-medium text-primary">1. Grupo del Alumno</label>
                                <select class="form-select" id="filtroGrupoIndiv" onchange="filtrarAlumnos()">
                                    <option value="">-- Seleccionar Grupo --</option>
                                    @foreach($gruposAsignados as $grupo)
                                        <option value="{{ $grupo->id_grupo }}">{{ $grupo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium text-primary">2. Estudiante</label>
                                <select class="form-select" name="estudiante_id" id="selectEstudiante" disabled>
                                    <option value="">-- Primero el grupo --</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Motivo</label>
                                <input type="text" class="form-control" name="motivo" placeholder="Ej. Bajo rendimiento">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Observaciones</label>
                                <textarea class="form-control" name="observaciones" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium text-success">Estado</label>
                                <select name="asistencia" class="form-select">
                                    <option value="" selected>📅 Programada (Pendiente)</option>
                                    <option value="1">✅ Realizada (Asistió)</option>
                                    <option value="0">❌ No Asistió (Falta)</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-medium">Fecha</label>
                                <input type="date" class="form-control" name="fecha" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-medium">Hora</label>
                                <input type="time" class="form-control" name="hora" required>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold">
                                <i class="bi bi-save me-1"></i> Agendar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- COLUMNA 2: LISTADO Y EDICIÓN --}}
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-list-check me-2"></i>Mis Tutorías del Periodo
                    </h5>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="grupales-tab" data-bs-toggle="tab" data-bs-target="#grupales-pane" type="button" role="tab">Grupales</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="individuales-tab" data-bs-toggle="tab" data-bs-target="#individuales-pane" type="button" role="tab">Individuales</button>
                        </li>
                    </ul>
                    <div class="tab-content p-3" id="myTabContent">
                        {{-- LISTA GRUPALES --}}
                        <div class="tab-pane fade show active" id="grupales-pane" role="tabpanel">
                            @if($misTutoriasGrupales->isEmpty())
                                <p class="text-center text-muted py-4">No has registrado tutorías grupales este semestre.</p>
                            @else
                                <div class="list-group list-group-flush">
                                    @foreach($misTutoriasGrupales as $tg)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1 fw-bold">{{ $tg->tema }}</h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($tg->fecha)->format('d/m/Y') }}
                                                    @if($tg->hora) <i class="bi bi-clock ms-2 me-1"></i>{{ \Carbon\Carbon::parse($tg->hora)->format('H:i') }} @endif
                                                    &nbsp;|&nbsp;
                                                    <i class="bi bi-people me-1"></i>{{ $tg->grupo->nombre ?? 'Sin Grupo' }}
                                                </small>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditGrupal{{ $tg->id_tutoria_grupal }}">
                                                <i class="bi bi-pencil-square me-1"></i> Editar / Pasar Lista
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        {{-- LISTA INDIVIDUALES --}}
                        <div class="tab-pane fade" id="individuales-pane" role="tabpanel">
                            @if($misTutoriasIndividuales->isEmpty())
                                <p class="text-center text-muted py-4">No has registrado tutorías individuales este semestre.</p>
                            @else
                                <div class="list-group list-group-flush">
                                    @foreach($misTutoriasIndividuales as $ti)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1 fw-bold">{{ $ti->estudiante->nombre ?? 'Alumno' }} {{ $ti->estudiante->paterno ?? '' }}</h6>
                                                <small class="d-block text-secondary">{{ $ti->motivo }}</small>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($ti->fecha)->format('d/m/Y') }}
                                                    @if($ti->hora) <i class="bi bi-clock ms-2 me-1"></i>{{ \Carbon\Carbon::parse($ti->hora)->format('H:i') }} @endif
                                                    @if($ti->asistencia === 1) <span class="badge bg-success ms-2">Asistió</span>
                                                    @elseif($ti->asistencia === 0) <span class="badge bg-danger ms-2">Falta</span>
                                                    @else <span class="badge bg-warning text-dark ms-2">Pendiente</span> @endif
                                                </small>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditIndiv{{ $ti->id_tutoria_individual }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODALES GRUPALES --}}
@foreach($misTutoriasGrupales as $tg)
<div class="modal fade" id="modalEditGrupal{{ $tg->id_tutoria_grupal }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-primary">Editar Tutoría y Asistencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('docente.update_tutoria') }}" method="POST">
                @csrf
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <input type="hidden" name="tipo" value="grupal">
                    <input type="hidden" name="id_tutoria" value="{{ $tg->id_tutoria_grupal }}">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Tema de la Sesión</label>
                        <input type="text" class="form-control" name="tema" value="{{ $tg->tema }}" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-medium">Fecha</label>
                            <input type="date" class="form-control" name="fecha" value="{{ \Carbon\Carbon::parse($tg->fecha)->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium">Hora</label>
                            <input type="time" class="form-control" name="hora" value="{{ $tg->hora }}" required>
                        </div>
                    </div>
                    <hr class="my-2">
                    <h6 class="fw-bold mb-2"><i class="bi bi-check2-square me-2"></i>Pase de Lista - {{ $tg->grupo->nombre ?? '' }}</h6>
                    @if($tg->grupo && $tg->grupo->estudiantes->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-2">Estudiante</th>
                                        <th style="width: 130px;" class="text-center">Asistencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tg->grupo->estudiantes as $estudiante)
                                        @php
                                            $detalle = $tg->detalles->where('id_estudiante', $estudiante->id_estudiante)->first();
                                            $asistenciaActual = $detalle ? $detalle->asistencia : null;
                                        @endphp
                                        <tr>
                                            <td class="ps-2">
                                                <span class="fw-medium">{{ $estudiante->paterno }} {{ $estudiante->materno }}</span> {{ $estudiante->nombre }}
                                                <br><small class="text-muted">{{ $estudiante->num_control }}</small>
                                            </td>
                                            <td class="text-center">
                                                <select name="asistencias[{{ $estudiante->id_estudiante }}]" class="form-select form-select-sm d-inline-block w-auto" style="width: 110px;">
                                                    <option value="" {{ is_null($asistenciaActual) ? 'selected' : '' }}>- Pendiente -</option>
                                                    <option value="1" {{ $asistenciaActual === 1 ? 'selected' : '' }}>✅ Asistió</option>
                                                    <option value="0" {{ $asistenciaActual === 0 ? 'selected' : '' }}>❌ Falta</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning py-2">No hay alumnos registrados en este grupo.</div>
                    @endif
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">Guardar Todo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- MODALES INDIVIDUALES --}}
@foreach($misTutoriasIndividuales as $ti)
<div class="modal fade" id="modalEditIndiv{{ $ti->id_tutoria_individual }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-primary">Editar Tutoría Individual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('docente.update_tutoria') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="tipo" value="individual">
                    <input type="hidden" name="id_tutoria" value="{{ $ti->id_tutoria_individual }}">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Motivo</label>
                        <input type="text" class="form-control" name="motivo" value="{{ $ti->motivo }}" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha</label>
                            <input type="date" class="form-control" name="fecha" value="{{ $ti->fecha ? \Carbon\Carbon::parse($ti->fecha)->format('Y-m-d') : '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Hora</label>
                            <input type="time" class="form-control" name="hora" value="{{ $ti->hora ? \Carbon\Carbon::parse($ti->hora)->format('H:i') : '' }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Observaciones</label>
                        <textarea class="form-control" name="observaciones" rows="3">{{ $ti->observaciones }}</textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold text-success">Estado de Asistencia</label>
                        <select name="asistencia" class="form-select">
                            <option value="" {{ is_null($ti->asistencia) ? 'selected' : '' }}>📅 Pendiente (Programada)</option>
                            <option value="1" {{ $ti->asistencia === 1 ? 'selected' : '' }}>✅ Asistió</option>
                            <option value="0" {{ $ti->asistencia === 0 ? 'selected' : '' }}>❌ Falta</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Actualizar Datos</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div id="data-grupos" data-json="{{ json_encode($gruposAsignados) }}" style="display: none;"></div>

<script>
    const container = document.getElementById('data-grupos');
    const dataGrupos = JSON.parse(container.getAttribute('data-json'));
    
    function toggleFormulario() {
        const tipo = document.getElementById('tipoTutoria').value;
        const divGrupal = document.getElementById('camposGrupal');
        const divIndividual = document.getElementById('camposIndividual');
        if (tipo === 'grupal') {
            divGrupal.style.display = 'block';
            divIndividual.style.display = 'none';
        } else {
            divGrupal.style.display = 'none';
            divIndividual.style.display = 'block';
        }
    }
    
    function filtrarAlumnos() {
        const grupoIdSeleccionado = document.getElementById('filtroGrupoIndiv').value;
        const selectEstudiante = document.getElementById('selectEstudiante');
        selectEstudiante.innerHTML = '<option value="">-- Selecciona al estudiante --</option>';
        selectEstudiante.disabled = true;
        if (!grupoIdSeleccionado) return;
        const grupoEncontrado = dataGrupos.find(g => g.id_grupo == grupoIdSeleccionado);
        if (grupoEncontrado && grupoEncontrado.estudiantes && grupoEncontrado.estudiantes.length > 0) {
            selectEstudiante.disabled = false;
            grupoEncontrado.estudiantes.forEach(est => {
                const opcion = document.createElement('option');
                opcion.value = est.id_estudiante;
                opcion.text = `${est.paterno} ${est.materno || ''} ${est.nombre} (${est.num_control})`;
                selectEstudiante.appendChild(opcion);
            });
        } else {
            const opcion = document.createElement('option');
            opcion.text = "No hay alumnos registrados en este grupo";
            selectEstudiante.appendChild(opcion);
        }
    }
</script>
@endsection