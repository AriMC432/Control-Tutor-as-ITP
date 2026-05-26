@extends('layouts.app')

@section('title', 'Metricas de Docentes')

@includeWhen(true, 'coordinador_institucional._subnav')

@section('content')
<<<<<<< HEAD
    <div class="card p-3">
        @if($periodoActivo)
            <span class="badge bg-info fs-5 p-2 shadow-sm">
                <i class="bi bi-calendar-check me-1"></i> Periodo activo: {{ $periodoActivo->nombre }}
            </span>
        @endif
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">Lista de Docentes</h5>
                <div class="text-muted">Todos los docentes registrados en el instituto</div>
            </div>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Control</th>
                        <th>Nombre completo</th>
                        <th>Rol</th>
                        <th>Correo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($docentes as $index => $d)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $d->num_control }}</td>
                            <td>{{ $d->nombre }} {{ $d->paterno }} {{ $d->materno }}</td>
                            <td>{{ $d->rol->nombre ?? 'N/A' }}</td>
                            <td>{{ $d->correo }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay docentes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
=======
<div class="container-fluid px-0">
    {{-- encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1" style="color: #1a3a6b;">Metricas de Docentes</h4>
            <p class="text-muted small mb-0">Estadisticas institucionales</p>
        </div>
        @if($periodoActivo)
            <span class="badge px-3 py-2" style="background-color: #1a3a6b; color: white;">
                <i class="bi bi-calendar3 me-1"></i> {{ $periodoActivo->nombre }}
            </span>
        @endif
    </div>

    {{-- tarjetas de metricas principales --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-person-badge fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">total</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $totalDocentes }}</h2>
                    <p class="text-muted small mt-2 mb-0">Docentes registrados</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-people-fill fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">activos</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $docentesConGrupo }}</h2>
                    <p class="text-muted small mt-2 mb-0">Docentes con grupo asignado</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-diagram-3 fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">promedio</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $promedioGruposPorDocente }}</h2>
                    <p class="text-muted small mt-2 mb-0">Grupos por docente</p>
                </div>
            </div>
        </div>
    </div>

    {{-- tabla de distribucion por rol --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h5 class="fw-semibold" style="color: #1a3a6b;">Distribucion por Rol</h5>
            <p class="text-muted small">Concentracion de personal por tipo de rol</p>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead style="background-color: #f5f7fa;">
                        <tr>
                            <th class="py-3 ps-3" style="color: #1a3a6b; font-weight: 600;">Rol</th>
                            <th class="py-3 text-center" style="color: #1a3a6b; font-weight: 600;">Docentes</th>
                            <th class="py-3 text-center" style="color: #1a3a6b; font-weight: 600;">Participacion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($docentesPorRol as $rol)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-medium" style="color: #2c3e50;">{{ $rol->nombre }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold" style="color: #1a3a6b;">{{ $rol->total }}</span>
                            </td>
                            <td class="text-center">
                                <span class="text-muted">{{ $rol->porcentaje }}%</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No hay docentes registrados
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pb-4 pt-0">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Total general: {{ $totalDocentes }} docentes</small>
                <small class="text-muted">Docentes activos: {{ $docentesConGrupo }}</small>
            </div>
>>>>>>> 00d5eac3cdbe3cdd50cc5713bb46c71fbc2c9093
        </div>
    </div>
@endsection