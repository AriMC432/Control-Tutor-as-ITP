@extends('layouts.app')

@section('title', 'Crear Nuevo Grupo')

@section('content')

        {{-- Asegúrate de que el nombre del archivo coincida con el que tienes (_nav o _subnav) --}}
        @include('jefe._subnav') 

        <div class="container pb-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">

                    {{-- Encabezado --}}
                    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                        <h2 class="fw-bold text-dark mb-0">Gestión de Grupos</h2>
                        <span class="text-muted">Registro de Nuevos Grupos</span>

                    </div>
    @if($periodoActual)
        <span class="badge bg-info fs-5 p-2 shadow-sm">
            <i class="bi bi-calendar-check me-1"></i> Periodo activo: {{ $periodoActual->nombre }}
        </span>
    @endif
                    {{-- Mensajes de Feedback --}}
                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center shadow-sm border-0" role="alert">
                            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger d-flex align-items-center shadow-sm border-0" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif

                    {{-- TARJETA DE CREACIÓN --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="mb-0 fw-semibold text-primary">
                                <i class="bi bi-plus-square-fill me-2"></i> Crear Nuevo Grupo
                            </h5>
                        </div>

                        <div class="card-body p-4">

                            {{-- Aviso de Periodo --}}
                            <div class="alert alert-light border mb-4 d-flex align-items-center">
                                <i class="bi bi-calendar-event text-primary me-2"></i>
                                <div>
                                    El grupo se creará automáticamente en el periodo: 
                                    <strong>
                                        @if(isset($periodoActual))
                                            <span class="text-success">{{ $periodoActual->nombre }}</span>
                                        @else
                                            <span class="text-danger">No configurado</span>
                                        @endif
                                    </strong>
                                </div>
                            </div>

                            <form action="{{ route('jefe.guardar_grupo') }}" method="POST">
                                @csrf

                                <div class="row g-3">
                                    {{-- Nombre del Grupo --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Nombre del Grupo <span class="text-danger">*</span></label>
                                        <input type="text" name="nombre" class="form-control" placeholder="Ej. ISC-1A" required>
                                        <div class="form-text small">Identificador único (Ej: ISC-1A, MEC-3B).</div>
                                    </div>

                                    {{-- Semestre --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Semestre <span class="text-danger">*</span></label>
                                        <input type="number" name="semestre" class="form-control" min="1" max="14" placeholder="Ej. 1" required>
                                    </div>

                                    {{-- Separador visual --}}
                                    <div class="col-12">
                                        <hr class="text-muted opacity-25 my-2">
                                    </div>

                                    {{-- Carrera --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Carrera <span class="text-danger">*</span></label>
                                        <select name="id_carrera" class="form-select" required>
                                            <option value="" selected disabled>-- Seleccione Carrera --</option>
                                            @foreach($carreras as $carrera)
                                                <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Generación --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Generación <span class="text-danger">*</span></label>
                                        <select name="id_generacion" class="form-select" required>
                                            <option value="" selected disabled>-- Seleccione Generación --</option>
                                            @foreach($generaciones as $gen)
                                                <option value="{{ $gen->id_generacion }}">
                                                    {{ $gen->ano_inicio }} - {{ $gen->ano_fin }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Botones de Acción --}}
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('jefe.grupos.asignar') }}" class="btn btn-outline-secondary">
                                        Ir a Asignar Tutores
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                        <i class="bi bi-save me-2"></i> Guardar Grupo
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
@endsection