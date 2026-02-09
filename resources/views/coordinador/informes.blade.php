@extends('layouts.app')

@section('title','Informes de tutores')

@includeWhen(true, 'coordinador._subnav')

@section('content')
<div class="row g-3">
  <div class="col-12 col-lg-5">
    <div class="card p-3 h-100">
      <h5 class="mb-2">Cargar informe</h5>
      <div class="text-muted">Recibe informes individuales (PDF/Excel) por tutor o grupo</div>
      <hr>
      <form action="#" method="POST" enctype="multipart/form-data" class="d-grid gap-3">
        @csrf
        <div>
          <label class="form-label">Tutor</label>
          <select class="form-select" name="id_docente" required>
            <option value="">Selecciona…</option>
            {{-- @foreach($tutores as $t) <option value="{{ $t->id_docente }}">{{ $t->nombre }} {{ $t->paterno }}</option> @endforeach --}}
          </select>
        </div>
        <div>
          <label class="form-label">Mes / Periodo</label>
          <input type="month" class="form-control" name="periodo" required>
        </div>
        <div>
          <label class="form-label">Archivo</label>
          <input type="file" class="form-control" name="informe" accept=".pdf,.xlsx,.xls" required>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-success">Subir</button>
          <button class="btn btn-outline" type="reset">Limpiar</button>
        </div>
      </form>
    </div>
  </div>

  <div class="col-12 col-lg-7">
    <div class="card p-3 h-100">
      <h5 class="mb-2">Informes recibidos</h5>
      <div class="text-muted">Valida y marca como aceptado/rechazado</div>
      <hr>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Tutor</th>
              <th>Periodo</th>
              <th>Archivo</th>
              <th>Estatus</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            {{-- @foreach($informes as $inf) --}}
            <tr>
              <td>—</td>
              <td>—</td>
              <td>—</td>
              <td><a href="#" class="btn btn-outline btn-sm">Descargar</a></td>
              <td><span class="badge bg-warning text-dark">En revisión</span></td>
              <td>
                <div class="btn-group btn-group-sm">
                  <a href="#" class="btn btn-success">Aceptar</a>
                  <a href="#" class="btn btn-outline">Rechazar</a>
                </div>
              </td>
            </tr>
            {{-- @endforeach --}}
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="card p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-1">Consolidado del área</h5>
          <div class="text-muted">Genera y descarga el informe global del periodo</div>
        </div>
        <div class="btn-group">
          <a href="#" class="btn btn-outline">Generar</a>
          <a href="#" class="btn btn-success">Descargar</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
