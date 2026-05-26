@extends('layouts.app')

@section('title', 'Seguimiento a tutores')

@includeWhen(true, 'coordinador._subnav')

@section('content')
  <div class="card p-3">
      @if($periodoActual)
        <span class="badge bg-info fs-5 p-2 shadow-sm">
          <i class="bi bi-calendar-check me-1"></i> Periodo activo: {{ $periodoActual->nombre }}
        </span>
      @endif
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
          {{-- @foreach($seguimiento as $s) --}}
          <tr>
            <td>—</td>
            <td>—</td>
            <td>0</td>
            <td>0%</td>
            <td>—</td>
            <td><span class="badge bg-secondary">Pendiente</span></td>
            <td>
              <div class="btn-group btn-group-sm">
                <a href="#" class="btn btn-outline">Detalle</a>
                <a href="#" class="btn btn-success">Solicitar informe</a>
              </div>
            </td>
          </tr>
          {{-- @endforeach --}}
        </tbody>
      </table>
    </div>
  </div>
@endsection
