@extends('layouts.app')

@section('title', 'Mi Perfil')

@include('coordinador_institucional._subnav')

@section('content')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="card p-4 text-start shadow-sm border-0">
                    @if($periodoActivo)
                        <span class="badge bg-info fs-5 p-2 shadow-sm">
                            <i class="bi bi-calendar-check me-1"></i> Periodo activo: {{ $periodoActivo->nombre }}
                        </span>
                    @endif
                    {{-- Foto de perfil --}}
                    <div class="foto-container">
                        <img src="{{ $usuario->foto_url ?? asset('images/default-avatar.png') }}" alt="foto-perfil"
                            class="profile-img"
                            onerror="this.onerror=null; this.src='/Proyecto_Tec/public/images/default-avatar.png';">

                        <a href="{{ route('coordinst.editar-foto') }}" class="btn-edit-foto" title="Editar foto">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </div>
                    <h5 class="fw-semibold mb-2">Mi Perfil</h5>
                    <p class="text-muted">Consulta tus datos registrados y actualiza tu contraseña.</p>
                    <hr>

                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2 lead"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- SECCIÓN 1: DATOS DE PERFIL (Solo lectura) --}}
                    <h6 class="text-uppercase text-primary fw-bold mt-3 mb-3">Información Institucional</h6>
                    <div class="row g-3 mb-5">
                        <div class="col-md-6">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control"
                                value="{{ $usuario->nombre }} {{ $usuario->paterno }} {{ $usuario->materno }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Número de Control</label>
                            <input type="text" class="form-control" value="{{ $usuario->num_control }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo</label>
                            <input type="email" class="form-control" value="{{ $usuario->correo }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rol en el Sistema</label>
                            <input type="text" class="form-control" value="{{ $usuario->rol->nombre ?? 'N/A' }}" readonly>
                        </div>
                    </div>

                    <hr>

                    {{-- SECCIÓN 2: CAMBIO DE CONTRASEÑA --}}
                    <h6 class="text-uppercase text-secondary fw-bold mt-4 mb-3">Seguridad y Acceso</h6>

                    <form action="{{ route('coordinst.perfil.update_password') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12 mb-3">
                                <label for="current_password" class="form-label">Contraseña Actual <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Nueva Contraseña <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>

                                <div class="card mt-2 border-0 shadow-sm" style="background-color: #f8f9fa;">
                                    <div class="card-body p-2 px-3">
                                        <p class="small fw-bold mb-1 text-secondary" style="font-size: 0.75rem;">REQUISITOS
                                            DE SEGURIDAD:</p>
                                        <ul class="mb-0 ps-3 text-muted" style="font-size: 0.7rem; list-style-type: disc;">
                                            <li>Mínimo 8 caracteres.</li>
                                            <li>Al menos una mayúscula y una minúscula.</li>
                                            <li>Al menos una letra y un número.</li>
                                            <li>Al menos un símbolo (ej. !@#$%*).</li>
                                        </ul>
                                    </div>
                                </div>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                                <div class="mt-2 d-none d-md-block" style="height: 85px;"></div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary px-5 fw-semibold">
                                    <i class="bi bi-key-fill me-2"></i> Actualizar Contraseña
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection