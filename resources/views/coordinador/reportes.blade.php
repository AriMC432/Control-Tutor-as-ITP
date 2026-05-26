@extends('layouts.app')

<<<<<<< HEAD
@section('title', 'Reportes y métricas')
=======
@section('title', 'Reportes y metricas')
>>>>>>> 00d5eac3cdbe3cdd50cc5713bb46c71fbc2c9093

@includeWhen(true, 'coordinador._subnav')

@section('content')
<<<<<<< HEAD
  <div class="card p-3">
    @if($periodoActual)
      <span class="badge bg-info fs-5 p-2 shadow-sm">
        <i class="bi bi-calendar-check me-1"></i> Periodo activo: {{ $periodoActual->nombre }}
      </span>
    @endif
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
=======
<div class="container-fluid px-0">

    {{-- encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1" style="color: #1a3a6b;">Reportes y metricas</h4>
            <p class="text-muted small mb-0">Generacion de reportes institucionales del programa de tutoria</p>
        </div>
        @if($periodoActivo)
        <span class="badge px-3 py-2" style="background-color: #1a3a6b; color: white;">
            <i class="bi bi-calendar3 me-1"></i> {{ $periodoActivo->nombre }}
        </span>
        @endif
    </div>

    <div class="row g-4">

        {{-- tarjeta para anexo 20 --}}
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center rounded-circle me-3" style="width: 40px; height: 40px; background-color: rgba(255, 255, 255, 0.25);">
                            <i class="bi bi-file-pdf-fill text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Anexo 20</h5>
                            <small class="opacity-75">Reporte semestral del coordinador de tutoria</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-4">Genere el reporte Anexo 20 seleccionando el programa educativo y el periodo academico. El reporte se generara en formato PDF con los datos de tutores, tutorias y canalizaciones.</p>

                    <form action="{{ route('coordinador.anexo20.generate') }}" method="POST" target="_self" class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label for="id_carrera" class="form-label fw-semibold" style="color: #1a3a6b;">
                                <i class="bi bi-mortarboard me-1"></i> Programa educativo
                            </label>
                            <select name="id_carrera" id="id_carrera" class="form-select" required>
                                <option value="">-- Seleccionar programa --</option>
                                @foreach($carreras as $carrera)
                                <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="id_periodo" class="form-label fw-semibold" style="color: #1a3a6b;">
                                <i class="bi bi-calendar3 me-1"></i> Periodo academico
                            </label>
                            <select name="id_periodo" id="id_periodo" class="form-select" required>
                                <option value="">-- Seleccionar periodo --</option>
                                @foreach($periodos as $periodo)
                                <option value="{{ $periodo->id_periodo }}" {{ $periodoActivo && $periodoActivo->id_periodo == $periodo->id_periodo ? 'selected' : '' }}>
                                    {{ $periodo->nombre }} {{ $periodo->activo ? '(activo)' : '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_llenado" class="form-label fw-semibold" style="color: #1a3a6b;">Fecha de llenado</label>
                            <input type="date" class="form-control @error('fecha_llenado') is-invalid @enderror"
                                id="fecha_llenado" name="fecha_llenado"
                                value="{{ old('fecha_llenado', date('Y-m-d')) }}" required>
                            <small class="text-muted">Fecha en que se llena el reporte</small>
                            @error('fecha_llenado')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_entrega" class="form-label fw-semibold" style="color: #1a3a6b;">Fecha de entrega</label>
                            <input type="date" class="form-control @error('fecha_entrega') is-invalid @enderror"
                                id="fecha_entrega" name="fecha_entrega"
                                value="{{ old('fecha_entrega', date('Y-m-d')) }}" required>
                            <small class="text-muted">Debe ser mayor o igual a la fecha de llenado</small>
                            @error('fecha_entrega')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="firma_jefe" class="form-label fw-semibold" style="color: #1a3a6b;">Jefe de Departamento</label>
                            <select class="form-select" id="firma_jefe" name="firma_jefe" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach(\App\Models\FirmaReporte::where('tipo', 'jefe_departamento')->get() as $firma)
                                <option value="{{ $firma->nombre }}|{{ $firma->cargo }}" {{ old('firma_jefe') == $firma->nombre . '|' . $firma->cargo ? 'selected' : '' }}>
                                    {{ $firma->nombre }} - {{ $firma->cargo }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="firma_coordinador" class="form-label fw-semibold" style="color: #1a3a6b;">Coordinador de Tutoría</label>
                            <select class="form-select" id="firma_coordinador" name="firma_coordinador" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach(\App\Models\FirmaReporte::where('tipo', 'coordinador_tutoria')->get() as $firma)
                                <option value="{{ $firma->nombre }}|{{ $firma->cargo }}" {{ old('firma_coordinador') == $firma->nombre . '|' . $firma->cargo ? 'selected' : '' }}>
                                    {{ $firma->nombre }} - {{ $firma->cargo }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn px-4 py-2 fw-semibold" style="background-color: #1a3a6b; color: white;">
                                <i class="bi bi-file-pdf me-2"></i> Generar Anexo 20
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
>>>>>>> 00d5eac3cdbe3cdd50cc5713bb46c71fbc2c9093
@endsection