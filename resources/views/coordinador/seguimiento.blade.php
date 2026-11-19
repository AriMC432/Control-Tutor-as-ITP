
@extends('layouts.app')

@section('title', 'Seguimiento a tutores')

@section('content')

    @includeWhen(true, 'coordinador._subnav')

    <div class="card p-3">

        {{-- ENCABEZADO Y FILTROS --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h5 class="mb-1">Seguimiento a tutores</h5>

                <div class="text-muted">
                    Progreso por tutor y grupo en el periodo seleccionado
                </div>
            </div>

            {{-- FILTROS --}}
            <form
                action="{{ route('coord.seguimiento') }}"
                method="GET"
                class="d-flex align-items-center gap-2 flex-nowrap"
            >

                {{-- FILTRO POR MES --}}
                <select
                    name="mes"
                    class="form-select form-select-sm"
                    style="width: 145px; min-width: 145px;"
                >
                    <option value="">Todos los meses</option>

                    @foreach($meses as $mes)
                        <option
                            value="{{ $mes['valor'] }}"
                            {{ request('mes') == $mes['valor'] ? 'selected' : '' }}
                        >
                            {{ $mes['nombre'] }}
                        </option>
                    @endforeach

                </select>

                {{-- FILTRO POR CARRERA --}}
                <select
                    name="carrera"
                    class="form-select form-select-sm"
                    style="width: 230px; min-width: 230px;"
                >
                    <option value="">Todas las carreras</option>

                    @foreach($carreras as $c)
                        <option
                            value="{{ $c->id_carrera }}"
                            {{ request('carrera') == $c->id_carrera ? 'selected' : '' }}
                        >
                            {{ $c->nombre }}
                        </option>
                    @endforeach

                </select>

                {{-- BOTÓN FILTRAR --}}
                <button
                    type="submit"
                    class="btn btn-success btn-sm"
                >
                    Filtrar
                </button>

                {{-- BOTÓN LIMPIAR --}}
                <a
                    href="{{ route('coord.seguimiento') }}"
                    class="btn btn-outline-secondary btn-sm"
                >
                    Limpiar
                </a>

            </form>

        </div>

        <hr>

        {{-- TABLA DE SEGUIMIENTO --}}
        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Tutor</th>
                        <th>Grupo</th>
                        <th>Tutorías</th>
                        <th>Asistencia prom.</th>
                        <th>Última sesión</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($seguimiento as $s)

                        <tr>

                            {{-- TUTOR --}}
                            <td>
                                {{ $s->tutor }}
                            </td>

                            {{-- GRUPO --}}
                            <td>
                                {{ $s->grupo }}
                            </td>

                            {{-- TUTORÍAS --}}
                            <td>
                                {{ $s->tutorias_mes }}
                            </td>

                            {{-- ASISTENCIA --}}
                            <td>
                                {{ $s->asistencia_prom }}%
                            </td>

                            {{-- ÚLTIMA SESIÓN --}}
                            <td>
                                {{ $s->ultima_sesion }}
                            </td>

                            {{-- ESTADO --}}
                            <td>
                                @if($s->estado === 'Activo')

                                    <span class="badge bg-success">
                                        Activo
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Pendiente
                                    </span>

                                @endif
                            </td>

                            {{-- ACCIONES --}}
                            <td>
                                <div class="btn-group btn-group-sm">

                                    <a
                                        href="#"
                                        class="btn btn-outline-secondary"
                                    >
                                        Detalle
                                    </a>

                                    <a
                                        href="#"
                                        class="btn btn-success"
                                    >
                                        Solicitar informe
                                    </a>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="7"
                                class="text-center text-muted py-4"
                            >
                                No hay grupos registrados para los filtros seleccionados.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection
