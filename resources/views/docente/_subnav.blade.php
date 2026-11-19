{{-- ================================================================
     SUBMENÚ / PANEL COMPACTO DEL DOCENTE
     
     Se muestra únicamente en las páginas internas del módulo
     Docente. El Inicio conserva su panel grande independiente.
     ================================================================ --}}

<style>

    /* ============================================================
       CONTENEDOR
       ============================================================ */

    .docente-subnav-wrapper {
    width: 100%;
    max-width: 1320px;
    margin: 12px auto 0;
    padding: 0 12px;
}


    /* ============================================================
       PANEL AZUL
       ============================================================ */

    .docente-subnav {
        position: relative;
        overflow: hidden;

        background:
            linear-gradient(
                135deg,
                #205eaf 0%,
                #174c9b 48%,
                #0b3270 100%
            );

        border-radius: 18px;

        padding: 10px 14px;

        box-shadow:
            0 10px 28px rgba(23,76,155,.20);

        display: flex;
        align-items: center;

        gap: 10px;

        min-height: 72px;
    }


    /* ============================================================
       DECORACIÓN
       ============================================================ */

    .docente-subnav::before {

        content: "";

        position: absolute;

        width: 260px;
        height: 260px;

        border-radius: 50%;

        background:
            rgba(255,255,255,.045);

        top: -190px;
        right: 80px;

        pointer-events: none;
    }


    .docente-subnav::after {

        content: "";

        position: absolute;

        width: 180px;
        height: 180px;

        border-radius: 50%;

        background:
            rgba(45,131,255,.08);

        bottom: -150px;
        right: -40px;

        pointer-events: none;
    }


    /* ============================================================
       MENÚ
       ============================================================ */

    .docente-subnav-menu {

        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;

        gap: 8px;

        flex: 1;

        min-width: 0;
    }


    .docente-subnav-link {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        min-height: 50px;

        padding: 0 24px;

        border:
            1px solid rgba(114,180,255,.38);

        border-radius: 11px;

        background:
            rgba(11,50,112,.30);

        color:
            #ffffff;

        text-decoration: none;

        font-size:
            .92rem;

        font-weight:
            700;

        white-space:
            nowrap;

        transition:
            background .2s ease,
            border-color .2s ease,
            box-shadow .2s ease,
            transform .2s ease;
    }


    .docente-subnav-link i {

        font-size:
            1rem;

        margin-right:
            8px;
    }


    .docente-subnav-link:hover {

        color:
            #ffffff;

        background:
            rgba(45,131,255,.35);

        border-color:
            rgba(114,180,255,.75);

        box-shadow:
            0 0 12px rgba(45,131,255,.25);

        transform:
            translateY(-1px);
    }


    /* ============================================================
       OPCIÓN ACTIVA
       ============================================================ */

    .docente-subnav-link.active {

        color:
            #ffffff;

        background:
            linear-gradient(
                135deg,
                #2d8df5,
                #1769df
            );

        border-color:
            #63adff;

        box-shadow:
            0 0 16px rgba(45,131,255,.55),
            inset 0 1px 0 rgba(255,255,255,.20);
    }


    /* ============================================================
       PERIODO
       ============================================================ */

    .docente-subnav-periodo {

        position: relative;
        z-index: 2;

        min-width: 245px;

        padding:
            4px 10px 4px 18px;

        border-left:
            1px solid rgba(255,255,255,.22);

        display: flex;

        flex-direction: column;

        justify-content: center;

        align-items: flex-start;
    }


    .docente-subnav-periodo-content {

        display: flex;

        align-items: center;
    }


    /* ============================================================
       ICONO DEL PERIODO
       ============================================================ */

    .docente-subnav-periodo-icon {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 38px;
        height: 38px;

        margin-right:
            10px;

        border-radius:
            9px;

        border:
            1px solid rgba(114,180,255,.45);

        background:
            rgba(255,255,255,.08);

        color:
            #ffffff;

        flex-shrink: 0;
    }


    /* ============================================================
       TEXTO DEL PERIODO
       ============================================================ */

    .docente-subnav-periodo-label {

        color:
            #b9d8ff;

        font-size:
            .70rem;

        font-weight:
            700;

        letter-spacing:
            .04em;

        line-height:
            1.2;

        text-transform:
            uppercase;

        margin-bottom:
            2px;
    }


    .docente-subnav-periodo-nombre {

        color:
            #ffffff;

        font-size:
            1.05rem;

        font-weight:
            800;

        line-height:
            1.2;

        white-space:
            nowrap;
    }


    /* ============================================================
       SIN PERIODO
       ============================================================ */

    .docente-subnav-periodo-sin {

        color:
            rgba(255,255,255,.75);

        font-size:
            .85rem;

        font-weight:
            600;
    }


    /* ============================================================
       TABLET
       ============================================================ */

    @media (max-width: 1100px) {

        .docente-subnav-link {

            padding:
                0 15px;

            font-size:
                .86rem;
        }


        .docente-subnav-periodo {

            min-width:
                210px;
        }


        .docente-subnav-periodo-nombre {

            font-size:
                .95rem;
        }

    }


    /* ============================================================
       PANTALLAS MEDIANAS
       ============================================================ */

    @media (max-width: 900px) {

        .docente-subnav {

            flex-wrap:
                wrap;

            padding:
                10px;
        }


        .docente-subnav-menu {

            width:
                100%;

            flex-wrap:
                wrap;
        }


        .docente-subnav-periodo {

            width:
                100%;

            min-width:
                0;

            border-left:
                0;

            border-top:
                1px solid rgba(255,255,255,.18);

            padding:
                10px 8px 4px;
        }

    }


    /* ============================================================
       CELULAR
       ============================================================ */

    @media (max-width: 576px) {

        .docente-subnav-wrapper {

            padding:
                0 10px;

            margin-top:
                12px;
        }


        .docente-subnav {

            border-radius:
                14px;

            padding:
                8px;

            gap:
                6px;
        }


        .docente-subnav-menu {

            display:
                grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap:
                6px;
        }


        .docente-subnav-link {

            width:
                100%;

            min-height:
                44px;

            padding:
                0 8px;

            font-size:
                .78rem;
        }


        .docente-subnav-link i {

            margin-right:
                5px;

            font-size:
                .85rem;
        }


        .docente-subnav-periodo {

            padding-top:
                10px;
        }


        .docente-subnav-periodo-content {

            width:
                100%;
        }

    }

</style>


{{-- ================================================================
     PANEL
     ================================================================ --}}

<div class="docente-subnav-wrapper">

    <nav class="docente-subnav">


        {{-- ========================================================
             OPCIONES DEL DOCENTE
             ======================================================== --}}

        <div class="docente-subnav-menu">


            {{-- ====================================================
                 INICIO
                 ==================================================== --}}

            <a
                href="{{ route('docente.index') }}"
                class="docente-subnav-link
                    {{ request()->routeIs('docente.index') ? 'active' : '' }}"
            >

                <i class="bi bi-house-fill"></i>

                Inicio

            </a>


            {{-- ====================================================
                 AGENDAR TUTORÍA
                 ==================================================== --}}

            <a
                href="{{ route('docente.tutorias') }}"
                class="docente-subnav-link
                    {{ request()->routeIs('docente.tutorias') ? 'active' : '' }}"
            >

                <i class="bi bi-calendar-plus-fill"></i>

                Agendar Tutoría

            </a>


            {{-- ====================================================
                 GESTIONAR CANALIZACIONES
                 ==================================================== --}}

            <a
                href="{{ route('docente.canalizaciones') }}"
                class="docente-subnav-link
                    {{ request()->routeIs('docente.canalizaciones*') ? 'active' : '' }}"
            >

                <i class="bi bi-people-fill"></i>

                Gestionar Canalizaciones

            </a>


            {{-- ====================================================
                 PERFIL
                 ==================================================== --}}

            <a
                href="{{ route('docente.perfil.view') }}"
                class="docente-subnav-link
                    {{ request()->routeIs('docente.perfil*') ? 'active' : '' }}"
            >

                <i class="bi bi-person-circle"></i>

                Perfil

            </a>


        </div>


        {{-- ========================================================
             CICLO ESCOLAR ACTUAL
             ======================================================== --}}
<div class="docente-subnav-periodo">

    @if($periodoActual)

        <div>
            <span class="docente-subnav-periodo-label">
                Ciclo escolar actual
            </span>

            <span class="docente-subnav-periodo-nombre">
                {{ $periodoActual->nombre }}
            </span>
        </div>

    @else

        <span class="docente-subnav-periodo-label">
            No hay un ciclo escolar activo.
        </span>

    @endif

</div>
            </div>


    </nav>

</div>