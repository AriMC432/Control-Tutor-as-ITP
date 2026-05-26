@extends('layouts.app')

@section('title', 'Lista de Estudiantes')

@includeWhen(true, 'coordinador_institucional._subnav')

@section('content')
    <div class="card p-3">
                @if($periodoActivo)
                    <span class="badge bg-info fs-5 p-2 shadow-sm">
                        <i class="bi bi-calendar-check me-1"></i> Periodo activo: {{ $periodoActivo->nombre }}
                    </span>
                @endif
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">Lista de Estudiantes</h5>
                <div class="text-muted">Todos los estudiantes registrados en el instituto</div>
            </div>

        </div>
        <hr>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Control</th>
                        <th>Nombre completo</th>
                        <th>Grupo</th>
                        <th>Carrera</th>
                        <th>Correo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($estudiantes as $index => $e)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $e->num_control }}</td>
                        <td>{{ $e->nombre }} {{ $e->paterno }} {{ $e->materno }}</td>
                        <td>{{ $e->grupo->nombre ?? 'N/A' }}</td>
                        <td>{{ $e->grupo->carrera->nombre ?? 'N/A' }}</td>
                        <td>{{ $e->correo }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay estudiantes registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection