@extends('layouts.app')
@section('title', 'Gestión de Canalizaciones')
@section('content')

@include('docente._subnav')

<div class="container py-4">
    
    <div class="row justify-content-center">
      

        {{-- ========================================================= --}}
        {{-- COLUMNA 1: FORMULARIO DE NUEVA CANALIZACIÓN --}}
        {{-- ========================================================= --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px; z-index: 1;">
                <div class="card-header bg-danger text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Nueva Canalización
                    </h5>
                </div>
                <div class="card-body p-4">

                    {{-- Mensajes de Éxito/Error --}}
                    @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center small py-2 mb-3">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger small py-2 mb-3">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('docente.store_canalizacion') }}" method="POST">
                        @csrf

                        {{-- 1. Selección de Tutoría --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-secondary">1. Tutoría de Origen</label>
                            <select name="id_tutoria" class="form-select" required>
                                <option value="" selected disabled>-- Seleccionar Sesión --</option>
                                @foreach($listaTutorias as $lt)
                                <option value="{{ $lt->id }}">{{ $lt->descripcion }}</option>
                                @endforeach
                            </select>
                            <div class="form-text text-muted" style="font-size: 0.8rem;">
                                Solo aparecen tutorías individuales registradas en este periodo.
                            </div>
                        </div>

                        {{-- 2. Área --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-secondary">2. Área de Atención</label>
                            <select name="area_id" class="form-select" required>
                                <option value="" selected disabled>-- Seleccionar Área --</option>
                                @foreach($areasCanalizacion as $area)
                                <option value="{{ $area->id_area }}">{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 3. Observaciones --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-secondary">3. Motivo / Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="5"
                                placeholder="Describe detalladamente el motivo de la canalización para el área correspondiente..."
                                required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger fw-bold shadow-sm">
                                <i class="bi bi-send-fill me-2"></i> Enviar Reporte
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- COLUMNA 2: HISTORIAL Y EDICIÓN --}}
        {{-- ========================================================= --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-clock-history me-2"></i>Historial de Canalizaciones
                    </h5>
                    @if(isset($historialCanalizaciones))
                    <span class="badge bg-light text-dark border">{{ count($historialCanalizaciones) }} registros</span>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Fecha</th>
                                    <th>Alumno</th>
                                    <th>Área</th>
                                    <th>Estatus</th>
                                    <th class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($historialCanalizaciones as $canalizacion)
                                <tr>
                                    <td class="ps-4 text-nowrap">
                                        {{ \Carbon\Carbon::parse($canalizacion->fecha)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        @if($canalizacion->tutoria && $canalizacion->tutoria->estudiante)
                                        <div class="fw-bold text-dark">
                                            {{ $canalizacion->tutoria->estudiante->nombre }}
                                            {{ $canalizacion->tutoria->estudiante->paterno }}
                                        </div>
                                        <small class="text-muted" style="font-size: 0.85em;">
                                            {{ $canalizacion->tutoria->estudiante->num_control }}
                                        </small>
                                        @else
                                        <span class="text-muted fst-italic">Estudiante no encontrado</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border fw-normal">
                                            {{ $canalizacion->area->nombre ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($canalizacion->estatus == 'Pendiente')
                                        <span class="badge bg-warning text-dark border border-warning">Pendiente</span>
                                        @elseif($canalizacion->estatus == 'Atendido')
                                        <span class="badge bg-success border border-success">Atendido</span>
                                        @elseif($canalizacion->estatus == 'En Proceso')
                                        <span class="badge bg-primary border border-primary">En Proceso</span>
                                        @else
                                        <span class="badge bg-secondary">{{ $canalizacion->estatus }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        {{-- BOTÓN EDITAR (Abre Modal) --}}
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalEditCanalizacion{{ $canalizacion->id_canalizacion }}"
                                            title="Editar Canalización">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-folder2-open fs-1 d-block mb-2 opacity-25"></i>
                                        No hay canalizaciones registradas en este periodo escolar.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ================================================================= --}}
{{-- MODALES DE EDICIÓN (AL FINAL DEL ARCHIVO) --}}
{{-- ================================================================= --}}
@foreach($historialCanalizaciones as $canalizacion)
<div class="modal fade" id="modalEditCanalizacion{{ $canalizacion->id_canalizacion }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark">Editar Canalización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            {{-- CORRECCIÓN: Se mantiene el ID en la ruta --}}
            <form action="{{ route('docente.update_canalizacion', $canalizacion->id_canalizacion) }}" method="POST">
                @csrf
                @method('PUT') {{-- <--- ¡ESTA ES LA LÍNEA QUE FALTABA! --}} {{-- ID Oculto para identificar el registro
                            --}} <input type="hidden" name="id_canalizacion" value="{{ $canalizacion->id_canalizacion }}">

                <div class="modal-body p-4">
                    {{-- Información estática del alumno --}}
                    <div class="alert alert-primary bg-opacity-10 border-primary mb-3">
                        <small class="d-block text-primary fw-bold text-uppercase"
                            style="font-size: 0.7rem;">Estudiante</small>
                        <strong class="text-dark">
                            {{ $canalizacion->tutoria->estudiante->nombre ?? 'N/A' }}
                            {{ $canalizacion->tutoria->estudiante->paterno ?? '' }}
                        </strong>
                        <br>
                        <small class="text-muted">Fecha reporte:
                            {{ \Carbon\Carbon::parse($canalizacion->fecha)->format('d/m/Y') }}</small>
                    </div>

                    {{-- Campo Área --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Área de Atención</label>
                        <select name="area_id" class="form-select" required>
                            @foreach($areasCanalizacion as $area)
                            <option value="{{ $area->id_area }}" {{ $canalizacion->id_area == $area->id_area ? 'selected' : '' }}>
                                {{ $area->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Campo Observaciones --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="4"
                            required>{{ $canalizacion->observaciones }}</textarea>
                    </div>

                    {{-- Campo Estatus --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">Estatus Actual</label>
                        <select name="estatus" class="form-select border-primary">
                            <option value="Pendiente" {{ $canalizacion->estatus == 'Pendiente' ? 'selected' : '' }}>🟡
                                Pendiente</option>
                            <option value="En Proceso" {{ $canalizacion->estatus == 'En Proceso' ? 'selected' : '' }}>
                                🔵 En Proceso</option>
                            <option value="Atendido" {{ $canalizacion->estatus == 'Atendido' ? 'selected' : '' }}>🟢
                                Atendido</option>
                            <option value="Cancelado" {{ $canalizacion->estatus == 'Cancelado' ? 'selected' : '' }}>🔴
                                Cancelado</option>
                        </select>
                        <div class="form-text">Actualiza el progreso de este caso.</div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection