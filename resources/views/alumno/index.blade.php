@extends('layouts.app')

@section('title', 'Panel del Estudiante')

{{-- 1. Barra de Navegación (Menú y Logout) --}}
@include('alumno._subnav')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background-color: #e8f0fe !important;">
            <div class="card-body py-4">
                <h5 class="text-secondary mb-1" style="font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    <i class="bi bi-calendar3 me-2"></i> Ciclo Escolar Actual
                </h5>
                <h2 class="fw-bold mb-0" style="color: #174c9b !important;">
{{ $periodoActivo ? $periodoActivo->nombre : 'Sin periodo activo' }}                </h2>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">

    {{-- 2. Tarjeta de Bienvenida --}}
    <div class="card p-4 text-start mb-4 border-0 shadow-sm">
        <h4 class="fw-bold text-primary mb-2">Bienvenido(a), {{ $nombre ?? 'Estudiante' }}</h4>
        <p class="text-muted mb-0">
            Desde este panel puedes consultar tus tutorías grupales e individuales, revisar observaciones
            y las canalizaciones emitidas por tu tutor.
        </p>
    </div>

    {{-- 3. Tarjetas de Estadísticas (KPIs) --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card p-3 border-0 shadow-sm h-100">
                <h6 class="text-primary fw-semibold text-uppercase small">Tutorías asistidas</h6>
                <h2 class="fw-bold display-6 mb-0">{{ $totalAsistidas ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-3 border-0 shadow-sm h-100">
                <h6 class="text-success fw-semibold text-uppercase small">Asistencia general</h6>
                <h2 class="fw-bold display-6 mb-0">{{ $porcentajeAsistencia ?? '0%' }}</h2>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-3 border-0 shadow-sm h-100">
                <h6 class="text-danger fw-semibold text-uppercase small">Canalizaciones</h6>
                <h2 class="fw-bold display-6 mb-0">{{ $totalCanalizaciones ?? 0 }}</h2>
            </div>
        </div>
    </div>

    {{-- 4. Tabla de Actividad Reciente --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-secondary">
                <i class="bi bi-clock-history me-2"></i>Actividad Reciente
            </h5>
            <span class="badge bg-light text-secondary border">Últimos movimientos</span>
        </div>
        
        <div class="card-body p-0">
            @if(isset($tutorias) && count($tutorias) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Fecha</th>
                                <th>Tipo</th>
                                <th>Tema / Motivo</th>
                                <th>Tutor</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tutorias as $t)
                                <tr>
                                    <td class="ps-4 fw-semibold text-secondary text-nowrap">
                                        {{ \Illuminate\Support\Carbon::parse($t->fecha)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        @if($t->tipo == 'Grupal')
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Grupal</span>
                                        @else
                                            <span class="badge bg-info bg-opacity-10 text-info text-dark rounded-pill px-3">Individual</span>
                                        @endif
                                    </td>
                                    <td class="text-truncate fw-medium" style="max-width: 250px;" title="{{ $t->tema }}">
                                        {{ $t->tema }}
                                    </td>
                                    <td class="small text-muted">{{ $t->tutor }}</td>
                                    <td>
                                        <span class="badge bg-{{ $t->estado_clase }}">{{ $t->estado_texto }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="card-footer bg-white text-center border-0 py-3">
                    <a href="{{ route('alumno.tutorias') }}" class="text-decoration-none fw-bold small text-primary">
                        Ver historial completo <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-calendar-x fs-1 mb-3 d-block opacity-50"></i>
                    <h6 class="fw-bold">Sin actividad reciente</h6>
                    <p class="small mb-0">No tienes tutorías registradas próximamente.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection