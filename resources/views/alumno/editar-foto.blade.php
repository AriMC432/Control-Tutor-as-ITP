@extends('layouts.app')

@section('title', 'Editar Foto de Perfil')

@includeWhen(true, 'alumno._subnav')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card p-4 shadow-sm border-0">
                <h4 class="text-center mb-4">Editar foto de perfil</h4>

                {{-- Foto actual --}}
                <div class="text-center mb-4">
                    <div class="foto-container" style="margin: 0 auto;">
                        <img src="{{ $estudiante->foto_url }}"
                            alt="Foto actual"
                            class="profile-img"
                            onerror="handleImageError(this)"
                            style="width: 200px; height: 200px;">
                    </div>
                    <p class="text-muted mt-3">Foto actual</p>
                </div>

                {{-- Mensajes de error --}}
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Formulario para subir foto --}}
                <form action="{{ route('alumno.perfil.actualizar-foto') }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="foto" class="form-label">Seleccionar nueva foto</label>
                        <input type="file"
                            class="form-control @error('foto') is-invalid @enderror"
                            id="foto"
                            name="foto"
                            accept="image/*"
                            required>
                        <small class="text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
                        @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('alumno.perfil') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-2"></i>Subir Foto
                        </button>
                    </div>
                </form>

                {{-- Eliminar foto (solo si tiene foto) --}}
                @if($estudiante->foto)
                <hr class="my-4">
                <form action="{{ route('alumno.perfil.eliminar-foto') }}"
                    method="POST"
                    onsubmit="return confirm('¿Estás seguro de eliminar tu foto de perfil?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-2"></i>Eliminar foto actual
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection