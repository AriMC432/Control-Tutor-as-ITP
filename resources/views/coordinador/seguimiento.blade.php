@extends('layouts.app')

@section('title', 'Seguimiento a tutores')

@section('content')

    @includeWhen(true, 'coordinador._subnav')
  <div class="card p-3">
 
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h5 class="mb-1">Seguimiento a tutores</h5>
        <div class="text-muted">Progreso por tutor y grupo en el periodo seleccionado</div>
      </div>
      <form action="#" method="GET" class="d-flex gap-2">
        <select name="mes" class="form-select form-select-sm">
          <option value="">Mes actual</option>
          {{-- <option value="2025-09">Sep 2025</option> --}}
        </select>
        <select name="carrera" class="form-select form-select-sm">
          <option value="">Todas las carreras</option>
          {{-- @foreach($carreras as $c) <option value="{{ $c->id_carrera }}">{{ $c->nombre }}</option> @endforeach --}}
        </select>
        <button class="btn btn-success btn-sm">Filtrar</button>
      </form>
    </div>
    <hr>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Tutor</th>
            <th>Grupo</th>
            <th>Tutorías (mes)</th>
            <th>Asistencia prom.</th>
            <th>Última sesión</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        
        <tbody>
            @forelse($seguimiento as $s)
                <tr>
                    <td>{{ $s->tutor }}</td>
                    <td>{{ $s->grupo }}</td>
                    <td>{{ $s->tutorias_mes }}</td>
                    <td>{{ $s->asistencia_prom }}%</td>
                    <td>{{ $s->ultima_sesion }}</td>
                    <td>
                        @if($s->estado === 'Activo')
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Pendiente</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="#" class="btn btn-outline-secondary">
                                Detalle
                            </a>
                            <a href="#" class="btn btn-success">
                                Solicitar informe
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No hay grupos registrados para el periodo escolar activo.
                    </td>
                </tr>
            @endforelse
        </tbody>

      </table>
    </div>
  </div>
@endsection
