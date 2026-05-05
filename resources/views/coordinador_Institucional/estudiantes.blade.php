@extends('layouts.app')

@section('title', 'Metricas de Estudiantes')

@includeWhen(true, 'coordinador_institucional._subnav')

@section('content')
<div class="container-fluid px-0">
    {{-- encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1" style="color: #1a3a6b;">Metricas de Estudiantes</h4>
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
                            <i class="bi bi-people fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">total</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $totalEstudiantes }}</h2>
                    <p class="text-muted small mt-2 mb-0">Estudiantes registrados</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-mortarboard fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">total</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $totalCarreras }}</h2>
                    <p class="text-muted small mt-2 mb-0">Carreras ofertadas</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-grid-3x3-gap-fill fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">promedio</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $promedioPorGrupo }}</h2>
                    <p class="text-muted small mt-2 mb-0">Estudiantes por grupo</p>
                </div>
            </div>
        </div>
    </div>

    {{-- tabla de distribucion por carrera --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h5 class="fw-semibold" style="color: #1a3a6b;">Distribucion por Carrera</h5>
            <p class="text-muted small">Concentracion de estudiantes por programa educativo</p>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead style="background-color: #f5f7fa;">
                        <tr>
                            <th class="py-3 ps-3" style="color: #1a3a6b; font-weight: 600;">Carrera</th>
                            <th class="py-3 text-center" style="color: #1a3a6b; font-weight: 600;">Estudiantes</th>
                            <th class="py-3 text-center" style="color: #1a3a6b; font-weight: 600;">Participacion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($estudiantesPorCarrera as $carrera)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-medium" style="color: #2c3e50;">{{ $carrera->nombre }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold" style="color: #1a3a6b;">{{ $carrera->total }}</span>
                            </td>
                            <td class="text-center">
                                <span class="text-muted">{{ $carrera->porcentaje }}%</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No hay estudiantes registrados
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pb-4 pt-0">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Total general: {{ $totalEstudiantes }} estudiantes</small>
                <small class="text-muted">Actualizado al periodo activo</small>
            </div>
        </div>
    </div>
</div>
@endsection