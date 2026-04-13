@extends('layouts.app')
@section('title', 'Alta de Usuarios')
@include('superadmin._subnav')

@section('content')
<div class="container py-4" style="max-width: 800px;">

    {{-- 1. Mensaje de Éxito --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center shadow-sm rounded-3 mb-4">
            <i class="bi bi-check-circle-fill me-2 fs-4"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- 2. ¡ESTO ES LO QUE FALTABA! Mensajes de Error de Validación --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm rounded-3 mb-4">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <strong>Hubo problemas con los datos ingresados:</strong>
            </div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="bi bi-shield-lock-fill me-2"></i>Registrar Nuevo Usuario</h5>
        </div>
        
        <div class="card-body p-5">
            <form action="{{ route('superadmin.store_docente') }}" method="POST">
                @csrf

                <div class="row g-3">
                    {{-- Datos Personales --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nombre(s)</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Apellido Paterno</label>
                        <input type="text" class="form-control @error('paterno') is-invalid @enderror" name="paterno" value="{{ old('paterno') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Apellido Materno</label>
                        <input type="text" class="form-control" name="materno" value="{{ old('materno') }}">
                    </div>

                    {{-- Datos de Cuenta --}}
<div class="col-md-6">
    <label class="form-label fw-bold">Rol a Asignar</label>
    <select class="form-select border-primary @error('id_rol') is-invalid @enderror" name="id_rol" required>
        <option value="">-- Selecciona Rol --</option>
        @foreach($roles as $rol)
            {{-- Filtro para no mostrar Soporte --}}
            @if($rol->nombre !== 'Soporte')
                <option value="{{ $rol->id_rol }}">{{ $rol->nombre }}</option>
            @endif
        @endforeach
    </select>
    
    @if($roles->isEmpty())
        <div class="text-danger small mt-1">No hay roles registrados en la base de datos.</div>
    @endif
</div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Correo Institucional</label>
                        <input type="email" class="form-control @error('correo') is-invalid @enderror" name="correo" value="{{ old('correo') }}" placeholder="usuario@pachuca.tecnm.mx" required>
                    </div>

                    {{-- Contraseña --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Contraseña Inicial</label>
                        <input type="text" class="form-control bg-light font-monospace" name="password" value="12345" required>
                        <div class="form-text text-success">
                            <i class="bi bi-shield-check"></i> La contraseña se encriptará automáticamente al guardar.
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                        <i class="bi bi-save me-2"></i>Crear Cuenta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection