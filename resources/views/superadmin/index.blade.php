@extends('layouts.app')
@section('title', 'Panel SuperAdmin')
@include('superadmin._subnav')

@section('content')
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