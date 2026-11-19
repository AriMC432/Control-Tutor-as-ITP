@extends('layouts.app')

@section('title', 'Panel de Soporte')

@section('content')

<style>

/* ============================================================
   CONTENEDOR GENERAL
   ============================================================ */

.soporte-dashboard {
    width: 100%;
    max-width: 1520px;
    margin: 0 auto;
}


/* ============================================================
   PANEL PRINCIPAL
   ============================================================ */

.soporte-hero {
    width: 100%;
    min-height: 310px;

    padding: 28px 30px 24px;

    border-radius: 18px;

    background: linear-gradient(
        135deg,
        #2057a4 0%,
        #16468d 48%,
        #0b326f 100%
    );

    position: relative;
    overflow: hidden;

    box-shadow: 0 12px 28px rgba(20, 62, 120, .22);

    color: #ffffff;
}


/* ============================================================
   DECORACIÓN
   ============================================================ */

.soporte-hero::before {
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


.soporte-hero::after {
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
   ENCABEZADO DEL PANEL
   ============================================================ */

.soporte-hero-top {
    position: relative;
    z-index: 2;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 35px;

    min-height: 145px;
}


/* ============================================================
   IDENTIDAD
   ============================================================ */

.soporte-panel-info {
    display: flex;
    align-items: center;

    gap: 22px;

    min-width: 0;
}


/* ============================================================
   FOTO / CÍRCULO
   ============================================================ */

.soporte-panel-icon {
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

    background: rgba(255,255,255,.08);

    box-shadow:
        0 0 8px rgba(71,164,255,.75),
        0 0 20px rgba(71,164,255,.35),
        inset 0 0 15px rgba(255,255,255,.08);

    overflow: hidden;
}


.soporte-panel-icon img {
    width: 100%;
    height: 100%;

    object-fit: cover;

    border-radius: 50%;

    display: block;
}


/* ============================================================
   TÍTULO
   ============================================================ */

.soporte-panel-title {
    margin: 0;

    color: #ffffff;

    font-size: 2rem;
    font-weight: 800;

    line-height: 1.1;
}


.soporte-panel-subtitle {
    margin: 8px 0 0;

    color: rgba(255,255,255,.90);

    font-size: 1rem;
    font-weight: 500;
}


/* ============================================================
   PERIODO ESCOLAR
   ============================================================ */

.soporte-periodo {
    min-width: 350px;

    display: flex;
    align-items: center;
    justify-content: flex-end;

    padding-left: 28px;

    border-left: 1px solid rgba(255,255,255,.28);
}


/*
   SIN CUADRADO DE CALENDARIO
   El periodo solamente muestra el texto.
*/

.soporte-periodo-text {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}


.soporte-periodo-label {
    color: rgba(255,255,255,.80);

    font-size: .78rem;
    font-weight: 500;

    text-transform: uppercase;

    letter-spacing: 1px;

    margin-bottom: 5px;

    white-space: nowrap;
}


.soporte-periodo-name {
    color: #ffffff;

    font-size: 1.45rem;
    font-weight: 800;

    line-height: 1.1;

    white-space: nowrap;
}


/* ============================================================
   MENÚ DENTRO DEL PANEL AZUL
   ============================================================ */

.soporte-panel-nav {
    position: relative;
    z-index: 3;

    width: 100%;

    display: grid;

    /*
       7 botones exactamente en una fila
    */
    grid-template-columns: repeat(7, minmax(0, 1fr));

    gap: 9px;

    margin-top: 20px;

    padding: 0 2px;
}


/* ============================================================
   BOTONES
   ============================================================ */

.soporte-nav-link {
    width: 100%;
    min-width: 0;

    height: 50px;

    padding: 0 10px;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    border-radius: 11px;

    border: 1px solid rgba(99,173,255,.55);

    background: rgba(25,84,160,.34);

    color: #ffffff;

    text-decoration: none;

    font-size: .92rem;
    font-weight: 700;

    white-space: nowrap;

    transition: all .22s ease;
}


.soporte-nav-link i {
    font-size: 1rem;
}


/* ============================================================
   HOVER Y OPCIÓN ACTIVA
   ============================================================ */

.soporte-nav-link:hover,
.soporte-nav-link.active {
    color: #ffffff;

    background: linear-gradient(
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

    transform: translateY(-1px);
}


/* ============================================================
   BIENVENIDA
   ============================================================ */

.soporte-welcome {
    margin-top: 28px;

    padding: 26px 28px;

    background: linear-gradient(
        135deg,
        #f5f9ff,
        #edf4fd
    );

    border: 1px solid #d8e5f5;

    border-radius: 16px;

    box-shadow: 0 5px 16px rgba(30,70,120,.07);

    text-align: center;
}


.soporte-welcome-icon {
    width: 66px;
    height: 66px;

    margin: 0 auto 14px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #e1edff;

    color: #1763c4;

    font-size: 2rem;
}


.soporte-welcome-title {
    margin: 0 0 10px;

    color: #1763c4;

    font-size: 1.45rem;
    font-weight: 800;
}


.soporte-welcome-text {
    margin: 0;

    color: #61728b;

    font-size: 1rem;
}


/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 1200px) {

    .soporte-panel-nav {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    .soporte-nav-link {
        font-size: .88rem;
    }
}


@media (max-width: 1000px) {

    .soporte-hero-top {
        flex-direction: column;

        align-items: flex-start;

        gap: 20px;
    }

    .soporte-periodo {
        width: 100%;

        min-width: 0;

        padding-left: 0;

        padding-top: 15px;

        border-left: 0;

        border-top: 1px solid rgba(255,255,255,.20);

        justify-content: flex-start;
    }

    .soporte-panel-nav {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}


@media (max-width: 768px) {

    .soporte-hero {
        padding: 22px 18px 18px;
    }

    .soporte-panel-info {
        gap: 15px;
    }

    .soporte-panel-icon {
        width: 65px;
        height: 65px;

        font-size: 1.8rem;
    }

    .soporte-panel-title {
        font-size: 1.55rem;
    }

    .soporte-periodo-name {
        font-size: 1.15rem;
    }

    .soporte-panel-nav {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }

    .soporte-nav-link {
        min-width: 0;
        font-size: .88rem;
    }

    .soporte-welcome {
        padding: 22px 18px;
    }
}


@media (max-width: 500px) {

    .soporte-panel-nav {
        grid-template-columns: 1fr;
    }
}

</style>


<div class="soporte-dashboard">

    {{-- =====================================================
         PANEL PRINCIPAL DE SOPORTE
         ===================================================== --}}

    <section class="soporte-hero">

        {{-- =================================================
             ENCABEZADO Y PERIODO
             ================================================= --}}

        <div class="soporte-hero-top">

            {{-- =================================================
                 IZQUIERDA: IDENTIDAD
                 ================================================= --}}

            <div class="soporte-panel-info">

                @php
                    $fotoSoporte = session('user_photo');
                @endphp

                {{-- FOTO DEL USUARIO --}}

                <div class="soporte-panel-icon">

                    @if($fotoSoporte)

                        <img
                            src="{{ asset('storage/fotos/docentes/' . $fotoSoporte) }}"
                            alt="Foto del usuario"
                        >

                    @else

                        <i class="bi bi-headset"></i>

                    @endif

                </div>


                <div>

                    <h1 class="soporte-panel-title">
                        Panel de Soporte
                    </h1>

                    <p class="soporte-panel-subtitle">
                        Administración y soporte de la aplicación de tutorías
                    </p>

                </div>

            </div>


            {{-- =================================================
                 DERECHA: PERIODO ESCOLAR
                 ================================================= --}}

            <div class="soporte-periodo">

                <div class="soporte-periodo-text">

                    <span class="soporte-periodo-label">
                        Ciclo escolar actual
                    </span>

                    <span class="soporte-periodo-name">
                        {{ $periodoActivo ? $periodoActivo->nombre : 'Sin periodo activo' }}
                    </span>

                </div>

            </div>

        </div>


        {{-- =================================================
             OPCIONES DE SOPORTE
             ================================================= --}}

        <nav class="soporte-panel-nav">

            {{-- INICIO --}}

            <a
                href="{{ route('soporte.index') }}"
                class="soporte-nav-link {{ request()->routeIs('soporte.index') ? 'active' : '' }}"
            >
                <i class="bi bi-house-door-fill"></i>
                <span>Inicio</span>
            </a>


            {{-- ALTA DE ALUMNOS --}}

            <a
                href="{{ route('soporte.alumnos') }}"
                class="soporte-nav-link {{ request()->routeIs('soporte.alumnos') ? 'active' : '' }}"
            >
                <i class="bi bi-person-plus-fill"></i>
                <span>Alta de Alumnos</span>
            </a>


            {{-- ALTA DE GRUPOS --}}

            <a
                href="{{ route('soporte.grupos.crear') }}"
                class="soporte-nav-link {{ request()->routeIs('soporte.grupos.crear') ? 'active' : '' }}"
            >
                <i class="bi bi-people-fill"></i>
                <span>Alta de Grupos</span>
            </a>


            {{-- ASIGNAR GRUPOS --}}

            <a
                href="{{ route('soporte.grupos.asignar') }}"
                class="soporte-nav-link {{ request()->routeIs('soporte.grupos.asignar') ? 'active' : '' }}"
            >
                <i class="bi bi-diagram-3-fill"></i>
                <span>Asignar Grupos</span>
            </a>


            {{-- PERIODOS --}}

            <a
                href="{{ route('soporte.periodos') }}"
                class="soporte-nav-link {{ request()->routeIs('soporte.periodos') ? 'active' : '' }}"
            >
                <i class="bi bi-calendar3"></i>
                <span>Periodos</span>
            </a>


            {{-- ENCABEZADOS --}}

            <a
                href="{{ route('encabezados.index') }}"
                class="soporte-nav-link {{ request()->routeIs('encabezados.*') ? 'active' : '' }}"
            >
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Encabezados</span>
            </a>


            {{-- FIRMAS DE REPORTES --}}

            <a
                href="{{ route('firmas.index') }}"
                class="soporte-nav-link {{ request()->routeIs('firmas.*') ? 'active' : '' }}"
            >
                <i class="bi bi-pen-fill"></i>
                <span>Firmas reportes</span>
            </a>

        </nav>

    </section>


    {{-- =====================================================
         BIENVENIDA
         ===================================================== --}}

    <section class="soporte-welcome">

        <div class="soporte-welcome-icon">
            <i class="bi bi-person-workspace"></i>
        </div>

        <h2 class="soporte-welcome-title">
            👋 Bienvenido(a), {{ session('user_name', 'Usuario') }}!
        </h2>

        <p class="soporte-welcome-text">
            Desde este panel puedes administrar la información de alumnos,
            grupos, periodos escolares, encabezados y firmas de reportes.
        </p>

    </section>

</div>

@endsection