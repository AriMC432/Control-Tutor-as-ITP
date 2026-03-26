@extends('layouts.app')

@section('title','Panel Docente - Inicio')

{{-- 1. BARRA DE NAVEGACIÓN (Menú y Logout) --}}
@include('docente._subnav')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background-color: #e8f0fe !important;">
            <div class="card-body py-4">
                <h5 class="text-secondary mb-1" style="font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    <i class="bi bi-calendar3 me-2"></i> Ciclo Escolar Actual
                </h5>
                <h2 class="fw-bold mb-0" style="color: #174c9b !important;">
                    {{ $periodoActivo ? $periodoActivo->nombre : 'Sin periodo activo' }}
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    
    {{-- Encabezado y Botón de Acción Rápida --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Panel del Docente</h3>
        <a href="{{ route('docente.tutorias') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Nueva Tutoría
        </a>
    </div>

    <div class="row g-4">
        
        {{-- COLUMNA IZQUIERDA: GRUPOS ASIGNADOS --}}
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-people-fill me-2 text-primary"></i>Mis grupos
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($grupos) && count($grupos))
                        <ul class="list-group list-group-flush">
                            @foreach($grupos as $g)
                                <li class="list-group-item border-0 border-bottom py-3 px-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold text-dark fs-5">{{ $g->nombre }}</div>
                                            <div class="small text-muted">
                                                {{-- Validamos si existe la relación carrera --}}
                                                Sem {{ $g->semestre }} · {{ $g->carrera ? $g->carrera->nombre : 'Ingeniería' }}
                                            </div>
                                        </div>
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-3">
                                            Asignado
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-5 text-center text-muted">
                            <i class="bi bi-folder-x fs-1 d-block mb-3 opacity-50"></i>
                            <h6 class="fw-bold">Sin grupos asignados</h6>
                            <small>Contacta a tu Jefe de Departamento.</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: HISTORIAL DE TUTORÍAS (Grupales e Individuales) --}}
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-journal-text me-2 text-success"></i>Historial Reciente
                    </h5>
                    <span class="badge bg-light text-secondary border">Últimos registros</span>
                </div>
                <div class="card-body p-0">
                    @if(isset($tutorias) && count($tutorias))
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light bg-light">
                                    <tr>
                                        <th class="ps-4 py-3">Fecha</th>
                                        <th class="py-3">Tipo</th>
                                        <th class="py-3">Tema / Motivo</th>
                                        <th class="py-3">Atención A:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tutorias as $t)
                                        <tr>
                                            <td class="ps-4 text-nowrap text-secondary">
                                                <i class="bi bi-calendar3 me-2 small"></i>
                                                {{ \Illuminate\Support\Carbon::parse($t->fecha)->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                @if($t->tipo == 'Grupal')
                                                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3">
                                                        Grupal
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning text-dark px-3">
                                                        Individual
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="fw-semibold text-dark" style="max-width: 250px;">
                                                <div class="text-truncate" title="{{ $t->tema }}">
                                                    {{ $t->tema }}
                                                </div>
                                            </td>
                                            <td class="small text-muted fw-medium">
                                                @if($t->tipo == 'Grupal')
                                                    <i class="bi bi-people me-1"></i>
                                                @else
                                                    <i class="bi bi-person me-1"></i>
                                                @endif
                                                {{ $t->info }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <div class="mb-3">
                                <i class="bi bi-calendar2-plus fs-1 text-success opacity-50"></i>
                            </div>
                            <h5 class="fw-bold text-dark">No hay tutorías registradas</h5>
                            <p class="mb-4 small">Comienza registrando tu primera sesión para ver el historial.</p>
                            <a href="{{ route('docente.tutorias') }}" class="btn btn-success px-4 rounded-pill">
                                <i class="bi bi-plus-lg me-2"></i>Registrar Tutoría
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection