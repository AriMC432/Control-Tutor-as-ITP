@extends('layouts.app')

@section('title', 'Periodos Escolares')

@section('content')

    {{-- Incluimos la navegación del Jefe --}}
    @include('jefe._subnav')

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">

                {{-- Encabezado --}}
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h2 class="fw-bold text-dark mb-0">Ciclos Escolares</h2>
                    <span class="text-muted">Configuración del Semestre Actual</span>
                
                @if($periodoActual)
                        <span class="badge bg-info fs-5 p-2 shadow-sm">
                            <i class="bi bi-calendar-check me-1"></i> Periodo activo: {{ $periodoActual->nombre }}
                        </span>
                    @endif
                </div>

                {{-- Mensajes de Feedback --}}
                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center shadow-sm border-0" role="alert">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger shadow-sm border-0">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    
                    {{-- COLUMNA 1: FORMULARIO DE NUEVO PERIODO --}}
                    <div class="col-md-5 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-primary text-white py-3">
                                <h5 class="mb-0 fw-bold"><i class="bi bi-calendar-range me-2"></i> Nuevo Ciclo</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="alert alert-warning border small">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                    <strong>Atención:</strong> Al crear un nuevo periodo, este se convertirá en el <strong>ACTIVO</strong> y todos los anteriores se cerrarán automáticamente.
                                </div>

                                <form action="{{ route('jefe.guardar_periodo') }}" method="POST">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Nombre del Periodo</label>
                                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Enero-Junio 2026" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Fecha de Inicio</label>
                                        <input type="date" name="fecha_inicio" class="form-control" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-medium">Fecha de Fin</label>
                                        <input type="date" name="fecha_fin" class="form-control" required>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary fw-bold" onclick="return confirm('¿Estás seguro de iniciar un nuevo ciclo escolar? Esto ocultará los grupos actuales para crear nuevos.')">
                                            <i class="bi bi-power me-2"></i> Activar Nuevo Ciclo
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- COLUMNA 2: HISTORIAL --}}
                    <div class="col-md-7 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-bold text-secondary"><i class="bi bi-clock-history me-2"></i> Historial</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Periodo</th>
                                            <th>Fechas</th>
                                            <th class="text-end pe-4">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($periodos as $periodo)
                                            <tr class="{{ $periodo->activo ? 'table-success' : '' }}">
                                                <td class="ps-4 fw-medium">{{ $periodo->nombre }}</td>
                                                <td class="small text-muted">
                                                    {{ \Carbon\Carbon::parse($periodo->fecha_inicio)->format('d/m/Y') }} <br> 
                                                    {{ \Carbon\Carbon::parse($periodo->fecha_fin)->format('d/m/Y') }}
                                                </td>
                                                <td class="text-end pe-4 align-middle">
    @if($periodo->activo == 1)
        <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">ACTIVO</span>
    @else
        <form action="{{ route('periodo.activar.global') }}" method="POST" class="m-0 d-inline-block">
            @csrf
            <input type="hidden" name="id_periodo" value="{{ $periodo->id_periodo }}">
            <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold shadow-sm" 
                    onclick="return confirm('¿Deseas activar {{ $periodo->nombre }} para toda la escuela?')">
                Activar ciclo
            </button>
        </form>
    @endif
</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-muted">No hay periodos registrados.</td>
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
    </div>
@endsection