@extends('layouts.app')

@section('title', 'Coordinador Institucional de Tutorías')

@includeWhen(true, 'coordinador_institucional._subnav')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background-color: #e8f0fe !important;">
            <div class="card-body py-4">
                <h5 class="text-secondary mb-1" style="font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    <i class="bi bi-calendar3 me-2"></i> Ciclo Escolar Actual
                </h5>
                <h2 class="fw-bold mb-0" style="color: #174c9b !important;">
                    {{ $periodoActivo ? $periodoActivo->nombre : 'Sin periodo activo' }}
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="card p-4 text-start">
            <h4 class="fw-semibold mb-2">Panel del Coordinador institucional de tutorías</h4>
            <p class="text-muted mb-0">Sistematizar, dar seguimiento y evaluar el impacto del Programa Institucional de Tutoría (PIT).</p>
        </div>
    </div>

    {{-- Métricas rápidas --}}
    <div class="col-12">
        <div class="card p-3">
            <h5 class="mb-3">Resumen institucional</h5>
            <div class="row text-center">
                <div class="col-6 col-lg-2 mb-3">
                    <h2 class="mb-0 text-primary">{{ $totalEstudiantes ?? 0 }}</h2>
                    <div class="text-muted">Estudiantes</div>
                </div>
                <div class="col-6 col-lg-2 mb-3">
                    <h2 class="mb-0 text-primary">{{ $totalDocentes ?? 0 }}</h2>
                    <div class="text-muted">Docentes</div>
                </div>
                <div class="col-6 col-lg-2 mb-3">
                    <h2 class="mb-0 text-primary">{{ $totalGrupos ?? 0 }}</h2>
                    <div class="text-muted">Grupos</div>
                </div>
                <div class="col-6 col-lg-2 mb-3">
                    <h2 class="mb-0 text-primary">{{ $totalCarreras ?? 0 }}</h2>
                    <div class="text-muted">Carreras</div>
                </div>
                <div class="col-6 col-lg-2 mb-3">
                    <h2 class="mb-0 text-primary">{{ $totalTutorias ?? 0 }}</h2>
                    <div class="text-muted">Tutorías totales</div>
                </div>
                <div class="col-6 col-lg-2 mb-3">
                    <h2 class="mb-0 text-primary">{{ $totalCanalizaciones ?? 0 }}</h2>
                    <div class="text-muted">Canalizaciones</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection