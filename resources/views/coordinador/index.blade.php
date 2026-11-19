@extends('layouts.app')

@section('title', 'Panel del Coordinador')

@section('content')

<style>
/* ============================================================
   CONTENEDOR GENERAL
   ============================================================ */

.coord-dashboard {
    width: 100%;
    max-width: 1520px;
    margin: 0 auto;
}


/* ============================================================
   PANEL AZUL PRINCIPAL
   ============================================================ */

.coord-hero {
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
   DECORACIÓN
   ============================================================ */

.coord-hero::before {
    content: "";

    position: absolute;

    width: 500px;
    height: 300px;

    top: -180px;
    left: 25%;

    border-radius: 50%;

    background: rgba(63, 139, 255, .16);

    pointer-events: none;
}

.coord-hero::after {
    content: "";

    position: absolute;

    width: 450px;
    height: 250px;

    right: -180px;
    top: -80px;

    border-radius: 50%;

    background: rgba(44, 117, 235, .12);

    pointer-events: none;
}


/* ============================================================
   PARTE SUPERIOR
   ============================================================ */

.coord-hero-top {
    position: relative;
    z-index: 2;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 35px;

    min-height: 125px;
}


/* ============================================================
   IDENTIDAD
   ============================================================ */

.coord-panel-info {
    display: flex;
    align-items: center;

    gap: 22px;

    min-width: 0;
}


/* ============================================================
   ICONO
   ============================================================ */

.coord-panel-icon {
    width: 82px;
    height: 82px;
    flex-shrink: 0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    font-size: 2.4rem;
    color: #ffffff;
    border: 2px solid rgba(126, 196, 255, .65);
    background: rgba(255,255,255,.08);
    box-shadow:
        0 0 8px rgba(71,164,255,.75),
        0 0 20px rgba(71,164,255,.35),
        inset 0 0 15px rgba(255,255,255,.08);
}
.coord-panel-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    display: block;
}

/* ============================================================
   TÍTULO
   ============================================================ */

.coord-panel-title {
    margin: 0;

    color: #ffffff;

    font-size: 2rem;

    font-weight: 800;

    line-height: 1.1;
}

.coord-panel-subtitle {
    margin: 8px 0 0;

    color: rgba(255,255,255,.90);

    font-size: 1rem;

    font-weight: 500;
}


/* ============================================================
   CICLO ESCOLAR
   ============================================================ */

.coord-periodo {
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
   ICONO CICLO
   ============================================================ */

.coord-periodo-icon {
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


.coord-periodo-text {
    display: flex;
    flex-direction: column;

    align-items: flex-start;
}


.coord-periodo-label {
    color: rgba(255,255,255,.80);

    font-size: .78rem;

    font-weight: 500;

    text-transform: uppercase;

    letter-spacing: 1px;

    margin-bottom: 5px;
}


.coord-periodo-name {
    color: #ffffff;

    font-size: 1.45rem;

    font-weight: 800;

    line-height: 1.1;

    white-space: nowrap;
}


/* ============================================================
   MENÚ
   ============================================================ */

.coord-panel-nav {
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
   BOTONES
   ============================================================ */

.coord-nav-link {
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

    transition: all .22s ease;
}


.coord-nav-link .nav-icon {
    font-size: 1rem;
}


/* ============================================================
   EFECTO LED
   ============================================================ */

.coord-nav-link:hover {
    color: #ffffff;

    background:
        linear-gradient(
            180deg,
            #3195ff 0%,
            #176bd7 100%
        );

    border-color: #82ccff;

    box-shadow:
        0 0 6px rgba(59,165,255,1),
        0 0 14px rgba(59,165,255,.90),
        0 0 27px rgba(59,165,255,.55),
        inset 0 1px 0 rgba(255,255,255,.48);

    transform: translateY(-1px);
}


.coord-nav-link.active {
    color: #ffffff;

    background:
        linear-gradient(
            180deg,
            #3195ff 0%,
            #176bd7 100%
        );

    border-color: #82ccff;

    box-shadow:
        0 0 7px rgba(59,165,255,1),
        0 0 17px rgba(59,165,255,.90),
        0 0 30px rgba(59,165,255,.55),
        inset 0 1px 0 rgba(255,255,255,.50);
}


/* ============================================================
   BIENVENIDA
   ============================================================ */

.coord-welcome {
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


.coord-welcome-title {
    margin: 0 0 7px;

    color: #1763c4;

    font-size: 1.45rem;

    font-weight: 800;
}


.coord-welcome-text {
    margin: 0;

    color: #61728b;

    font-size: 1rem;
}


/* ============================================================
   MÉTRICAS
   ============================================================ */

.coord-kpis {
    margin-top: 22px;
}


.coord-kpi {
    height: 100%;

    min-height: 135px;

    padding: 20px;

    background: #ffffff;

    border:
        1px solid #dce6f2;

    border-radius: 16px;

    box-shadow:
        0 5px 16px rgba(30,70,120,.07);

    transition: .2s ease;

    text-align: left;
}


.coord-kpi:hover {
    transform: translateY(-2px);

    box-shadow:
        0 8px 20px rgba(30,70,120,.11);
}


.coord-kpi-title {
    margin-bottom: 8px;

    font-size: .82rem;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .3px;
}


.coord-kpi-value {
    margin: 0;

    color: #202733;

    font-size: 2.35rem;

    font-weight: 800;

    line-height: 1;
}


/* ============================================================
   TABLA / RESUMEN
   ============================================================ */

.coord-summary {
    margin-top: 26px;

    background: #ffffff;

    border:
        1px solid #dce6f2;

    border-radius: 16px;

    box-shadow:
        0 5px 18px rgba(30,70,120,.08);

    overflow: hidden;
}


.coord-summary-header {
    min-height: 68px;

    padding: 20px 22px;

    border-bottom:
        1px solid #e1e8f0;
}


.coord-summary-title {
    margin: 0;

    color: #234f87;

    font-size: 1.25rem;

    font-weight: 800;
}


.coord-summary table {
    margin-bottom: 0;
}


.coord-summary thead th {
    background: #f4f7fb;

    color: #52647c;

    border-bottom:
        1px solid #dce5ef;

    font-size: .80rem;

    font-weight: 800;

    text-transform: uppercase;

    padding: 13px 12px;
}


.coord-summary tbody td {
    padding: 15px 12px;

    border-color: #e8edf3;

    color: #43536a;

    font-size: .9rem;
}


/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 1000px) {

    .coord-hero-top {
        flex-direction: column;

        align-items: flex-start;

        gap: 20px;
    }

    .coord-periodo {
        width: 100%;

        min-width: 0;

        padding-left: 0;

        border-left: 0;

        border-top:
            1px solid rgba(255,255,255,.20);

        padding-top: 15px;
    }

    .coord-panel-nav {
        overflow-x: auto;
    }
}


@media (max-width: 768px) {

    .coord-hero {
        padding:
            22px 18px 12px;
    }

    .coord-panel-info {
        gap: 15px;
    }

    .coord-panel-icon {
        width: 65px;
        height: 65px;

        font-size: 1.8rem;
    }

    .coord-panel-title {
        font-size: 1.55rem;
    }

    .coord-periodo-name {
        font-size: 1.15rem;
    }

    .coord-nav-link {
        min-width: 135px;
    }
}
</style>


<div class="coord-dashboard">

    {{-- =====================================================
         PANEL PRINCIPAL
         ===================================================== --}}

    <section class="coord-hero">

        <div class="coord-hero-top">

            {{-- IZQUIERDA --}}
            <div class="coord-panel-info">

                <div class="coord-panel-icon">

                    @if($usuario->foto)
                        <img
                            src="{{ asset('storage/fotos/docentes/' . $usuario->foto) }}"
                            alt="Foto del coordinador"
                        >
                    @else
                        <i class="bi bi-person-workspace"></i>
                    @endif

                </div>

                <div>

                    <h1 class="coord-panel-title">
                        Panel del Coordinador
                    </h1>

                    <p class="coord-panel-subtitle">
                        Gestiona y da seguimiento al proceso de tutorías
                    </p>

                </div>

            </div>


            {{-- DERECHA: CICLO --}}
           <div class="coord-periodo">

    <div class="coord-periodo-text">

        <span class="coord-periodo-label">
            Ciclo escolar actual
        </span>

        <span class="coord-periodo-name">
            {{ $periodoActivo ? $periodoActivo->nombre : 'Sin periodo activo' }}
        </span>

    </div>

</div>

        </div>


        {{-- =================================================
             MENÚ
             ================================================= --}}

        <nav class="coord-panel-nav">

            <a
                href="{{ route('coord.index') }}"
                class="coord-nav-link {{ request()->routeIs('coord.index') ? 'active' : '' }}"
            >
                <i class="bi bi-house-door-fill nav-icon"></i>
                <span>Inicio</span>
            </a>


            <a
                href="{{ route('coord.seguimiento') }}"
                class="coord-nav-link {{ request()->routeIs('coord.seguimiento') ? 'active' : '' }}"
            >
                <i class="bi bi-person-check-fill nav-icon"></i>
                <span>Seguimiento a tutores</span>
            </a>


            <a
                href="{{ route('coord.informes') }}"
                class="coord-nav-link {{ request()->routeIs('coord.informes') ? 'active' : '' }}"
            >
                <i class="bi bi-file-earmark-text-fill nav-icon"></i>
                <span>Informes</span>
            </a>


            <a
                href="{{ route('coord.reportes') }}"
                class="coord-nav-link {{ request()->routeIs('coord.reportes') ? 'active' : '' }}"
            >
                <i class="bi bi-bar-chart-fill nav-icon"></i>
                <span>Reportes</span>
            </a>


            <a
                href="{{ route('coordinador.perfil.view') }}"
                class="coord-nav-link {{ request()->routeIs('coordinador.perfil.view') ? 'active' : '' }}"
            >
                <i class="bi bi-person-circle nav-icon"></i>
                <span>Mi Perfil</span>
            </a>

        </nav>

    </section>


    {{-- =====================================================
         BIENVENIDA
         ===================================================== --}}

    <section class="coord-welcome">

        <h2 class="coord-welcome-title">
            👋 Bienvenido(a), {{ session('user_name', 'Coordinador') }}!
        </h2>

        <p class="coord-welcome-text">
            Desde este panel puedes dar seguimiento a tutores,
            consolidar informes y generar reportes del área.
        </p>

    </section>


    {{-- =====================================================
         MÉTRICAS
         ===================================================== --}}

    <section class="coord-kpis">

        <div class="row g-3">

            <div class="col-12 col-md-6 col-lg-3">

                <div class="coord-kpi">

                    <div class="coord-kpi-title text-primary">
                        Tutores
                    </div>

                    <p class="coord-kpi-value">
                        {{ $totalTutores ?? 0 }}
                    </p>

                </div>

            </div>


            <div class="col-12 col-md-6 col-lg-3">

                <div class="coord-kpi">

                    <div class="coord-kpi-title text-primary">
                        Grupos
                    </div>

                    <p class="coord-kpi-value">
                        {{ $totalGrupos ?? 0 }}
                    </p>

                </div>

            </div>


            <div class="col-12 col-md-6 col-lg-3">

                <div class="coord-kpi">

                    <div class="coord-kpi-title text-primary">
                        Tutorías en el mes
                    </div>

                    <p class="coord-kpi-value">
                        {{ $tutoriasPeriodo ?? 0 }}
                    </p>

                </div>

            </div>


            <div class="col-12 col-md-6 col-lg-3">

                <div class="coord-kpi">

                    <div class="coord-kpi-title text-success">
                        Asistencia promedio
                    </div>

                    <p class="coord-kpi-value">
                        {{ $asistenciaPromedio ?? 0 }}%
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         RESUMEN
         ===================================================== --}}

    <section class="coord-summary">

        <div class="coord-summary-header">

            <h3 class="coord-summary-title">
                <i class="bi bi-bar-chart-line-fill me-2"></i>
                Resumen del periodo
            </h3>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th>Indicador</th>
                        <th class="text-center">Cantidad</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>Tutores registrados</td>
                        <td class="text-center fw-bold text-primary">
                            {{ $totalTutores ?? 0 }}
                        </td>
                    </tr>

                    <tr>
                        <td>Grupos académicos</td>
                        <td class="text-center fw-bold text-primary">
                            {{ $totalGrupos ?? 0 }}
                        </td>
                    </tr>

                    <tr>
                        <td>Tutorías en el periodo</td>
                        <td class="text-center fw-bold text-primary">
                            {{ $tutoriasPeriodo ?? 0 }}
                        </td>
                    </tr>

                    <tr>
                        <td>Asistencia promedio</td>
                        <td class="text-center fw-bold text-success">
                            {{ $asistenciaPromedio ?? 0 }}%
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </section>

</div>

@endsection