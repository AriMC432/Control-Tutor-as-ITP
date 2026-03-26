@extends('layouts.app')

@section('title','Coordinador de Tutorías')

@includeWhen(true, 'coordinador._subnav')

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
      <h4 class="fw-semibold mb-2">Panel del Coordinador de Tutorías</h4>
      <p class="text-muted mb-0">Da seguimiento a tutores, consolida informes y genera reportes del área.</p>
    </div>
  </div>

  {{-- Métricas rápidas --}}
  <div class="col-12">
    <div class="card p-3">
      <h5 class="mb-3">Resumen del periodo</h5>
      <div class="row text-center">
        <div class="col-6 col-lg-3 mb-3">
          <h2 class="mb-0 text-primary">{{ $totalTutores ?? 0 }}</h2>
          <div class="text-muted">Tutores</div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
          <h2 class="mb-0 text-primary">{{ $totalGrupos ?? 0 }}</h2>
          <div class="text-muted">Grupos</div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
          <h2 class="mb-0 text-primary">{{ $tutoriasMes ?? 0 }}</h2>
          <div class="text-muted">Tutorías en el mes</div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
          <h2 class="mb-0 text-primary">{{ $asistenciaPromedio ?? 0 }}%</h2>
          <div class="text-muted">Asistencia promedio</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
