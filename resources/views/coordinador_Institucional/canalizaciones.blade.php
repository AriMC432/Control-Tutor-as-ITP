@extends('layouts.app')

@section('title', 'Metricas de canalizaciones')

@includeWhen(true, 'coordinador_institucional._subnav')

@section('content')
<div class="container-fluid px-0">
    {{-- encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1" style="color: #1a3a6b;">Métricas de canalizaciones</h4>
            <p class="text-muted small mb-0">Estadísticas institucionales</p>
        </div>
     
    </div>

    {{-- tarjetas de metricas principales --}}
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-send fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">Total</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $totalCanalizaciones }}</h2>
                    <p class="text-muted small mt-2 mb-0">Canalizaciones realizadas</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-check-circle-fill fs-4" style="color: #28a745;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">Completadas</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #28a745;">{{ $atendidas }}</h2>
                    <p class="text-muted small mt-2 mb-0">Canalizaciones resueltas o completadas</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-clock-history fs-4" style="color: #ffc107;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">Proceso</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #ffc107;">{{ $enProceso }}</h2>
                    <p class="text-muted small mt-2 mb-0">En proceso</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-hourglass-split fs-4" style="color: #6c757d;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">Pendientes</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #6c757d;">{{ $pendientes }}</h2>
                    <p class="text-muted small mt-2 mb-0">Pendientes de atención</p>
                </div>
            </div>
        </div>
    </div>

    {{-- indicador de tasa de atencion --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-semibold mb-0" style="color: #1a3a6b;">Tasa de atención</h6>
                        <span class="fw-bold" style="color: #1a3a6b;">{{ $tasaAtencion }}%</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $tasaAtencion }}%; background-color: #1a3a6b;" aria-valuenow="{{ $tasaAtencion }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="text-muted small mt-2 mb-0">Porcentaje de canalizaciones que han sido completadas o resueltas</p>
                </div>
            </div>
        </div>
    </div>

    {{-- tabla de canalizaciones por area --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h5 class="fw-semibold" style="color: #1a3a6b;">Canalizaciones por área</h5>
            <p class="text-muted small">Distribución por área de atencion especializada</p>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead style="background-color: #f5f7fa;">
                        <tr>
                            <th class="py-3 ps-3" style="color: #1a3a6b; font-weight: 600;">Área</th>
                            <th class="py-3 text-center" style="color: #1a3a6b; font-weight: 600;">Canalizaciones</th>
                            <th class="py-3 text-center" style="color: #1a3a6b; font-weight: 600;">Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($canalizacionesPorArea as $area)
                        <tr>
                            <td class="ps-3">
                                <div>
                                    <span class="fw-medium d-block" style="color: #2c3e50;">{{ $area->nombre }}</span>
                                    @if($area->descripcion)
                                        <small class="text-muted">{{ $area->descripcion }}</small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold" style="color: #1a3a6b;">{{ $area->total }}</span>
                            </td>
                            <td class="text-center">
                                <span class="text-muted">{{ $area->porcentaje }}%</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No hay canalizaciones registradas
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pb-4 pt-0">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Total general: {{ $totalCanalizaciones }} canalizaciones</small>
                <small class="text-muted">Tasa de atención: {{ $tasaAtencion }}%</small>
            </div>
        </div>
    </div>
</div>
@endsection