@extends('layouts.app')

@section('title', 'Coordinador institucional de tutorias')

@includeWhen(true, 'coordinador_institucional._subnav')

@section('content')
<div class="container-fluid px-0">
    {{-- encabezado con periodo activo --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1" style="color: #1a3a6b;">Panel del coordinador institucional</h4>
            <p class="text-muted small mb-0">Sistematizar, dar seguimiento y evaluar el impacto del programa institucional de tutoria</p>
        </div>
        @if($periodoActivo)
            <span class="badge px-3 py-2" style="background-color: #1a3a6b; color: white;">
                <i class="bi bi-calendar3 me-1"></i> {{ $periodoActivo->nombre }}
            </span>
        @else
            <span class="badge px-3 py-2" style="background-color: #6c757d; color: white;">
                <i class="bi bi-calendar3 me-1"></i> sin periodo activo
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
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $totalEstudiantes ?? 0 }}</h2>
                    <p class="text-muted small mt-2 mb-0">estudiantes registrados</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-person-badge fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">total</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $totalDocentes ?? 0 }}</h2>
                    <p class="text-muted small mt-2 mb-0">docentes registrados</p>
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
                        <span class="badge bg-light text-secondary">total</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $totalGrupos ?? 0 }}</h2>
                    <p class="text-muted small mt-2 mb-0">grupos academicos</p>
                </div>
            </div>
        </div>
    </div>

    {{-- segunda fila de metricas --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-mortarboard fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">total</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $totalCarreras ?? 0 }}</h2>
                    <p class="text-muted small mt-2 mb-0">carreras ofertadas</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-calendar-check fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">total</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ ($totalTutoriasIndividuales ?? 0) + ($totalTutoriasGrupales ?? 0) }}</h2>
                    <p class="text-muted small mt-2 mb-0">tutorias realizadas</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: rgba(26, 58, 107, 0.1);">
                            <i class="bi bi-send fs-4" style="color: #1a3a6b;"></i>
                        </div>
                        <span class="badge bg-light text-secondary">total</span>
                    </div>
                    <h2 class="fw-bold mb-0" style="color: #1a3a6b;">{{ $totalCanalizaciones ?? 0 }}</h2>
                    <p class="text-muted small mt-2 mb-0">canalizaciones realizadas</p>
                </div>
            </div>
        </div>
    </div>

    {{-- tabla de resumen de tutorias por periodo --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h5 class="fw-semibold" style="color: #1a3a6b;">actividad tutorial del periodo</h5>
            <p class="text-muted small">concentrado de tutorias en el ciclo escolar activo</p>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead style="background-color: #f5f7fa;">
                        <tr>
                            <th class="py-3 ps-3" style="color: #1a3a6b; font-weight: 600;">tipo de tutoria</th>
                            <th class="py-3 text-center" style="color: #1a3a6b; font-weight: 600;">cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-3">
                                <span class="fw-medium" style="color: #2c3e50;">tutorias individuales</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold" style="color: #1a3a6b;">{{ $tutoriasIndividualesPeriodo ?? 0 }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-3">
                                <span class="fw-medium" style="color: #2c3e50;">tutorias grupales</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold" style="color: #1a3a6b;">{{ $tutoriasGrupalesPeriodo ?? 0 }}</span>
                            </td>
                        </tr>
                        <tr style="background-color: #f8f9fa;">
                            <td class="ps-3">
                                <span class="fw-bold" style="color: #1a3a6b;">total general</span>
                            </td>
                            <td class="text-center">
                                <span class="badge" style="background-color: #1a3a6b;">{{ ($tutoriasIndividualesPeriodo ?? 0) + ($tutoriasGrupalesPeriodo ?? 0) }}</span>
                             </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pb-4 pt-0">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">datos correspondientes al periodo activo</small>
                <small class="text-muted">actualizacion en tiempo real</small>
            </div>
        </div>
    </div>
</div>
@endsection