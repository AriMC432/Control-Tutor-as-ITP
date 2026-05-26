@extends('layouts.app')

@section('title', 'Asignar Grupos')

@include('jefe._subnav')

@section('content')
  <div class="card p-3">
    <h4 class="mb-2">Asignar Grupos a Tutores</h4>
    <div class="text-muted mb-3">Asocia grupos de estudiantes con docentes tutores</div>
    @if($periodoActual)
      <span class="badge bg-info fs-5 p-2 shadow-sm">
        <i class="bi bi-calendar-check me-1"></i> Periodo activo: {{ $periodoActual->nombre }}
      </span>
    @endif
    <hr>

    {{-- Mensajes de feedback --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('jefe.asignar_grupo') }}" method="POST" class="row g-2">
      @csrf
      <div class="col-md-5">
        <label class="form-label">Docente</label>
        <select class="form-select" name="id_docente" required>
          <option value="">Selecciona un docente…</option>
          @foreach($docentes as $d)
            <option value="{{ $d->id_docente }}">{{ $d->nombre }} {{ $d->paterno }} {{ $d->materno }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-5">
        <label class="form-label">Grupo</label>
        <select class="form-select" name="id_grupo" required>
          <option value="">Selecciona un grupo…</option>
          @foreach($grupos as $g)
            <option value="{{ $g->id_grupo }}">
              {{ $g->nombre }} · Sem {{ $g->semestre }} ({{ $g->carrera->nombre ?? 'N/A' }})
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-success w-100" type="submit">Asignar</button>
      </div>
    </form>

    <hr class="my-4">

    <h6>Asignaciones existentes</h6>
    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light">
          <tr>
            <th>Grupo</th>
            <th>Docente Tutor</th>
            <th>Carrera</th>
            <th>Generación</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse($asignaciones as $a)
            <tr>
              <td class="fw-bold">{{ $a->nombre }} <span class="badge bg-secondary text-white">{{ $a->semestre }}°
                  Sem</span></td>
              <td class="text-primary">
                {{ $a->tutor->nombre }} {{ $a->tutor->paterno }}
              </td>
              <td>{{ $a->carrera->nombre ?? 'Sin Carrera' }}</td>
              <td>
                @if($a->generacion)
                  {{ $a->generacion->ano_inicio }}-{{ $a->generacion->ano_fin }}
                @else
                  —
                @endif
              </td>
              <td class="text-end">
                {{-- Usamos ruta GET para simplificar, idealmente sería un form DELETE --}}
                <a href="{{ route('jefe.liberar_grupo', $a->id_grupo) }}" class="btn btn-outline-danger btn-sm"
                  onclick="return confirm('¿Seguro que deseas quitar al tutor de este grupo?')">
                  Quitar
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-3">No hay grupos con tutor asignado aún.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection