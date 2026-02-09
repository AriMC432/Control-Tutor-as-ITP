@extends('layouts.app')

@section('title', 'Mis Canalizaciones')

@include('alumno._subnav')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            {{-- Encabezado --}}
            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                <div>
                    <h2 class="fw-bold text-dark mb-0">Mis Canalizaciones</h2>
                    <span class="text-muted">
                        Periodo: 
                        @if(isset($periodoActual))
                            <span class="badge bg-success">{{ $periodoActual->nombre }}</span>
                        @else
                            <span class="badge bg-danger">No configurado</span>
                        @endif
                    </span>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-folder2-open me-2"></i>Historial de Reportes
                    </h5>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Fecha</th>
                                    <th>Área de Atención</th>
                                    <th>Observaciones</th>
                                    <th class="text-center">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($canalizaciones as $canalizacion)
                                    <tr>
                                        <td class="ps-4 text-nowrap fw-medium">
                                            {{ \Carbon\Carbon::parse($canalizacion['fecha'])->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                {{ $canalizacion['area'] ?? 'General' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-muted small" style="max-width: 350px; line-height: 1.4;">
                                                {{ $canalizacion['observaciones'] }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            {{-- AQUÍ USAMOS EL COLOR QUE MANDAMOS DESDE EL CONTROLADOR --}}
                                            <span class="badge bg-{{ $canalizacion['clase_estatus'] }} rounded-pill px-3 py-2">
                                                {{ $canalizacion['estatus'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <div class="mb-2">
                                                <i class="bi bi-check-circle fs-1 text-success opacity-50"></i>
                                            </div>
                                            <h6 class="fw-bold">¡Todo en orden!</h6>
                                            <p class="mb-0 small">No tienes canalizaciones registradas en este periodo.</p>
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
@endsection