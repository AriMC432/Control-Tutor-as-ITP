@extends('layouts.app')

@section('title','Reportes y métricas')

@includeWhen(true, 'coordinador._subnav')

@section('content')
<div class="card p-3">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h5 class="mb-1">Reportes del periodo</h5>
      <div class="text-muted">Exporta métricas por carrera, grupo o tutor</div>
    </div>
    <form action="#" method="GET" class="d-flex gap-2">
      <select class="form-select form-select-sm" name="periodo">
        <option value="">Mes actual</option>
      </select>
      <select class="form-select form-select-sm" name="carrera">
        <option value="">Todas las carreras</option>
      </select>
      <button class="btn btn-success btn-sm">Aplicar</button>
    </form>
  </div>
  <hr>

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>Carrera</th>
          <th>Grupos</th>
          <th>Estudiantes</th>
          <th>Tutores</th>
          <th>Tutorías (mes)</th>
          <th>Asistencia prom.</th>
        </tr>
      </thead>
      <tbody>
        {{-- @foreach($metricas as $m) --}}
        <tr>
          <td>—</td>
          <td>—</td>
          <td>—</td>
          <td>—</td>
          <td>0</td>
          <td>0%</td>      
        </tr>
        {{-- @endforeach --}}
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-end gap-2">
    <a href="#" class="btn btn-outline">Exportar CSV</a>
    <a href="#" class="btn btn-outline">Exportar XLSX</a>
    <a href="#" class="btn btn-success">Exportar PDF</a>
  </div>
</div>
@endsection
