@extends('layouts.app')

@section('title', 'Gestion de encabezados del reporte')

{{-- mostrar subnav segun el rol del usuario --}}
@php
$userRole = session('user_role');
@endphp

@if($userRole == 'Jefe')
@include('jefe._subnav')
@elseif($userRole == 'Soporte')
@include('soporte._subnav')
@elseif($userRole == 'Coordinador')
@include('coordinador._subnav')
@elseif($userRole == 'Docente')
@include('docente._subnav')
@elseif($userRole == 'Coordinador Institucional')
@include('coordinador_institucional._subnav')
@endif

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- mensajes de feedback --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- formulario para subir nuevo encabezado --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Subir nuevo encabezado</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('encabezados.subir') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_periodo" class="form-label">Periodo (opcional)</label>
                                <select name="id_periodo" id="id_periodo" class="form-select">
                                    <option value="">-- Periodo actual (activo) --</option>
                                    @foreach(\App\Models\Periodo::orderBy('fecha_inicio', 'desc')->get() as $p)
                                    <option value="{{ $p->id_periodo }}" {{ $periodoActivo && $periodoActivo->id_periodo == $p->id_periodo ? 'selected' : '' }}>
                                        {{ $p->nombre }} {{ $p->activo ? '(activo)' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="form-text text-muted">Dejar vacio para asociar al periodo activo</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tipo_reporte" class="form-label">Tipo de reporte</label>
                                <select name="tipo_reporte" id="tipo_reporte" class="form-select" required>
                                    <option value="anexo19">Anexo 19 (Reporte del tutor)</option>
                                    <option value="anexo20">Anexo 20 (Reporte del coordinador)</option>
                                </select>
                                <div class="form-text text-muted">Seleccione que reporte usara este encabezado</div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="encabezado" class="form-label">Imagen del encabezado</label>
                                <input type="file" class="form-control @error('encabezado') is-invalid @enderror"
                                    id="encabezado" name="encabezado" accept="image/jpeg,image/png" required>
                                <div class="form-text text-muted">Formatos: JPG, PNG. Maximo 2MB. Ancho recomendado: 800px</div>
                                @error('encabezado')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-2"></i> Subir encabezado
                        </button>
                    </form>
                </div>
            </div>

            {{-- encabezados activos por tipo --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0 fw-bold">Encabezados activos</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($tiposReporte as $tipo)
                        @php
                        $encabezado = $encabezadosPorTipo[$tipo] ?? null;
                        $nombreTipo = $tipo == 'anexo19' ? 'Anexo 19 (Reporte del tutor)' : 'Anexo 20 (Reporte del coordinador)';
                        @endphp
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <h6 class="fw-bold mb-2" style="color: #1a3a6b;">{{ $nombreTipo }}</h6>
                                @if($encabezado)
                                <img src="{{ asset('storage/' . $encabezado->ruta_imagen) }}"
                                    alt="Encabezado {{ $tipo }}"
                                    class="img-fluid border rounded mb-2"
                                    style="max-width: 100%; max-height: 100px;">
                                <hr>
                                <div class="row small">
                                    <div class="col-6">
                                        <span class="text-muted">Subido por:</span>
                                        <p class="mb-0">{{ $encabezado->subido_por_rol }}</p>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">Fecha:</span>
                                        <p class="mb-0">{{ $encabezado->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                @else
                                <div class="text-center py-3 text-muted">
                                    <i class="bi bi-image fs-1 d-block mb-2"></i>
                                    <p class="mb-0">No hay encabezado activo para este reporte</p>
                                    <small>Sube una imagen usando el formulario superior</small>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- historial de encabezados --}}
            @if($historial->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white py-3">
                    <h5 class="mb-0 fw-bold">Historial de encabezados</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Periodo</th>
                                    <th>Vista previa</th>
                                    <th>Subido por</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historial as $item)
                                <tr>
                                    <td>{{ $item->periodo ? $item->periodo->nombre : 'Global' }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $item->ruta_imagen) }}"
                                            alt="preview"
                                            style="width: 60px; height: 30px; object-fit: cover;"
                                            class="border rounded">
                                    </td>
                                    <td>{{ $item->subido_por_rol }}</td>
                                    <td>{{ $item->created_at->format('d/m/y H:i') }}</td>
                                    <td>
                                        @if($item->activo)
                                        <span class="badge bg-success">Activo</span>
                                        @else
                                        <span class="badge bg-secondary">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->activo)
                                        <form action="{{ route('encabezados.desactivar', $item->id_encabezado) }}" method="POST" class="d-inline" onsubmit="return confirm('Desactivar este encabezado? Se podra activar otro despues.')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-warning" title="Desactivar">
                                                <i class="bi bi-eye-slash"></i> Desactivar
                                            </button>
                                        </form>
                                        <span class="text-muted ms-1">(activo)</span>
                                        @else
                                        <form action="{{ route('encabezados.activar', $item->id_encabezado) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Activar">
                                                <i class="bi bi-check-lg"></i> Activar
                                            </button>
                                        </form>
                                        <form action="{{ route('encabezados.eliminar', $item->id_encabezado) }}" method="POST" class="d-inline" onsubmit="return confirm('Eliminar este encabezado?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection