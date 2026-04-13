@extends('layouts.app')

@section('title', 'Lista de Tutorías')

@includeWhen(true, 'coordinador_institucional._subnav')

@section('content')
<div class="card p-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">Lista de Tutorías</h5>
            <div class="text-muted">Todas las tutorías individuales y grupales</div>
        </div>
        @if($periodoActivo)
            <span class="badge bg-info">Periodo activo: {{ $periodoActivo->nombre }}</span>
        @endif
    </div>
    <hr>

    <h6 class="mt-3">Tutorías Individuales</h6>
    <div class="table-responsive mb-4">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estudiante</th>
                    <th>Docente</th>
                    <th>Motivo</th>
                    <th>Asistencia</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tutoriasIndividuales as $index => $t)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $t->fecha }}</td>
                    <td>{{ $t->hora ?? 'N/A' }}</td>
                    <td>{{ $t->estudiante->nombre ?? 'N/A' }} {{ $t->estudiante->paterno ?? '' }}</td>
                    <td>{{ $t->docente->nombre ?? 'N/A' }} {{ $t->docente->paterno ?? '' }}</td>
                    <td>{{ $t->motivo ?? 'N/A' }}</td>
                    <td>
                        <span class="badge {{ $t->asistencia ? 'bg-success' : 'bg-danger' }}">
                            {{ $t->asistencia ? 'Asistió' : ($t->asistencia === false ? 'No asistió' : 'Pendiente') }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No hay tutorías individuales registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h6>Tutorías Grupales</h6>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Grupo</th>
                    <th>Docente</th>
                    <th>Tema</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tutoriasGrupales as $index => $t)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $t->fecha }}</td>
                    <td>{{ $t->hora ?? 'N/A' }}</td>
                    <td>{{ $t->grupo->nombre ?? 'N/A' }}</td>
                    <td>{{ $t->docente->nombre ?? 'N/A' }} {{ $t->docente->paterno ?? '' }}</td>
                    <td>{{ $t->tema ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No hay tutorías grupales registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection