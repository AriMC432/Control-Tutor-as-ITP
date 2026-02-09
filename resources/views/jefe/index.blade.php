@extends('layouts.app')

@section('title','Jefe de Departamento')

@include('jefe._subnav')

@section('content')
  <div class="card p-4 text-center shadow-sm border-0">
    <div class="card-body">
        <h4 class="fw-bold text-primary mb-3">
            <i class="bi bi-briefcase-fill me-2"></i>Panel del Jefe de Departamento
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