@extends('layouts.app')

@section('title', 'Metricas de Tutorias')

@includeWhen(true, 'coordinador_institucional._subnav')

@section('content')
<div class="container-fluid px-0">
    {{-- encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1" style="color: #1a3a6b;">Metricas de Tutorias</h4>
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
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-person-workspace fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">individuales</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $totalTutoriasIndividuales }}</h2>
                    <p class="text-muted small mt-2 mb-0">Tutorias individuales</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-people fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">grupales</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $totalTutoriasGrupales }}</h2>
                    <p class="text-muted small mt-2 mb-0">Tutorias grupales</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-calendar-check fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">asistencia</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $asistenciaPromedio }}%</h2>
                    <p class="text-muted small mt-2 mb-0">Asistencia promedio</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-bar-chart fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">promedio</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $promedioTutoriasPorDocente }}</h2>
                    <p class="text-muted small mt-2 mb-0">Tutorias por docente</p>
                </div>
            </div>
        </div>
    </div>

    {{-- tabla de tutorias por mes --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h5 class="fw-semibold" style="color: #1a3a6b;">Tutorias por Mes</h5>
            <p class="text-muted small">Distribucion mensual de sesiones de tutorias</p>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead style="background-color: #f5f7fa;">
                        <tr>
                            <th class="py-3 ps-3" style="color: #1a3a6b; font-weight: 600;">Mes</th>
                            <th class="py-3 text-center" style="color: #1a3a6b; font-weight: 600;">Individuales</th>
                            <th class="py-3 text-center" style="color: #1a3a6b; font-weight: 600;">Grupales</th>
                            <th class="py-3 text-center" style="color: #1a3a6b; font-weight: 600;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tutoriasPorMes as $mes)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-medium" style="color: #2c3e50;">{{ $mes->mes }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold" style="color: #1a3a6b;">{{ $mes->individuales }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold" style="color: #1a3a6b;">{{ $mes->grupales }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge" style="background-color: #1a3a6b;">{{ $mes->total }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No hay tutorias registradas
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pb-4 pt-0">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Total general: {{ $totalTutorias }} tutorias</small>
                <small class="text-muted">{{ $totalDocentesConTutorias }} docentes con actividad tutorial</small>
            </div>
        </div>
    </div>
</div>
@endsection