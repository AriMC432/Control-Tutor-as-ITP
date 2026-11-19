
@section('subnav')

<style>
    /* =========================================================
       MENÚ DE NAVEGACIÓN DEL JEFE DE DEPARTAMENTO
       ========================================================= */

    .jefe-subnav {
        display: flex;

        /* Mantiene los botones y el periodo en una sola línea */
        flex-wrap: nowrap;

        align-items: center;

        /* Reduce el espacio entre botones */
        gap: 6px;

        /* Reduce el espacio vertical del menú */
        padding: 8px 0;

        width: 100%;

        box-sizing: border-box;

        /* Permite desplazamiento horizontal si no cabe */
        overflow-x: auto;
        overflow-y: hidden;

        /* Evita que el contenido se comprima */
        white-space: nowrap;
    }


    /* =========================================================
       BOTONES DEL MENÚ
       ========================================================= */

    .jefe-subnav .jefe-link {
        display: inline-flex;

        justify-content: center;
        align-items: center;

        /* Reduce la altura de los botones */
        min-height: 38px;

        /* Reduce el espacio interno */
        padding: 12px 15px;

        /* Borde más delgado */
        border: 1px solid rgba(164, 207, 255, .25);

        /* Bordes menos redondeados */
        border-radius: 6px;

        background: rgba(40, 91, 151, .48);

        color: #fff;

        font-weight: 600;

        /* Texto ligeramente más pequeño */
        font-size: 12px;

        text-decoration: none;

        text-align: center;

        /* Evita que el texto del botón se divida */
        white-space: nowrap;

        /* Evita que los botones se hagan más pequeños */
        flex: 0 0 auto;

        box-sizing: border-box;

        transition:
            background .2s ease,
            border-color .2s ease,
            transform .2s ease;
    }


    /* =========================================================
       EFECTO AL PASAR EL CURSOR
       ========================================================= */

    .jefe-subnav .jefe-link:hover {
        background: #258ce5;

        border-color: #70c4ff;

        color: #fff;

        transform: translateY(-1px);
    }


    /* =========================================================
       BOTÓN DE LA SECCIÓN ACTUAL
       ========================================================= */

    .jefe-subnav .jefe-link.active {
        background: linear-gradient(
            135deg,
            #36a0f5,
            #1676d2
        );

        border-color: #72c7ff;

        box-shadow: 0 0 8px rgba(64, 170, 255, .25);
    }


    /* =========================================================
       CONTENEDOR DEL PERIODO ACTUAL
       ========================================================= */

    .jefe-subnav .jefe-periodo {
        /* Coloca el periodo hacia la derecha */
        margin-left: auto;

        /* Evita que se comprima */
        flex: 0 0 auto;

        /* Reduce el ancho mínimo */
        min-width: 160px;

        /* Reduce el espacio interno */
        padding: 5px 12px;

        color: #fff;

        text-align: center;

        border-left: 1px solid rgba(255, 255, 255, .25);

        box-sizing: border-box;
    }


    /* =========================================================
       TEXTO CICLO ESCOLAR ACTUAL
       ========================================================= */

    .jefe-subnav .jefe-periodo small {
        display: block;

        margin-bottom: 2px;

        color: #d4e7ff;

        font-size: 10px;

        font-weight: 700;

        letter-spacing: .3px;
    }


    /* =========================================================
       NOMBRE DEL PERIODO
       ========================================================= */

    .jefe-subnav .jefe-periodo strong {
        display: block;

        font-size: 13px;

        font-weight: 700;

        white-space: nowrap;
    }


    /* =========================================================
       PANTALLAS MEDIANAS
       ========================================================= */

    @media (max-width: 1250px) {

        .jefe-subnav {
            gap: 5px;
        }

        .jefe-subnav .jefe-link {
            padding: 7px 10px;
            font-size: 11px;
        }

        .jefe-subnav .jefe-periodo {
            min-width: 145px;
            padding: 5px 8px;
        }

        .jefe-subnav .jefe-periodo strong {
            font-size: 12px;
        }
    }


    /* =========================================================
       PANTALLAS PEQUEÑAS
       ========================================================= */

    @media (max-width: 700px) {

        .jefe-subnav {
            gap: 5px;
            padding: 6px 0;
        }

        .jefe-subnav .jefe-link {
            min-height: 34px;
            padding: 6px 9px;
            font-size: 11px;
        }

        .jefe-subnav .jefe-periodo {
            min-width: 135px;
            padding: 4px 8px;
        }

        .jefe-subnav .jefe-periodo small {
            font-size: 9px;
        }

        .jefe-subnav .jefe-periodo strong {
            font-size: 11px;
        }
    }

</style>


@php

    /*
    |--------------------------------------------------------------------------
    | Obtener el periodo escolar activo
    |--------------------------------------------------------------------------
    |
    | Consulta directamente el periodo registrado en la base de datos.
    | Utiliza el scope actual() definido en el modelo Periodo.
    |
    | Esto permite que el menú funcione aunque el controlador de la
    | sección no envíe las variables $periodoActivo o $periodoActual.
    |
    */

    $periodoMenu = \App\Models\Periodo::actual()->first();

@endphp


{{-- =========================================================
     MENÚ DE NAVEGACIÓN
     ========================================================= --}}

<nav class="jefe-subnav" aria-label="Menú de Jefe Departamental">


    {{-- INICIO --}}

    <a href="{{ route('jefe.index') }}"
       class="jefe-link {{ request()->routeIs('jefe.index') ? 'active' : '' }}">

        Inicio

    </a>


    {{-- ALTA DE USUARIOS --}}

    <a href="{{ route('jefe.usuarios') }}"
       class="jefe-link {{ request()->routeIs('jefe.usuarios') || request()->routeIs('jefe.docentes') || request()->routeIs('jefe.alta_docente') ? 'active' : '' }}">

        Alta de Usuarios

    </a>


    {{-- ALTA DE GRUPOS --}}

    <a href="{{ route('jefe.grupos.crear') }}"
       class="jefe-link {{ request()->routeIs('jefe.grupos.crear') ? 'active' : '' }}">

        Alta de Grupos

    </a>


    {{-- ASIGNACIÓN DE GRUPOS --}}

    <a href="{{ route('jefe.grupos.asignar') }}"
       class="jefe-link {{ request()->routeIs('jefe.grupos.asignar') || request()->routeIs('jefe.grupos') ? 'active' : '' }}">

        Asignación de Grupos

    </a>


    {{-- ALTA DE ALUMNOS --}}

    <a href="{{ route('jefe.alumnos') }}"
       class="jefe-link {{ request()->routeIs('jefe.alumnos') ? 'active' : '' }}">

        Alta de Alumnos

    </a>


    {{-- MI PERFIL --}}

    <a href="{{ route('jefe.perfil.view') }}"
       class="jefe-link {{ request()->routeIs('jefe.perfil.*') ? 'active' : '' }}">

        Mi Perfil

    </a>


    {{-- ENCABEZADOS --}}

    <a href="{{ route('encabezados.index') }}"
       class="jefe-link {{ request()->routeIs('encabezados.*') ? 'active' : '' }}">

        Encabezados

    </a>


    {{-- GESTIÓN DE ASESORÍAS --}}

    <a href="{{ route('jefe.asesorias') }}"
       class="jefe-link {{ request()->routeIs('jefe.asesorias') ? 'active' : '' }}">

        Gestión de Asesorías

    </a>


    {{-- =====================================================
         PERIODO ACTUAL
         ===================================================== --}}

  <div class="jefe-periodo">

    <small>CICLO ESCOLAR ACTUAL</small>

    <strong>
        {{ $periodoMenu->nombre ?? 'Sin periodo activo' }}
    </strong>

</div>


</nav>

@endsection
