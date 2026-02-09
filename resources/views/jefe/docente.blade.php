@extends('layouts.app')

@section('title','Alta de Usuarios')

@include('jefe._subnav')

@section('content')
<div class="card p-3">
  <div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-2">Alta de Usuarios</h4>
        <div class="text-muted mb-3">Registra usuarios nuevos y define su rol</div>
    </div>
  </div>
  <hr>

    {{-- Mensajes de feedback --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

<form action="{{ route('jefe.docentes.store') }}" method="POST">
    @csrf
    <div class="row g-2">
      <div class="col-md-6">
        <label class="form-label">Nombre(s)</label>
        <input class="form-control" name="nombre" value="{{ old('nombre') }}" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Apellido paterno</label>
        <input class="form-control" name="paterno" value="{{ old('paterno') }}" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Apellido materno</label>
        <input class="form-control" name="materno" value="{{ old('materno') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">No. control</label>
        <input class="form-control" name="num_control" value="{{ old('num_control') }}" required>
      </div>
      <div class="col-md-8">
        <label class="form-label">Correo</label>
        <input type="email" class="form-control" name="correo" value="{{ old('correo') }}" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Contraseña</label>
        <input type="password" class="form-control" name="contrasena" required>
      </div>
      <div class="col-12">
        <label class="form-label">Rol</label>
        <select class="form-select" name="id_rol" required>
          <option value="">Selecciona…</option>
          {{-- Iteramos los roles enviados desde el controlador --}}
          @foreach($roles as $rol)
            <option value="{{ $rol->id_rol }}" {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>
                {{ $rol->nombre }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-12 d-flex gap-2 mt-2">
        <button class="btn btn-success" type="submit">Registrar docente</button>
        <button class="btn btn-outline-secondary" type="reset">Limpiar</button>
      </div>
    </div>
  </form>
</div>
@endsection