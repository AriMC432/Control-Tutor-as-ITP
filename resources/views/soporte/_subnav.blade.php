@section('subnav')

<style>
/* =========================================================
   SUBMENÚ DE SOPORTE
   ========================================================= */

.subnav .nav {
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;

    display: grid !important;

    /* 7 botones + ciclo escolar */
    grid-template-columns:
        repeat(7, minmax(0, 1fr))
        220px;

    grid-template-rows: 44px;

    gap: 6px;

    align-items: stretch;

    flex-wrap: unset !important;
}

/* =========================================================
   ELEMENTOS
   ========================================================= */

.subnav .nav-item {
    margin: 0 !important;
    padding: 0 !important;

    min-width: 0 !important;

    flex: none !important;
}


.subnav .nav-link {
    width: 100% !important;
    min-width: 0 !important;
    height: 40px !important;

    padding: 0 3px !important;

    display: flex !important;
    align-items: center;
    justify-content: center;

    text-align: center;

    white-space: nowrap;

    border-radius: 11px;

    border: 1px solid rgba(91,164,244,.55);

    background: rgba(27,87,165,.28);

    color: white;

    font-size: .75rem;
    font-weight: 700;

    text-decoration: none;

    transition:
        background .20s ease,
        border-color .20s ease,
        box-shadow .20s ease,
        transform .20s ease;
}


/* =========================================================
   PRIMERA FILA
   ========================================================= */
/* =====================================
   DISTRIBUCIÓN EN UNA SOLA FILA
   ===================================== */

.subnav .nav > .soporte-inicio,
.subnav .nav > .soporte-alumnos,
.subnav .nav > .soporte-grupos,
.subnav .nav > .soporte-asignar,
.subnav .nav > .soporte-periodos,
.subnav .nav > .soporte-encabezados,
.subnav .nav > .soporte-firmas {
    grid-column: auto !important;
    grid-row: 1 !important;
    min-width: 0 !important;
}

/* =========================================================
   CICLO ESCOLAR ACTUAL
   ========================================================= */

.soporte-periodo-actual {
grid-column: 8 !important;
grid-row: 1 !important;

    min-width: 0;

    border-left: 1px solid rgba(255,255,255,.30);

    padding-left: 16px;
    padding-right: 10px;

    display: flex;
    flex-direction: column;

    align-items: flex-start;
    justify-content: center;

    overflow: hidden;
}


.soporte-periodo-label {
    display: block;

    color: rgba(255,255,255,.78);

    font-size: .76rem;
    font-weight: 600;

    text-transform: uppercase;

    letter-spacing: 1px;

    margin-bottom: 5px;

    white-space: nowrap;
}


.soporte-periodo-nombre {
    display: block;

    color: #ffffff;

    font-size: 1.15rem;
    font-weight: 800;

    line-height: 1.1;

    white-space: nowrap;
}


/* =========================================================
   ACTIVO / HOVER
   ========================================================= */

.subnav .nav-link:hover,
.subnav .nav-link.active {
    color: white !important;

    background:
        linear-gradient(
            180deg,
            #3194ff 0%,
            #176bd7 100%
        );

    border-color: #7bc7ff;

    box-shadow:
        0 0 6px rgba(55,160,255,1),
        0 0 14px rgba(55,160,255,.90),
        0 0 26px rgba(55,160,255,.55),
        inset 0 1px 0 rgba(255,255,255,.45);
}


.subnav .nav-link:hover {
    transform: translateY(-1px);
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media (max-width: 1200px) {

    .subnav .nav {
        grid-template-columns:
            repeat(8, minmax(0, 1fr))
            240px;
    }

    .subnav .nav-link {
        font-size: .88rem;
        padding: 0 8px !important;
    }

    .soporte-periodo-actual {
        padding-left: 12px;
    }

    .soporte-periodo-nombre {
        font-size: 1rem;
    }
}


@media (max-width: 900px) {

    .subnav .nav {
        display: grid !important;

        grid-template-rows: auto;

        gap: 8px;
    }

    .soporte-inicio,
    .soporte-alumnos,
    .soporte-grupos,
    .soporte-asignar,
    .soporte-periodos,
    .soporte-encabezados,
    .soporte-firmas {
        grid-column: auto;
        grid-row: auto;
    }

    .soporte-periodo-actual {
        grid-column: 1 / -1;
        grid-row: auto;

        border-left: none;

        border-top: 1px solid rgba(255,255,255,.30);

        padding: 12px 0 4px;

        align-items: center;
    }
}


@media (max-width: 600px) {

    .subnav .nav {
        grid-template-columns: 1fr;
    }

.subnav .nav-link {
    min-height: 38px;
    padding: 3px 5px;
    font-size: 0.80rem;
    white-space: nowrap;
}

    .soporte-periodo-actual {
        grid-column: 1;
    }
}


</style>


{{-- =========================================================
     INICIO
     ========================================================= --}}

{{-- =========================================================
     INICIO
     ========================================================= --}}

<li class="nav-item soporte-inicio">
    <a
        href="{{ route('soporte.index') }}"
        class="nav-link {{ request()->routeIs('soporte.index') ? 'active' : '' }}"
    >
        <i class="bi bi-house-door-fill"></i>
        <span>Inicio</span>
    </a>
</li>


{{-- =========================================================
     ALTA DE ALUMNOS
     ========================================================= --}}

<li class="nav-item soporte-alumnos">
    <a
        href="{{ route('soporte.alumnos') }}"
        class="nav-link {{ request()->routeIs('soporte.alumnos') ? 'active' : '' }}"
    >
        <i class="bi bi-person-plus-fill"></i>
        <span>Alta de Alumnos</span>
    </a>
</li>


{{-- =========================================================
     ALTA DE GRUPOS
     ========================================================= --}}

<li class="nav-item soporte-grupos">
    <a
        href="{{ route('soporte.grupos.crear') }}"
        class="nav-link {{ request()->routeIs('soporte.grupos.crear') ? 'active' : '' }}"
    >
        <i class="bi bi-people-fill"></i>
        <span>Alta de Grupos</span>
    </a>
</li>


{{-- =========================================================
     ASIGNAR GRUPOS
     ========================================================= --}}

<li class="nav-item soporte-asignar">
    <a
        href="{{ route('soporte.grupos.asignar') }}"
        class="nav-link {{ request()->routeIs('soporte.grupos.asignar') ? 'active' : '' }}"
    >
        <i class="bi bi-diagram-3-fill"></i>
        <span>Asignar Grupos</span>
    </a>
</li>


{{-- =========================================================
     PERIODOS
     ========================================================= --}}

<li class="nav-item soporte-periodos">
    <a
        href="{{ route('soporte.periodos') }}"
        class="nav-link {{ request()->routeIs('soporte.periodos') ? 'active' : '' }}"
    >
        <i class="bi bi-calendar3"></i>
        <span>Periodos</span>
    </a>
</li>


{{-- =========================================================
     ENCABEZADOS
     ========================================================= --}}

<li class="nav-item soporte-encabezados">
    <a
        href="{{ route('encabezados.index') }}"
        class="nav-link {{ request()->routeIs('encabezados.*') ? 'active' : '' }}"
    >
        <i class="bi bi-file-earmark-text-fill"></i>
        <span>Encabezados</span>
    </a>
</li>


{{-- =========================================================
     FIRMAS REPORTES
     ========================================================= --}}

<li class="nav-item soporte-firmas">
    <a
        href="{{ route('firmas.index') }}"
        class="nav-link {{ request()->routeIs('firmas.*') ? 'active' : '' }}"
    >
        <i class="bi bi-pen-fill"></i>
        <span>Firmas reportes</span>
    </a>
</li>

{{-- =========================================================
     CICLO ESCOLAR ACTUAL
     ========================================================= --}}
@php
    $periodoSoporte = $periodoActivo ?? $periodoActual ?? null;
@endphp

<li class="nav-item soporte-periodo-actual">

    <span class="soporte-periodo-label">
        Ciclo escolar actual
    </span>

    <span class="soporte-periodo-nombre">
        {{ $periodoSoporte ? $periodoSoporte->nombre : 'Sin periodo activo' }}
    </span>

</li>
@endsection