@extends('layouts.app')
@section('title', 'Panel SuperAdmin')
@include('superadmin._subnav')

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
<div class="container py-5 text-center">
    <div class="card border-0 shadow-sm p-5">
        <h1 class="fw-bold text-primary mb-3">Panel de Super Administrador</h1>
        <p class="lead text-muted">Gestión centralizada de usuarios y permisos.</p>
        
        <div class="row justify-content-center mt-4">
            <div class="col-md-4">
                <div class="card border border-light shadow-sm h-100 hover-shadow">
                    <div class="card-body p-4">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-person-plus-fill fs-1"></i>
                        </div>
                        <h4>Alta de Usuarios</h4>
                        <p class="text-muted small">Registra nuevos Docentes, Jefes o Coordinadores.</p>
                        <a href="{{ route('superadmin.create_docente') }}" class="btn btn-primary w-100">Ir a Altas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection