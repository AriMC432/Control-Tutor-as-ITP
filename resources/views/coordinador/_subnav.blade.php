{{-- =========================================================
     MENÚ DE NAVEGACIÓN DEL COORDINADOR

     Este archivo contiene únicamente la navegación
     propia del Coordinador.
     El usuario y cerrar sesión permanecen en layouts/app.blade.php.
     ========================================================= --}}

<style>

    /* =========================================================
       CONTENEDOR DEL SUBNAV
       ========================================================= */

.coordinador-subnav-wrapper {
    width: 100%;
    max-width: 1520px;
    margin: 0 auto 18px;
    padding: 0;
}

/* =========================================================
   PANEL AZUL
   ========================================================= */

.coordinador-subnav {
    width: 100%;

    min-height: 92px;

    padding: 16px 20px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            #2057a4 0%,
            #16468d 48%,
            #0b326f 100%
        );

    box-shadow:
        0 12px 28px rgba(20, 62, 120, .22);

    position: relative;
    overflow: hidden;

    margin: 18px auto 0;
}

    /* =========================================================
       DECORACIÓN
       ========================================================= */

    .coordinador-subnav::before {
        content: "";

        position: absolute;

        width: 500px;
        height: 250px;

        top: -180px;
        left: 25%;

        border-radius: 50%;

        background: rgba(63, 139, 255, .14);

        pointer-events: none;
    }


    .coordinador-subnav::after {
        content: "";

        position: absolute;

        width: 400px;
        height: 230px;

        right: -180px;
        top: -80px;

        border-radius: 50%;

        background: rgba(44, 117, 235, .12);

        pointer-events: none;
    }


    /* =========================================================
       LISTA DE OPCIONES
       ========================================================= */

    .coordinador-subnav-list {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;

        gap: 9px;

        margin: 0;
        padding: 0;

        list-style: none;

        flex-wrap: nowrap;
    }


    /* =========================================================
       BOTONES
       ========================================================= */

    .coordinador-nav-link {

        min-width: 145px;

        height: 50px;

        padding: 0 20px;

        display: flex;
        align-items: center;
        justify-content: center;

        gap: 9px;

        border-radius: 11px;

        border: 1px solid rgba(99,173,255,.55);

        background: rgba(25,84,160,.34);

        color: #ffffff !important;

        text-decoration: none;

        font-size: .95rem;
        font-weight: 700;

        white-space: nowrap;

        transition: all .22s ease;
    }


    .coordinador-nav-link .nav-icon {
        font-size: 1rem;
    }


    /* =========================================================
       HOVER
       ========================================================= */

    .coordinador-nav-link:hover {

        color: #ffffff !important;

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


    /* =========================================================
       OPCIÓN ACTIVA
       ========================================================= */

    .coordinador-nav-link.active {

        color: #ffffff !important;

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


    /* =========================================================
       CICLO ESCOLAR
       ========================================================= */

    .coordinador-subnav-periodo {

        position: relative;
        z-index: 2;

        min-width: 300px;

        padding-left: 25px;

        border-left:
            1px solid rgba(255,255,255,.28);

        display: flex;
        align-items: center;
        justify-content: flex-end;
    }


    .coordinador-subnav-periodo-text {

        display: flex;
        flex-direction: column;

        align-items: flex-start;
    }


    .coordinador-subnav-periodo-label {

        color: rgba(255,255,255,.80);

        font-size: .78rem;

        font-weight: 500;

        text-transform: uppercase;

        letter-spacing: 1px;

        margin-bottom: 5px;
    }


    .coordinador-subnav-periodo-name {

        color: #ffffff;

        font-size: 1.35rem;

        font-weight: 800;

        line-height: 1.1;

        white-space: nowrap;
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 1100px) {

        .coordinador-subnav {
            overflow-x: auto;
        }

        .coordinador-subnav-list {
            overflow-x: auto;
        }

        .coordinador-subnav-periodo {
            min-width: 250px;
        }

    }


    @media (max-width: 768px) {

        .coordinador-subnav-wrapper {
            padding: 0 10px;
        }

        .coordinador-subnav {
            padding: 14px;
        }

        .coordinador-nav-link {
            min-width: 135px;
        }

        .coordinador-subnav-periodo {
            min-width: 220px;
        }

    }

</style>


{{-- =========================================================
     PANEL DE NAVEGACIÓN
     ========================================================= --}}

<div class="coordinador-subnav-wrapper">

    <nav class="coordinador-subnav">


        {{-- =================================================
             OPCIONES
             ================================================= --}}

        <ul class="coordinador-subnav-list">


            {{-- INICIO --}}
            <li class="nav-item">

                <a
                    href="{{ route('coord.index') }}"
                    class="coordinador-nav-link
                        {{ request()->routeIs('coord.index') ? 'active' : '' }}"
                >

                    <i class="bi bi-house-door-fill nav-icon"></i>

                    <span>
                        Inicio
                    </span>

                </a>

            </li>


            {{-- SEGUIMIENTO A TUTORES --}}
            <li class="nav-item">

                <a
                    href="{{ route('coord.seguimiento') }}"
                    class="coordinador-nav-link
                        {{ request()->routeIs('coord.seguimiento') ? 'active' : '' }}"
                >

                    <i class="bi bi-people-fill nav-icon"></i>

                    <span>
                        Seguimiento a tutores
                    </span>

                </a>

            </li>


            {{-- INFORMES --}}
            <li class="nav-item">

                <a
                    href="{{ route('coord.informes') }}"
                    class="coordinador-nav-link
                        {{ request()->routeIs('coord.informes') ? 'active' : '' }}"
                >

                    <i class="bi bi-file-earmark-text-fill nav-icon"></i>

                    <span>
                        Informes
                    </span>

                </a>

            </li>


            {{-- REPORTES --}}
            <li class="nav-item">

                <a
                    href="{{ route('coord.reportes') }}"
                    class="coordinador-nav-link
                        {{ request()->routeIs('coord.reportes') ? 'active' : '' }}"
                >

                    <i class="bi bi-bar-chart-fill nav-icon"></i>

                    <span>
                        Reportes
                    </span>

                </a>

            </li>


            {{-- MI PERFIL --}}
            <li class="nav-item">

                <a
                    href="{{ route('coordinador.perfil.view') }}"
                    class="coordinador-nav-link
                        {{ request()->routeIs('coordinador.perfil.view') ? 'active' : '' }}"
                >

                    <i class="bi bi-person-circle nav-icon"></i>

                    <span>
                        Perfil
                    </span>

                </a>

            </li>


        </ul>


        {{-- =================================================
             CICLO ESCOLAR
             ================================================= --}}

        <div class="coordinador-subnav-periodo">

            <div class="coordinador-subnav-periodo-text">

                <span class="coordinador-subnav-periodo-label">
                    Ciclo escolar actual
                </span>

                <span class="coordinador-subnav-periodo-name">

                    @if(isset($periodoActivo) && $periodoActivo)

                        {{ $periodoActivo->nombre }}

                    @elseif(isset($periodoActual) && $periodoActual)

                        {{ $periodoActual->nombre }}

                    @else

                        Sin periodo activo

                    @endif

                </span>

            </div>

        </div>


    </nav>

</div>