@extends('layouts.app')

@section('title', 'Panel del Estudiante')


@section('content')

{{-- ============================================================
     PANEL PRINCIPAL DEL ALUMNO
     
     IMPORTANTE:
     - El menú está DENTRO del panel azul.
     - El ciclo escolar está a la DERECHA.
     - El usuario NO se repite aquí.
     - El nombre/rol/salir permanecen únicamente en el encabezado.
     - Se conservan todas las variables originales.
     ============================================================ --}}


<style>

    /* ============================================================
       CONTENEDOR GENERAL DEL PANEL
       ============================================================ */

    .alumno-dashboard {

        width: 100%;

        margin: 0 auto;

    }


    /* ============================================================
       PANEL SUPERIOR AZUL
       ============================================================ */

    .alumno-hero {

        width: 100%;

        min-height: 245px;

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
       DECORACIÓN DEL PANEL
       ============================================================ */

    .alumno-hero::before {

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


    .alumno-hero::after {

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
       PARTE SUPERIOR DEL PANEL
       ============================================================ */

    .alumno-hero-top {

        position: relative;

        z-index: 2;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 35px;

        min-height: 125px;

    }


    /* ============================================================
       IDENTIDAD DEL PANEL
       ============================================================ */

    .alumno-panel-info {

        display: flex;

        align-items: center;

        gap: 22px;

        min-width: 0;

    }


    /* ============================================================
       ICONO PRINCIPAL
       ============================================================ */

    .alumno-panel-icon {

        width: 82px;

        height: 82px;

        flex-shrink: 0;

        border-radius: 50%;

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 2.4rem;

        color: #ffffff;

        border: 2px solid rgba(126, 196, 255, .65);

        background:
            rgba(255,255,255,.08);

        box-shadow:
            0 0 8px rgba(71,164,255,.75),
            0 0 20px rgba(71,164,255,.35),
            inset 0 0 15px rgba(255,255,255,.08);

    }


    /* ============================================================
       TÍTULO DEL PANEL
       ============================================================ */

    .alumno-panel-title {

        margin: 0;

        color: #ffffff;

        font-size: 2rem;

        font-weight: 800;

        line-height: 1.1;

    }


    .alumno-panel-subtitle {

        margin: 8px 0 0;

        color: rgba(255,255,255,.90);

        font-size: 1rem;

        font-weight: 500;

    }


    /* ============================================================
       CICLO ESCOLAR
       ============================================================ */

    .alumno-periodo {

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

    .alumno-periodo-icon {

        width: 58px;

        height: 58px;

        flex-shrink: 0;

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


    /* ============================================================
       TEXTO DEL CICLO
       ============================================================ */

    .alumno-periodo-text {

        display: flex;

        flex-direction: column;

        align-items: flex-start;

    }


    .alumno-periodo-label {

        color: rgba(255,255,255,.80);

        font-size: .78rem;

        font-weight: 500;

        text-transform: uppercase;

        letter-spacing: 1px;

        margin-bottom: 5px;

    }


    .alumno-periodo-name {

        color: #ffffff;

        font-size: 1.45rem;

        font-weight: 800;

        line-height: 1.1;

        white-space: nowrap;

    }


    /* ============================================================
       MENÚ DENTRO DEL PANEL
       ============================================================ */

    .alumno-panel-nav {

        position: relative;

        z-index: 3;

        width: 100%;

        display: flex;

        align-items: center;

        justify-content: flex-start;

        gap: 9px;

        margin-top: 10px;

        padding: 0 2px;

    }


    /* ============================================================
       BOTONES DEL MENÚ
       ============================================================ */

    .alumno-panel-nav .alumno-nav-link {

        min-width: 145px;

        height: 50px;

        padding: 0 20px;

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 9px;

        border-radius: 11px;

        border:
            1px solid rgba(99,173,255,.55);

        background:
            rgba(25,84,160,.34);

        color: #ffffff;

        text-decoration: none;

        font-size: .95rem;

        font-weight: 700;

        white-space: nowrap;

        transition:
            all .22s ease;

    }


    /* ============================================================
       ICONOS DE LOS BOTONES
       ============================================================ */

    .alumno-nav-link .nav-icon {

        font-size: 1rem;

    }


    /* ============================================================
       HOVER - EFECTO LED
       ============================================================ */

    .alumno-panel-nav .alumno-nav-link:hover {

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
       PESTAÑA ACTIVA - LED
       ============================================================ */

    .alumno-panel-nav .alumno-nav-link.active {

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
       SECCIÓN DE BIENVENIDA
       ============================================================ */

    .alumno-welcome {

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

        text-align: left;

    }


    .alumno-welcome-title {

        margin: 0 0 7px;

        color: #1763c4;

        font-size: 1.45rem;

        font-weight: 800;

    }


    .alumno-welcome-text {

        margin: 0;

        color: #61728b;

        font-size: 1rem;

    }


    /* ============================================================
       TARJETAS KPI
       ============================================================ */

    .alumno-kpis {

        margin-top: 22px;

    }


    .alumno-kpi {

        height: 100%;

        min-height: 120px;

        padding: 20px;

        background: #ffffff;

        border:
            1px solid #dce6f2;

        border-radius: 16px;

        box-shadow:
            0 5px 16px rgba(30,70,120,.07);

        transition:
            transform .2s ease,
            box-shadow .2s ease;

        text-align: left;

    }


    .alumno-kpi:hover {

        transform:
            translateY(-2px);

        box-shadow:
            0 8px 20px rgba(30,70,120,.11);

    }


    .alumno-kpi-title {

        margin-bottom: 8px;

        font-size: .82rem;

        font-weight: 700;

        text-transform: uppercase;

        letter-spacing: .3px;

    }


    .alumno-kpi-value {

        margin: 0;

        color: #202733;

        font-size: 2.35rem;

        font-weight: 800;

        line-height: 1;

    }


    /* ============================================================
       ACTIVIDAD RECIENTE
       ============================================================ */

    .alumno-activity {

        margin-top: 26px;

        background: #ffffff;

        border:
            1px solid #dce6f2;

        border-radius: 16px;

        box-shadow:
            0 5px 18px rgba(30,70,120,.08);

        overflow: hidden;

    }


    /* ============================================================
       CABECERA DE ACTIVIDAD
       ============================================================ */

    .alumno-activity-header {

        min-height: 68px;

        padding: 0 22px;

        display: flex;

        align-items: center;

        justify-content: space-between;

        border-bottom:
            1px solid #e1e8f0;

    }


    .alumno-activity-title {

        margin: 0;

        color: #234f87;

        font-size: 1.25rem;

        font-weight: 800;

    }


    .alumno-activity-title i {

        color: #2677d8;

    }


    .alumno-activity-badge {

        background: #f6f8fb;

        color: #64748b;

        border:
            1px solid #dce3ec;

        padding:
            7px 12px;

        border-radius: 8px;

        font-size: .78rem;

        font-weight: 700;

    }


    /* ============================================================
       TABLA
       ============================================================ */

    .alumno-activity table {

        margin-bottom: 0;

    }


    .alumno-activity thead th {

        background:
            #f4f7fb;

        color: #52647c;

        border-bottom:
            1px solid #dce5ef;

        font-size: .80rem;

        font-weight: 800;

        text-transform: uppercase;

        padding:
            13px 12px;

    }


    .alumno-activity tbody td {

        padding:
            13px 12px;

        border-color:
            #e8edf3;

        color: #43536a;

        font-size: .88rem;

    }


    .alumno-activity tbody tr:hover {

        background:
            #f7fbff;

    }


    /* ============================================================
       ESTADO VACÍO
       ============================================================ */

    .alumno-empty {

        min-height: 260px;

        display: flex;

        flex-direction: column;

        align-items: center;

        justify-content: center;

        text-align: center;

        padding: 40px 20px;

        color: #75859b;

    }


    .alumno-empty-icon {

        font-size: 3rem;

        color: #b8c7d9;

        margin-bottom: 12px;

    }


    .alumno-empty-title {

        color: #334b68;

        font-size: 1rem;

        font-weight: 800;

        margin-bottom: 5px;

    }


    .alumno-empty-text {

        margin: 0;

        font-size: .9rem;

    }


    /* ============================================================
       RESPONSIVE
       ============================================================ */

    @media (max-width: 1000px) {

        .alumno-hero-top {

            flex-direction: column;

            align-items: flex-start;

            gap: 20px;

        }


        .alumno-periodo {

            width: 100%;

            min-width: 0;

            padding-left: 0;

            border-left: 0;

            border-top:
                1px solid rgba(255,255,255,.20);

            padding-top: 15px;

        }


        .alumno-panel-nav {

            overflow-x: auto;

        }

    }


    @media (max-width: 768px) {

        .alumno-hero {

            padding:
                22px 18px 12px;

        }


        .alumno-panel-info {

            gap: 15px;

        }


        .alumno-panel-icon {

            width: 65px;

            height: 65px;

            font-size: 1.8rem;

        }


        .alumno-panel-title {

            font-size: 1.55rem;

        }


        .alumno-periodo-name {

            font-size: 1.15rem;

        }


        .alumno-panel-nav {

            justify-content: flex-start;

        }


        .alumno-panel-nav .alumno-nav-link {

            min-width: 135px;

        }

    }

</style>


{{-- ============================================================
     CONTENEDOR PRINCIPAL
     ============================================================ --}}

<div class="alumno-dashboard">


    {{-- ========================================================
         PANEL AZUL PRINCIPAL
         ======================================================== --}}

    <section class="alumno-hero">


        {{-- ====================================================
             PARTE SUPERIOR:
             PANEL DEL ALUMNO + CICLO ESCOLAR
             ==================================================== --}}

        <div class="alumno-hero-top">


            {{-- =================================================
                 IZQUIERDA: PANEL DEL ALUMNO
                 ================================================= --}}

            <div class="alumno-panel-info">


                {{-- Icono --}}
                <div class="alumno-panel-icon">

                    <i class="bi bi-person-badge"></i>

                </div>


                {{-- Título --}}
                <div>

                    <h1 class="alumno-panel-title">

                        Panel del Alumno

                    </h1>


                    <p class="alumno-panel-subtitle">

                        Consulta y da seguimiento a tus tutorías

                    </p>

                </div>

            </div>


            {{-- =================================================
                 DERECHA: CICLO ESCOLAR
                 ================================================= --}}

            <div class="alumno-periodo">


                {{-- Icono calendario --}}
                <div class="alumno-periodo-icon">

                    <i class="bi bi-calendar3"></i>

                </div>


                {{-- Información --}}
                <div class="alumno-periodo-text">

                    <span class="alumno-periodo-label">

                        Ciclo escolar actual

                    </span>


                    <span class="alumno-periodo-name">

                        {{ $periodoActivo ? $periodoActivo->nombre : 'Sin periodo activo' }}

                    </span>

                </div>

            </div>

        </div>


        {{-- ====================================================
             MENÚ DE NAVEGACIÓN
             
             QUEDA DENTRO DEL MISMO PANEL AZUL
             ==================================================== --}}

        <nav class="alumno-panel-nav">


            {{-- =================================================
                 INICIO
                 ================================================= --}}

            <a
                href="{{ route('alumno.index') }}"
                class="alumno-nav-link
                    {{ request()->routeIs('alumno.index') ? 'active' : '' }}"
            >

                <i class="bi bi-house-door-fill nav-icon"></i>

                <span>
                    Inicio
                </span>

            </a>


            {{-- =================================================
                 MIS TUTORÍAS
                 ================================================= --}}

            <a
                href="{{ route('alumno.tutorias') }}"
                class="alumno-nav-link
                    {{ request()->routeIs('alumno.tutorias') ? 'active' : '' }}"
            >

                <i class="bi bi-calendar-check-fill nav-icon"></i>

                <span>
                    Mis tutorías
                </span>

            </a>


            {{-- =================================================
                 CANALIZACIONES
                 ================================================= --}}

            <a
                href="{{ route('alumno.canalizaciones') }}"
                class="alumno-nav-link
                    {{ request()->routeIs('alumno.canalizaciones') ? 'active' : '' }}"
            >

                <i class="bi bi-people-fill nav-icon"></i>

                <span>
                    Canalizaciones
                </span>

            </a>


            {{-- =================================================
                 PERFIL
                 ================================================= --}}

            <a
                href="{{ route('alumno.perfil') }}"
                class="alumno-nav-link
                    {{ request()->routeIs('alumno.perfil') ? 'active' : '' }}"
            >

                <i class="bi bi-person-circle nav-icon"></i>

                <span>
                    Perfil
                </span>

            </a>

{{-- ASESORÍAS ACADÉMICAS --}}
<a
    href="{{ route('alumno.asesorias') }}"
    class="alumno-nav-link {{ request()->routeIs('alumno.asesorias') ? 'active' : '' }}"
>
    <i class="bi bi-book-half nav-icon"></i>
    <span>Asesorías</span>
</a>



        </nav>

    </section>


    {{-- ========================================================
         BIENVENIDA
         ======================================================== --}}

    <section class="alumno-welcome">


        <h2 class="alumno-welcome-title">

            👋 Bienvenido(a), {{ $nombre ?? 'Estudiante' }}!

        </h2>


        <p class="alumno-welcome-text">

            Desde este panel puedes consultar tus tutorías grupales e individuales,
            revisar observaciones y las canalizaciones emitidas por tu tutor.

        </p>


    </section>


    {{-- ========================================================
         TARJETAS DE ESTADÍSTICAS
         ======================================================== --}}

    <section class="alumno-kpis">


        <div class="row g-3">


            {{-- =================================================
                 TUTORÍAS ASISTIDAS
                 ================================================= --}}

            <div class="col-12 col-md-4">

                <div class="alumno-kpi">


                    <div class="alumno-kpi-title text-primary">

                        Tutorías asistidas

                    </div>


                    <p class="alumno-kpi-value">

                        {{ $totalAsistidas ?? 0 }}

                    </p>


                </div>

            </div>


            {{-- =================================================
                 ASISTENCIA GENERAL
                 ================================================= --}}

            <div class="col-12 col-md-4">

                <div class="alumno-kpi">


                    <div class="alumno-kpi-title text-success">

                        Asistencia general

                    </div>


                    <p class="alumno-kpi-value">

                        {{ $porcentajeAsistencia ?? '0%' }}

                    </p>


                </div>

            </div>


            {{-- =================================================
                 CANALIZACIONES
                 ================================================= --}}

            <div class="col-12 col-md-4">

                <div class="alumno-kpi">


                    <div class="alumno-kpi-title text-danger">

                        Canalizaciones

                    </div>


                    <p class="alumno-kpi-value">

                        {{ $totalCanalizaciones ?? 0 }}

                    </p>


                </div>

            </div>


        </div>

    </section>


    {{-- ========================================================
         ACTIVIDAD RECIENTE
         ======================================================== --}}

    <section class="alumno-activity">


        {{-- ====================================================
             CABECERA
             ==================================================== --}}

        <div class="alumno-activity-header">


            <h3 class="alumno-activity-title">

                <i class="bi bi-clock-history me-2"></i>

                Actividad Reciente

            </h3>


            <span class="alumno-activity-badge">

                Últimos movimientos

            </span>


        </div>


        {{-- ====================================================
             CONTENIDO
             ==================================================== --}}

        <div class="card-body p-0">


            @if(isset($tutorias) && count($tutorias) > 0)


                {{-- ============================================
                     TABLA
                     ============================================ --}}

                <div class="table-responsive">


                    <table class="table table-hover align-middle mb-0">


                        <thead>


                            <tr>

                                <th class="ps-4">
                                    Fecha
                                </th>

                                <th>
                                    Tipo
                                </th>

                                <th>
                                    Tema / Motivo
                                </th>

                                <th>
                                    Tutor
                                </th>

                                <th>
                                    Estado
                                </th>

                            </tr>


                        </thead>


                        <tbody>


                            @foreach($tutorias as $t)


                                <tr>


                                    {{-- Fecha --}}
                                    <td class="ps-4 fw-semibold text-nowrap">

                                        {{ \Illuminate\Support\Carbon::parse($t->fecha)->format('d/m/Y') }}

                                    </td>


                                    {{-- Tipo --}}
                                    <td>


                                        @if($t->tipo == 'Grupal')


                                            <span
                                                class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3"
                                            >

                                                Grupal

                                            </span>


                                        @else


                                            <span
                                                class="badge bg-info bg-opacity-10 text-info text-dark rounded-pill px-3"
                                            >

                                                Individual

                                            </span>


                                        @endif


                                    </td>


                                    {{-- Tema --}}
                                    <td
                                        class="text-truncate fw-medium"
                                        style="max-width: 250px;"
                                        title="{{ $t->tema }}"
                                    >

                                        {{ $t->tema }}

                                    </td>


                                    {{-- Tutor --}}
                                    <td class="small text-muted">

                                        {{ $t->tutor }}

                                    </td>


                                    {{-- Estado --}}
                                    <td>


                                        <span
                                            class="badge bg-{{ $t->estado_clase }}"
                                        >

                                            {{ $t->estado_texto }}

                                        </span>


                                    </td>


                                </tr>


                            @endforeach


                        </tbody>


                    </table>


                </div>


                {{-- ============================================
                     VER HISTORIAL
                     ============================================ --}}

                <div
                    class="text-center py-3"
                    style="border-top:1px solid #e8edf3;"
                >

                    <a
                        href="{{ route('alumno.tutorias') }}"
                        class="text-decoration-none fw-bold small text-primary"
                    >

                        Ver historial completo

                        <i class="bi bi-arrow-right ms-1"></i>

                    </a>

                </div>


            @else


                {{-- ============================================
                     SIN ACTIVIDAD
                     ============================================ --}}

                <div class="alumno-empty">


                    <i class="bi bi-calendar-x alumno-empty-icon"></i>


                    <div class="alumno-empty-title">

                        Sin actividad reciente

                    </div>


                    <p class="alumno-empty-text">

                        No tienes tutorías registradas próximamente.

                    </p>


                </div>


            @endif


        </div>


    </section>


</div>

@endsection