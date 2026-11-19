@extends('layouts.app')

@section('title', 'Reportes y metricas')

@section('content')

    @includeWhen(true, 'coordinador._subnav')

    <div class="container-fluid px-0">

        {{-- encabezado --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-semibold mb-1" style="color: #1a3a6b;">
                    Reportes y metricas
                </h4>

                <p class="text-muted small mb-0">
                    Generacion de reportes institucionales del programa de tutoria
                </p>
            </div>

        </div>


        <div class="row g-4">

            {{-- tarjeta para anexo 20 --}}
            <div class="col-md-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-primary text-white py-3">

                        <div class="d-flex align-items-center">

                            <div
                                class="d-flex align-items-center justify-content-center rounded-circle me-3"
                                style="width: 40px; height: 40px; background-color: rgba(255, 255, 255, 0.25);"
                            >
                                <i class="bi bi-file-pdf-fill text-white"></i>
                            </div>

                            <div>

                                <h5 class="mb-0 fw-bold">
                                    Anexo 20
                                </h5>

                                <small class="opacity-75">
                                    Reporte semestral del coordinador de tutoria
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        <p class="text-muted small mb-4">
                            Genere el reporte Anexo 20 seleccionando el programa educativo
                            y el periodo academico. El reporte se generara en formato PDF
                            con los datos de tutores, tutorias y canalizaciones.
                        </p>


                        <form
                            action="{{ route('coordinador.anexo20.generate') }}"
                            method="POST"
                            target="_self"
                            class="row g-3"
                        >

                            @csrf


                            <div class="col-md-6">

                                <label
                                    for="id_carrera"
                                    class="form-label fw-semibold"
                                    style="color: #1a3a6b;"
                                >
                                    <i class="bi bi-mortarboard me-1"></i>
                                    Programa educativo
                                </label>

                                <select
                                    name="id_carrera"
                                    id="id_carrera"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        -- Seleccionar programa --
                                    </option>

                                    @foreach($carreras as $carrera)

                                        <option value="{{ $carrera->id_carrera }}">
                                            {{ $carrera->nombre }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="id_periodo"
                                    class="form-label fw-semibold"
                                    style="color: #1a3a6b;"
                                >
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Periodo academico
                                </label>

                                <select
                                    name="id_periodo"
                                    id="id_periodo"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        -- Seleccionar periodo --
                                    </option>

                                    @foreach($periodos as $periodo)

                                        <option
                                            value="{{ $periodo->id_periodo }}"
                                            {{ $periodoActivo && $periodoActivo->id_periodo == $periodo->id_periodo ? 'selected' : '' }}
                                        >
                                            {{ $periodo->nombre }}
                                            {{ $periodo->activo ? '(activo)' : '' }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="fecha_llenado"
                                    class="form-label fw-semibold"
                                    style="color: #1a3a6b;"
                                >
                                    Fecha de llenado
                                </label>

                                <input
                                    type="date"
                                    class="form-control @error('fecha_llenado') is-invalid @enderror"
                                    id="fecha_llenado"
                                    name="fecha_llenado"
                                    value="{{ old('fecha_llenado', date('Y-m-d')) }}"
                                    required
                                >

                                <small class="text-muted">
                                    Fecha en que se llena el reporte
                                </small>

                                @error('fecha_llenado')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="fecha_entrega"
                                    class="form-label fw-semibold"
                                    style="color: #1a3a6b;"
                                >
                                    Fecha de entrega
                                </label>

                                <input
                                    type="date"
                                    class="form-control @error('fecha_entrega') is-invalid @enderror"
                                    id="fecha_entrega"
                                    name="fecha_entrega"
                                    value="{{ old('fecha_entrega', date('Y-m-d')) }}"
                                    required
                                >

                                <small class="text-muted">
                                    Debe ser mayor o igual a la fecha de llenado
                                </small>

                                @error('fecha_entrega')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="firma_jefe"
                                    class="form-label fw-semibold"
                                    style="color: #1a3a6b;"
                                >
                                    Jefe de Departamento
                                </label>

                                <select
                                    class="form-select"
                                    id="firma_jefe"
                                    name="firma_jefe"
                                    required
                                >

                                    <option value="">
                                        -- Seleccionar --
                                    </option>

                                    @foreach(\App\Models\FirmaReporte::where('tipo', 'jefe_departamento')->get() as $firma)

                                        <option
                                            value="{{ $firma->nombre }}|{{ $firma->cargo }}"
                                            {{ old('firma_jefe') == $firma->nombre . '|' . $firma->cargo ? 'selected' : '' }}
                                        >
                                            {{ $firma->nombre }} - {{ $firma->cargo }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="firma_coordinador"
                                    class="form-label fw-semibold"
                                    style="color: #1a3a6b;"
                                >
                                    Coordinador de Tutoría
                                </label>

                                <select
                                    class="form-select"
                                    id="firma_coordinador"
                                    name="firma_coordinador"
                                    required
                                >

                                    <option value="">
                                        -- Seleccionar --
                                    </option>

                                    @foreach(\App\Models\FirmaReporte::where('tipo', 'coordinador_tutoria')->get() as $firma)

                                        <option
                                            value="{{ $firma->nombre }}|{{ $firma->cargo }}"
                                            {{ old('firma_coordinador') == $firma->nombre . '|' . $firma->cargo ? 'selected' : '' }}
                                        >
                                            {{ $firma->nombre }} - {{ $firma->cargo }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="col-12 mt-4">

                                <button
                                    type="submit"
                                    class="btn px-4 py-2 fw-semibold"
                                    style="background-color: #1a3a6b; color: white;"
                                >
                                    <i class="bi bi-file-pdf me-2"></i>
                                    Generar Anexo 20
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection