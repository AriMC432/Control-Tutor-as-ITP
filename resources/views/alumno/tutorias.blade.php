@extends('layouts.app')

@section('title', 'Mis Tutorías')

{{-- Incluimos la barra de navegación --}}
@include('alumno._subnav')

@section('content')
    <div class="container-fluid">

        <div class="card p-4 border-0 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold text-primary mb-1">Mis Tutorías Registradas</h4>
                    @if($periodoActual)
                        <span class="badge bg-info fs-5 p-2 shadow-sm">
                            <i class="bi bi-calendar-check me-1"></i> Periodo activo: {{ $periodoActual->nombre }}
                        </span>
                    @endif
                    <p class="text-muted mb-0">Consulta el historial de sesiones grupales e individuales.</p>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                    {{-- CORRECCIÓN DE SEGURIDAD: Usamos ?? [] para evitar errores si es null --}}
                    Total: {{ count($tutorias ?? []) }}
                </span>
            </div>

            <hr class="opacity-10 my-4">

            {{-- Verificamos si existe la variable Y si tiene datos --}}
            @if(!isset($tutorias) || $tutorias->isEmpty())
                <div class="alert alert-info text-center py-4" role="alert">
                    <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                    No se han registrado tutorías para ti todavía.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Tipo</th>
                                <th>Tema / Motivo</th>
                                <th>Fecha</th>
                                <th>Tutor</th>
                                <th class="text-center">Asistencia</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tutorias as $t)
                                <tr>
                                    <td class="ps-4">
                                        @if($t['tipo'] == 'Grupal')
                                            {{-- CORRECCIÓN DE ESTILO: bg-primary en lugar de bg-indigo --}}
                                            <span
                                                class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10">Grupal</span>
                                        @else
                                            <span
                                                class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25">Individual</span>
                                        @endif
                                    </td>
                                    <td class="fw-medium text-dark">{{ $t['tema'] }}</td>
                                    <td class="text-secondary">
                                        {{-- Formato de fecha amigable --}}
                                        {{ \Carbon\Carbon::parse($t['fecha'])->locale('es')->isoFormat('D MMM YYYY') }}
                                    </td>
                                    <td class="small">{{ $t['tutor'] }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $t['clase_asistencia'] }} rounded-pill px-3">
                                            {{ $t['asistencia'] }}
                                        </span>
                                    </td>
                                    <td class="text-muted small text-truncate" style="max-width: 200px;"
                                        title="{{ $t['observaciones'] }}">
                                        {{ $t['observaciones'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection