@extends('layouts.app')

@section('title', 'Gestion de firmas para reportes')

@php
    $userRole = session('user_role');
@endphp

@if($userRole == 'Soporte')
    @include('soporte._subnav')
@endif

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-semibold mb-1" style="color: #1a3a6b;">Gestion de firmas</h4>
                    <p class="text-muted small mb-0">Administrar las personas que firman los reportes anexo 19 y 20</p>
                </div>
            </div>
            
            {{-- mensajes --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            {{-- firmas para jefe de departamento --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Jefe de Departamento Academico</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($firmasJefe as $firma)
                                <tr id="fila-{{ $firma->id_firma }}">
                                    <td>{{ $firma->nombre }}</td>
                                    <td>{{ $firma->cargo }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger" onclick="eliminarFirma({{ $firma->id_firma }})">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <hr>
                    <h6 class="fw-bold">Agregar nuevo</h6>
                    <form id="formJefe" class="row g-2" onsubmit="event.preventDefault(); agregarFirma('jefe_departamento')">
                        <div class="col-md-5">
                            <input type="text" id="nombre_jefe" class="form-control" placeholder="Nombre completo" required>
                        </div>
                        <div class="col-md-5">
                            <input type="text" id="cargo_jefe" class="form-control" placeholder="Cargo" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- firmas para coordinador de tutoria --}}
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Coordinador de Tutoria del Departamento Academico</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($firmasCoordinador as $firma)
                                <tr id="fila-{{ $firma->id_firma }}">
                                    <td>{{ $firma->nombre }}</td>
                                    <td>{{ $firma->cargo }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger" onclick="eliminarFirma({{ $firma->id_firma }})">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <hr>
                    <h6 class="fw-bold">Agregar nuevo</h6>
                    <form id="formCoordinador" class="row g-2" onsubmit="event.preventDefault(); agregarFirma('coordinador_tutoria')">
                        <div class="col-md-5">
                            <input type="text" id="nombre_coordinador" class="form-control" placeholder="Nombre completo" required>
                        </div>
                        <div class="col-md-5">
                            <input type="text" id="cargo_coordinador" class="form-control" placeholder="Cargo" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
const csrfToken = '{{ csrf_token() }}';

async function agregarFirma(tipo) {
    let nombre, cargo;
    if (tipo === 'jefe_departamento') {
        nombre = document.getElementById('nombre_jefe').value;
        cargo = document.getElementById('cargo_jefe').value;
    } else {
        nombre = document.getElementById('nombre_coordinador').value;
        cargo = document.getElementById('cargo_coordinador').value;
    }
    
    if (!nombre || !cargo) return;
    
    const response = await fetch('{{ route("firmas.store") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ tipo, nombre, cargo })
    });
    
    const data = await response.json();
    if (data.success) {
        location.reload();
    } else {
        alert('Error al guardar');
    }
}

async function eliminarFirma(id) {
    if (!confirm('Eliminar esta firma?')) return;
    
    const response = await fetch(`/firmas/eliminar/${id}`, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
    });
    
    const data = await response.json();
    if (data.success) {
        location.reload();
    } else {
        alert(data.message || 'Error al eliminar');
    }
}
</script>
@endsection