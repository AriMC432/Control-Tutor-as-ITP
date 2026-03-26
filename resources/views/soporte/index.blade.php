@extends('layouts.app')

@section('title','Jefe de Departamento')

@include('soporte._subnav')


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
  <div class="card p-4 text-center shadow-sm border-0">
    <div class="card-body">
        <h4 class="fw-bold text-primary mb-3">
            <i class="bi bi-briefcase-fill me-2"></i>Panel de Soporte
        </h4>
        <p class="text-muted fs-5">
            Bienvenido, <strong>{{ session('user_name') ?? 'Usuario' }}</strong>.
        </p>
        <p class="text-secondary">
            Selecciona una opción del menú superior para gestionar alumnos, docentes y grupos.
        </p>
    </div>
  </div>
@endsection