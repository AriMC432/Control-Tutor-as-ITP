@extends('layouts.app')

@section('title', 'Coordinador Institucional')

@section('content')

<style>

/* ============================================================
   CONTENEDOR GENERAL
   ============================================================ */

.coordinst-dashboard {
    width: 100%;
    max-width: 1520px;
    margin: 0 auto;
}


/* ============================================================
   PANEL AZUL PRINCIPAL
   ============================================================ */

.coordinst-hero {
    width: 100%;

    min-height: 250px;

    padding: 28px 30px 14px;

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            #2057a4 0%,
            #16468d 48%,
            #0b326f 100%
        );

    position: relative;

    overflow: hidden;

    box-shadow:
        0 12px 28px rgba(20, 62, 120, .22);

    color: #ffffff;
}


/* ============================================================
   DECORACIÓN
   ============================================================ */

.coordinst-hero::before {

    content: "";

    position: absolute;

    width: 500px;
    height: 300px;

    top: -180px;
    left: 25%;

    border-radius: 50%;

    background:
        rgba(63, 139, 255, .16);

    pointer-events: none;
}


.coordinst-hero::after {

    content: "";

    position: absolute;

    width: 450px;
    height: 250px;

    right: -180px;
    top: -80px;

    border-radius: 50%;

    background:
        rgba(44, 117, 235, .12);

    pointer-events: none;
}


/* ============================================================
   CABECERA
   ============================================================ */

.coordinst-hero-top {

    position: relative;

    z-index: 2;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 35px;

    min-height: 125px;
}


/* ============================================================
   INFORMACIÓN PRINCIPAL
   ============================================================ */

.coordinst-panel-info {

    display: flex;

    align-items: center;

    gap: 22px;

    min-width: 0;
}


/* ============================================================
   ICONO PRINCIPAL
   ============================================================ */

.coordinst-panel-icon {

    width: 82px;
    height: 82px;

    min-width: 82px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 2.35rem;

    color: #ffffff;

    border:
        2px solid rgba(126, 196, 255, .65);

    background:
        rgba(255,255,255,.08);

    box-shadow:
        0 0 8px rgba(71,164,255,.75),
        0 0 20px rgba(71,164,255,.35),
        inset 0 0 15px rgba(255,255,255,.08);
}

.coordinst-panel-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    display: block;
}
/* ============================================================
   TÍTULO
   ============================================================ */

.coordinst-panel-title {

    margin: 0;

    color: #ffffff;

    font-size: 2rem;

    font-weight: 800;

    line-height: 1.1;
}


.coordinst-panel-subtitle {

    margin: 8px 0 0;

    color:
        rgba(255,255,255,.90);

    font-size: 1rem;

    font-weight: 500;
}


/* ============================================================
   CICLO ESCOLAR
   ============================================================ */

.coordinst-periodo {

    min-width: 350px;

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 18px;

    padding-left: 28px;

    border-left:
        1px solid rgba(255,255,255,.28);
}


/* ============================================================
   ICONO DEL CICLO
   ============================================================ */

.coordinst-periodo-icon {

    width: 58px;
    height: 58px;

    min-width: 58px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 14px;

    color: #ffffff;

    font-size: 1.7rem;

    border:
        1px solid rgba(255,255,255,.35);

    background:
        rgba(255,255,255,.10);

    box-shadow:
        0 0 12px rgba(90,177,255,.25);
}


.coordinst-periodo-text {

    display: flex;

    flex-direction: column;

    align-items: flex-start;
}


.coordinst-periodo-label {

    color:
        rgba(255,255,255,.80);

    font-size: .78rem;

    font-weight: 500;

    text-transform: uppercase;

    letter-spacing: 1px;

    margin-bottom: 5px;
}


.coordinst-periodo-name {

    color: #ffffff;

    font-size: 1.45rem;

    font-weight: 800;

    line-height: 1.1;

    white-space: nowrap;
}


/* ============================================================
   MENÚ
   ============================================================ */

.coordinst-panel-nav {

    position: relative;

    z-index: 3;

    width: 100%;

    display: flex;

    align-items: center;

    justify-content: flex-start;

    gap: 9px;

    margin-top: 10px;

    padding: 0 2px;

    overflow-x: auto;
}


/* ============================================================
   BOTONES DEL MENÚ
   ============================================================ */

.coordinst-nav-link {

    min-width: 125px;

    height: 50px;

    padding: 0 18px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    border-radius: 11px;

    border:
        1px solid rgba(99,173,255,.55);

    background:
        rgba(25,84,160,.34);

    color: #ffffff;

    text-decoration: none;

    font-size: .93rem;

    font-weight: 700;

    white-space: nowrap;

    transition:
        all .22s ease;
}


/* ============================================================
   ICONOS
   ============================================================ */

.coordinst-nav-link i {

    font-size: 1rem;
}


/* ============================================================
   HOVER
   ============================================================ */

.coordinst-nav-link:hover {

    color: #ffffff;

    background:
        linear-gradient(
            180deg,
            #3195ff 0%,
            #176bd7 100%
        );

    border-color:
        #82ccff;

    box-shadow:
        0 0 6px rgba(59,165,255,1),
        0 0 14px rgba(59,165,255,.90),
        0 0 27px rgba(59,165,255,.55),
        inset 0 1px 0 rgba(255,255,255,.48);

    transform:
        translateY(-1px);
}


/* ============================================================
   BOTÓN ACTIVO
   ============================================================ */

.coordinst-nav-link.active {

    color: #ffffff;

    background:
        linear-gradient(
            180deg,
            #3195ff 0%,
            #176bd7 100%
        );

    border-color:
        #82ccff;

    box-shadow:
        0 0 7px rgba(59,165,255,1),
        0 0 17px rgba(59,165,255,.90),
        0 0 30px rgba(59,165,255,.55),
        inset 0 1px 0 rgba(255,255,255,.50);
}


/* ============================================================
   BIENVENIDA
   ============================================================ */

.coordinst-welcome {

    margin-top: 26px;

    padding: 24px 28px;

    background:
        linear-gradient(
            135deg,
            #f5f9ff,
            #edf4fd
        );

    border:
        1px solid #d8e5f5;

    border-radius: 16px;

    box-shadow:
        0 5px 16px rgba(30,70,120,.07);
}


.coordinst-welcome-title {

    margin: 0 0 7px;

    color: #1763c4;

    font-size: 1.45rem;

    font-weight: 800;
}


.coordinst-welcome-text {

    margin: 0;

    color: #61728b;

    font-size: 1rem;
}


/* ============================================================
   TARJETAS DE MÉTRICAS
   ============================================================ */

.coordinst-metrics {

    margin-top: 22px;
}


.coordinst-metric-card {

    height: 100%;

    min-height: 145px;

    padding: 20px;

    background: #ffffff;

    border:
        1px solid #dce6f2;

    border-radius: 16px;

    box-shadow:
        0 5px 16px rgba(30,70,120,.07);

    transition:
        all .20s ease;
}


.coordinst-metric-card:hover {

    transform:
        translateY(-2px);

    box-shadow:
        0 8px 20px rgba(30,70,120,.12);
}


.coordinst-metric-icon {

    width: 46px;
    height: 46px;

    border-radius: 12px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin-bottom: 14px;

    color: #176bd3;

    background:
        #eaf3ff;

    font-size: 1.25rem;
}


.coordinst-metric-value {

    margin: 0;

    color: #174c9b;

    font-size: 2.25rem;

    font-weight: 800;

    line-height: 1;
}


.coordinst-metric-label {

    margin-top: 7px;

    color: #667085;

    font-size: .88rem;

    font-weight: 600;
}


/* ============================================================
   TARJETA DE ACTIVIDAD
   ============================================================ */

.coordinst-activity {

    margin-top: 26px;

    background: #ffffff;

    border:
        1px solid #dce6f2;

    border-radius: 16px;

    box-shadow:
        0 5px 18px rgba(30,70,120,.08);

    overflow: hidden;
}


.coordinst-activity-header {

    padding: 20px 24px;

    border-bottom:
        1px solid #e1e8f0;
}


.coordinst-activity-title {

    margin: 0;

    color: #234f87;

    font-size: 1.2rem;

    font-weight: 800;
}


.coordinst-activity-subtitle {

    margin: 5px 0 0;

    color: #667085;

    font-size: .86rem;
}


.coordinst-activity table {

    margin-bottom: 0;
}


.coordinst-activity thead th {

    background: #f4f7fb;

    color: #52647c;

    border-bottom:
        1px solid #dce5ef;

    font-size: .80rem;

    font-weight: 800;

    text-transform: uppercase;

    padding: 13px 15px;
}


.coordinst-activity tbody td {

    padding: 15px;

    border-color: #e8edf3;

    color: #43536a;

    font-size: .9rem;
}


/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 1050px) {

    .coordinst-hero-top {

        flex-direction: column;

        align-items: flex-start;

        gap: 20px;
    }


    .coordinst-periodo {

        width: 100%;

        min-width: 0;

        justify-content: flex-start;

        padding-left: 0;

        border-left: none;

        border-top:
            1px solid rgba(255,255,255,.22);

        padding-top: 15px;
    }
}


@media (max-width: 768px) {

    .coordinst-hero {

        padding:
            22px 18px 12px;
    }


    .coordinst-panel-info {

        gap: 15px;
    }


    .coordinst-panel-icon {

        width: 65px;
        height: 65px;

        min-width: 65px;

        font-size: 1.8rem;
    }


    .coordinst-panel-title {

        font-size: 1.55rem;
    }


    .coordinst-panel-subtitle {

        font-size: .82rem;
    }


    .coordinst-periodo-name {

        font-size: 1.15rem;

        white-space: normal;
    }


    .coordinst-nav-link {

        min-width: 120px;

        height: 46px;

        font-size: .83rem;

        padding: 0 13px;
    }
}

</style>


{{-- ============================================================
     CONTENEDOR PRINCIPAL
     ============================================================ --}}

<div class="coordinst-dashboard">


    {{-- ========================================================
         PANEL AZUL
         ======================================================== --}}

    <section class="coordinst-hero">


        {{-- ====================================================
             CABECERA
             ==================================================== --}}

        <div class="coordinst-hero-top">


            {{-- INFORMACIÓN PRINCIPAL --}}

            <div class="coordinst-panel-info">

                <div class="coordinst-panel-icon">

    @if(isset($usuario) && $usuario->foto)

        <img
            src="{{ asset('storage/fotos/docentes/' . $usuario->foto) }}"
            alt="Foto del coordinador"
        >

    @else

        <i class="bi bi-person-fill"></i>

    @endif

</div>


                <div>

                    <h1 class="coordinst-panel-title">

                        Panel del Coordinador Institucional

                    </h1>


                    <p class="coordinst-panel-subtitle">

                        Supervisa y evalúa el programa institucional de tutorías

                    </p>

                </div>

            </div>


            {{-- =================================================
                 CICLO ESCOLAR
                 ================================================= --}}

            <div class="coordinst-periodo">



                <div class="coordinst-periodo-text">

                    <span class="coordinst-periodo-label">

                        Ciclo escolar actual

                    </span>


                    <span class="coordinst-periodo-name">

                        {{ $periodoActivo
                            ? $periodoActivo->nombre
                            : 'Sin periodo activo'
                        }}

                    </span>

                </div>

            </div>

        </div>


        {{-- ====================================================
             MENÚ
             ==================================================== --}}

        <nav class="coordinst-panel-nav">


            {{-- INICIO --}}

            <a
                href="{{ route('coordinst.index') }}"
                class="coordinst-nav-link
                    {{ request()->routeIs('coordinst.index') ? 'active' : '' }}"
            >

                <i class="bi bi-house-door-fill"></i>

                <span>
                    Inicio
                </span>

            </a>


            {{-- ESTUDIANTES --}}

            <a
                href="{{ route('coordinst.estudiantes') }}"
                class="coordinst-nav-link
                    {{ request()->routeIs('coordinst.estudiantes') ? 'active' : '' }}"
            >

                <i class="bi bi-people-fill"></i>

                <span>
                    Estudiantes
                </span>

            </a>


            {{-- DOCENTES --}}

            <a
                href="{{ route('coordinst.docentes') }}"
                class="coordinst-nav-link
                    {{ request()->routeIs('coordinst.docentes') ? 'active' : '' }}"
            >

                <i class="bi bi-person-badge-fill"></i>

                <span>
                    Docentes
                </span>

            </a>


            {{-- TUTORÍAS --}}

            <a
                href="{{ route('coordinst.tutorias') }}"
                class="coordinst-nav-link
                    {{ request()->routeIs('coordinst.tutorias') ? 'active' : '' }}"
            >

                <i class="bi bi-calendar-check-fill"></i>

                <span>
                    Tutorías
                </span>

            </a>


            {{-- CANALIZACIONES --}}

            <a
                href="{{ route('coordinst.canalizaciones') }}"
                class="coordinst-nav-link
                    {{ request()->routeIs('coordinst.canalizaciones') ? 'active' : '' }}"
            >

                <i class="bi bi-send-fill"></i>

                <span>
                    Canalizaciones
                </span>

            </a>


            {{-- PERFIL --}}

            <a
                href="{{ route('coordinst.perfil.view') }}"
                class="coordinst-nav-link
                    {{ request()->routeIs('coordinst.perfil.view') ? 'active' : '' }}"
            >

                <i class="bi bi-person-circle"></i>

                <span>
                    Perfil
                </span>

            </a>

        </nav>

    </section>


    {{-- ========================================================
         BIENVENIDA
         ======================================================== --}}

    <section class="coordinst-welcome">

        <h2 class="coordinst-welcome-title">

            👋 Bienvenido(a), {{ session('user_name', 'Coordinador Institucional') }}

        </h2>


        <p class="coordinst-welcome-text">

            Desde este panel puedes supervisar estudiantes, docentes,
            tutorías y canalizaciones del programa institucional.

        </p>

    </section>


    {{-- ========================================================
         MÉTRICAS PRINCIPALES
         ======================================================== --}}

    <section class="coordinst-metrics">

        <div class="row g-3">


            {{-- ESTUDIANTES --}}

            <div class="col-12 col-md-6 col-lg-4">

                <div class="coordinst-metric-card">

                    <div class="coordinst-metric-icon">

                        <i class="bi bi-people-fill"></i>

                    </div>


                    <p class="coordinst-metric-value">

                        {{ $totalEstudiantes ?? 0 }}

                    </p>


                    <div class="coordinst-metric-label">

                        Estudiantes registrados

                    </div>

                </div>

            </div>


            {{-- DOCENTES --}}

            <div class="col-12 col-md-6 col-lg-4">

                <div class="coordinst-metric-card">

                    <div class="coordinst-metric-icon">

                        <i class="bi bi-person-badge-fill"></i>

                    </div>


                    <p class="coordinst-metric-value">

                        {{ $totalDocentes ?? 0 }}

                    </p>


                    <div class="coordinst-metric-label">

                        Docentes registrados

                    </div>

                </div>

            </div>


            {{-- GRUPOS --}}

            <div class="col-12 col-md-6 col-lg-4">

                <div class="coordinst-metric-card">

                    <div class="coordinst-metric-icon">

                        <i class="bi bi-grid-3x3-gap-fill"></i>

                    </div>


                    <p class="coordinst-metric-value">

                        {{ $totalGrupos ?? 0 }}

                    </p>


                    <div class="coordinst-metric-label">

                        Grupos académicos

                    </div>

                </div>

            </div>


            {{-- CARRERAS --}}

            <div class="col-12 col-md-6 col-lg-4">

                <div class="coordinst-metric-card">

                    <div class="coordinst-metric-icon">

                        <i class="bi bi-mortarboard-fill"></i>

                    </div>


                    <p class="coordinst-metric-value">

                        {{ $totalCarreras ?? 0 }}

                    </p>


                    <div class="coordinst-metric-label">

                        Carreras

                    </div>

                </div>

            </div>


            {{-- TUTORÍAS --}}

            <div class="col-12 col-md-6 col-lg-4">

                <div class="coordinst-metric-card">

                    <div class="coordinst-metric-icon">

                        <i class="bi bi-calendar-check-fill"></i>

                    </div>


                    <p class="coordinst-metric-value">

                        {{
                            ($totalTutoriasIndividuales ?? 0)
                            +
                            ($totalTutoriasGrupales ?? 0)
                        }}

                    </p>


                    <div class="coordinst-metric-label">

                        Tutorías realizadas

                    </div>

                </div>

            </div>


            {{-- CANALIZACIONES --}}

            <div class="col-12 col-md-6 col-lg-4">

                <div class="coordinst-metric-card">

                    <div class="coordinst-metric-icon">

                        <i class="bi bi-send-fill"></i>

                    </div>


                    <p class="coordinst-metric-value">

                        {{ $totalCanalizaciones ?? 0 }}

                    </p>


                    <div class="coordinst-metric-label">

                        Canalizaciones realizadas

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- ========================================================
         ACTIVIDAD DEL PERIODO
         ======================================================== --}}

    <section class="coordinst-activity">


        <div class="coordinst-activity-header">

            <h3 class="coordinst-activity-title">

                <i class="bi bi-bar-chart-line-fill me-2"></i>

                Actividad del periodo

            </h3>


            <p class="coordinst-activity-subtitle">

                Recopilación de tutorías en el ciclo escolar activo.

            </p>

        </div>


        <div class="table-responsive">

            <table class="table table-hover align-middle">


                <thead>

                    <tr>

                        <th>
                            Tipo de tutoría
                        </th>

                        <th class="text-center">
                            Cantidad
                        </th>

                    </tr>

                </thead>


                <tbody>


                    {{-- TUTORÍAS INDIVIDUALES --}}

                    <tr>

                        <td>

                            <span class="fw-semibold">

                                Tutorías individuales

                            </span>

                        </td>

                        <td class="text-center">

                            <span class="fw-bold text-primary">

                                {{ $tutoriasIndividualesPeriodo ?? 0 }}

                            </span>

                        </td>

                    </tr>


                    {{-- TUTORÍAS GRUPALES --}}

                    <tr>

                        <td>

                            <span class="fw-semibold">

                                Tutorías grupales

                            </span>

                        </td>

                        <td class="text-center">

                            <span class="fw-bold text-primary">

                                {{ $tutoriasGrupalesPeriodo ?? 0 }}

                            </span>

                        </td>

                    </tr>


                    {{-- TOTAL --}}

                    <tr>

                        <td>

                            <strong class="text-primary">

                                Total general

                            </strong>

                        </td>

                        <td class="text-center">

                            <span class="badge bg-primary rounded-pill px-3 py-2">

                                {{
                                    ($tutoriasIndividualesPeriodo ?? 0)
                                    +
                                    ($tutoriasGrupalesPeriodo ?? 0)
                                }}

                            </span>

                        </td>

                    </tr>


                </tbody>

            </table>

        </div>

    </section>


</div>

@endsection