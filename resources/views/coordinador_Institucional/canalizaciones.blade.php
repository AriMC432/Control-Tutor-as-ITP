@extends('layouts.app')

@section('title', 'Lista de Canalizaciones')

@includeWhen(true, 'coordinador_institucional._subnav')

@section('content')
<div class="card p-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">Lista de Canalizaciones</h5>
            <div class="text-muted">Todas las canalizaciones realizadas a estudiantes</div>
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
                    <th>Fecha</th>
                    <th>Estudiante</th>
                    <th>Área</th>
                    <th>Estatus</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($canalizaciones as $index => $c)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $c->fecha }}</td>
                    <td>{{ $c->tutoria->estudiante->nombre ?? 'N/A' }} {{ $c->tutoria->estudiante->paterno ?? '' }}</td>
                    <td>{{ $c->area->nombre ?? 'N/A' }}</td>
                    <td>
                        <span class="badge 
                            @if($c->estatus == 'Atendido') bg-success
                            @elseif($c->estatus == 'En Proceso') bg-warning
                            @else bg-secondary
                            @endif">
                            {{ $c->estatus ?? 'Pendiente' }}
                        </span>
                    </td>
                    <td>{{ $c->observaciones ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No hay canalizaciones registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection