```blade
@extends('layouts.app')

@section('title', 'Asesorías disponibles | Control de Tutorías ITP')

@section('subnav')
    @include('alumno._subnav')
@endsection

@section('content')

<style>
    .pagina-asesorias {
        max-width: 1500px;
        margin: auto;
        padding: 28px;
        color: #26374b;
    }

    .encabezado-asesorias {
        background: linear-gradient(120deg, #163b68, #19718a);
        color: white;
        padding: 30px;
        border-radius: 16px;
        margin-bottom: 24px;
    }

    .encabezado-asesorias h1 {
        font-weight: 750;
        font-size: clamp(24px, 3vw, 34px);
        margin-bottom: 10px;
    }

    .filtros-asesorias {
        background: white;
        border: 1px solid #dfe7f1;
        border-radius: 15px;
        padding: 22px;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(25, 48, 75, .04);
    }

    .filtros-asesorias h2 {
        font-size: 20px;
        font-weight: 700;
        color: #164783;
    }

    .asesor-card {
        background: white;
        border: 1px solid #dfe7f1;
        border-radius: 15px;
        padding: 22px;
        height: 100%;
        box-shadow: 0 4px 15px rgba(25, 48, 75, .04);
        transition: transform .2s, box-shadow .2s;
    }

    .asesor-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 9px 24px rgba(25, 48, 75, .09);
    }

    .avatar-asesor {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #e3efff;
        color: #1d5da8;
        font-size: 20px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .nombre-asesor {
        font-size: 18px;
        font-weight: 700;
        color: #193d68;
        margin-bottom: 4px;
    }

    .area-asesor {
        color: #687b92;
        font-size: 14px;
    }

    .estado-asesor {
        display: inline-block;
        padding: 5px 9px;
        background: #d9f5e5;
        color: #187447;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .horario-asesor {
        background: #f5f8fc;
        border: 1px solid #e4ebf4;
        border-radius: 9px;
        padding: 10px 12px;
        margin-top: 8px;
        font-size: 13px;
    }

    .horario-asesor strong {
        color: #204c7c;
    }

    .sin-horario {
        color: #687b92;
        font-size: 13px;
        margin-top: 12px;
    }

    .sin-resultados {
        background: white;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
        color: #687b92;
        border: 1px solid #dfe7f1;
    }

    @media (max-width: 700px) {
        .pagina-asesorias {
            padding: 14px;
        }

        .encabezado-asesorias,
        .filtros-asesorias {
            padding: 18px;
        }
    }
</style>

<main class="pagina-asesorias">

    {{-- ENCABEZADO --}}
    <section class="encabezado-asesorias">

        <h1>
            <i class="bi bi-journal-check"></i>
            Asesorías disponibles
        </h1>

        <p class="mb-0">
            Consulta los docentes asesores, sus áreas de atención,
            modalidades y horarios disponibles.
        </p>

    </section>


    {{-- FILTROS --}}
    <section class="filtros-asesorias">

        <h2 class="mb-3">
            <i class="bi bi-search"></i>
            Buscar un asesor
        </h2>

        <div class="row g-3">

            {{-- BUSCAR POR NOMBRE --}}
            <div class="col-12 col-md-4">

                <label for="buscarAsesor" class="form-label">
                    Nombre del docente
                </label>

                <input
                    type="text"
                    id="buscarAsesor"
                    class="form-control"
                    placeholder="Buscar por nombre..."
                >

            </div>


            {{-- FILTRO POR ÁREA --}}
            <div class="col-12 col-md-4">

                <label for="areaFiltro" class="form-label">
                    Área de asesoría
                </label>

                <select id="areaFiltro" class="form-select">

                    <option value="">
                        Todas las áreas
                    </option>

                    @foreach($asesores->pluck('area')->filter()->unique()->sort() as $area)

                        <option value="{{ $area }}">
                            {{ $area }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- FILTRO POR MODALIDAD --}}
            <div class="col-12 col-md-4">

                <label for="modalidadFiltro" class="form-label">
                    Modalidad
                </label>

                <select id="modalidadFiltro" class="form-select">

                    <option value="">
                        Todas las modalidades
                    </option>

                    <option value="Presencial">
                        Presencial
                    </option>

                    <option value="En línea">
                        En línea
                    </option>

                    <option value="Ambas">
                        Ambas
                    </option>

                </select>

            </div>

        </div>

    </section>


    {{-- ENCABEZADO DEL CATÁLOGO --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">

        <h2 class="h4 fw-bold mb-0">
            Docentes asesores
        </h2>

        <span class="badge text-bg-secondary" id="contadorAsesores">

            {{ $asesores->count() }}

            {{ $asesores->count() === 1 ? 'asesor' : 'asesores' }}

        </span>

    </div>


    {{-- CATÁLOGO DINÁMICO --}}
    <div class="row g-4" id="catalogoAsesores">

        @forelse($asesores as $asesor)

            <div
                class="col-12 col-md-6 col-xl-4 asesor-item"
                data-nombre="{{ strtolower($asesor->nombre) }}"
                data-area="{{ $asesor->area }}"
                data-modalidad="{{ $asesor->modalidad }}"
            >

                <article class="asesor-card">

                    {{-- DATOS DEL ASESOR --}}
                    <div class="d-flex align-items-center gap-3 mb-3">

                        <div class="avatar-asesor">

                            {{ collect(explode(' ', trim($asesor->nombre)))
                                ->filter()
                                ->take(2)
                                ->map(fn($palabra) => strtoupper(substr($palabra, 0, 1)))
                                ->implode('') }}

                        </div>

                        <div>

                            <div class="nombre-asesor">

                                {{ $asesor->nombre }}

                            </div>

                            <div class="area-asesor">

                                {{ $asesor->area }}

                            </div>

                        </div>

                    </div>


                    {{-- ESTADO --}}
                    <span class="estado-asesor">

                        <i class="bi bi-check-circle-fill"></i>

                        Disponible para asesorías

                    </span>


                    {{-- HORARIOS --}}
                    <h3 class="h6 fw-bold mt-4">

                        <i class="bi bi-clock"></i>

                        Horario semanal

                    </h3>


                    @php
                        $horarios = $asesor->horarios ?? [];
                    @endphp


                    @if(count($horarios) > 0)

                        @foreach($horarios as $horario)

                            <div class="horario-asesor">

                                <strong>

                                    {{ $horario['dia'] ?? 'Día no especificado' }}:

                                </strong>

                                {{ $horario['inicio'] ?? '--:--' }}

                                –

                                {{ $horario['fin'] ?? '--:--' }}

                            </div>

                        @endforeach

                    @else

                        <p class="sin-horario">

                            No hay horarios registrados.

                        </p>

                    @endif


                    {{-- MODALIDAD --}}
                    <p class="small text-muted mt-3 mb-0">

                        <i class="bi bi-laptop"></i>

                        <strong>Modalidad:</strong>

                        @if($asesor->modalidad === 'Ambas')

                            Presencial y en línea

                        @else

                            {{ $asesor->modalidad }}

                        @endif

                    </p>


                    {{-- AULA --}}
                    @if(!empty($asesor->lugar_detalle))

                        <p class="small text-muted mt-2 mb-0">

                            <i class="bi bi-geo-alt"></i>

                            <strong>Aula:</strong>

                            {{ $asesor->lugar_detalle }}

                        </p>

                    @endif

                </article>

            </div>

        @empty

            {{-- NO HAY ASESORES REGISTRADOS --}}
            <div class="col-12">

                <div class="sin-resultados">

                    <i class="bi bi-person-x fs-1"></i>

                    <h3 class="h5 mt-3">

                        No hay asesores disponibles

                    </h3>

                    <p class="mb-0">

                        Actualmente no hay docentes registrados como disponibles.

                    </p>

                </div>

            </div>

        @endforelse

    </div>


    {{-- SIN RESULTADOS DE FILTROS --}}
    <div
        class="sin-resultados mt-3 d-none"
        id="sinResultados"
    >

        <i class="bi bi-search fs-1"></i>

        <h3 class="h5 mt-3">

            No se encontraron asesores

        </h3>

        <p class="mb-0">

            Intenta cambiar los filtros de búsqueda.

        </p>

    </div>

</main>


{{-- FILTROS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const buscar = document.getElementById('buscarAsesor');

    const areaFiltro = document.getElementById('areaFiltro');

    const modalidadFiltro = document.getElementById('modalidadFiltro');

    const tarjetas = document.querySelectorAll('.asesor-item');

    const contador = document.getElementById('contadorAsesores');

    const sinResultados = document.getElementById('sinResultados');


    function filtrarAsesores() {

        const texto = buscar.value.toLowerCase().trim();

        const area = areaFiltro.value;

        const modalidad = modalidadFiltro.value;

        let visibles = 0;


        tarjetas.forEach(function (tarjeta) {

            const nombre = tarjeta.dataset.nombre;

            const areaAsesor = tarjeta.dataset.area;

            const modalidadAsesor = tarjeta.dataset.modalidad;


            const coincideNombre = nombre.includes(texto);


            const coincideArea =
                !area || areaAsesor === area;


            const coincideModalidad =
                !modalidad || modalidadAsesor === modalidad;


            const mostrar =
                coincideNombre &&
                coincideArea &&
                coincideModalidad;


            tarjeta.classList.toggle('d-none', !mostrar);


            if (mostrar) {

                visibles++;

            }

        });


        contador.textContent =
            visibles + (visibles === 1 ? ' asesor' : ' asesores');


        sinResultados.classList.toggle(
            'd-none',
            visibles !== 0
        );

    }


    buscar.addEventListener('input', filtrarAsesores);

    areaFiltro.addEventListener('change', filtrarAsesores);

    modalidadFiltro.addEventListener('change', filtrarAsesores);

});
</script>

@endsection
```