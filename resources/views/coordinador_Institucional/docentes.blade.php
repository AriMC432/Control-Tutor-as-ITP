@extends('layouts.app')

@section('title', 'Lista de Docentes')

@includeWhen(true, 'coordinador_institucional._subnav')

@section('content')
<div class="card p-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">Lista de Docentes</h5>
            <div class="text-muted">Todos los docentes registrados en el instituto</div>
        </div>
        @if($periodoActivo)
            <span class="badge bg-info">Periodo activo: {{ $periodoActivo->nombre }}</span>
        @endif
    </div>
    <hr>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. Control</th>
                    <th>Nombre completo</th>
                    <th>Rol</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($docentes as $index => $d)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $d->num_control }}</td>
                    <td>{{ $d->nombre }} {{ $d->paterno }} {{ $d->materno }}</td>
                    <td>{{ $d->rol->nombre ?? 'N/A' }}</td>
                    <td>{{ $d->correo }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay docentes registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection