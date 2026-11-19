{{-- =========================================================
     MENÚ DE NAVEGACIÓN DEL COORDINADOR INSTITUCIONAL

     IMPORTANTE:
     El nombre del usuario y "Cerrar sesión" NO VAN AQUÍ.

     Se manejan desde:
         layouts/app.blade.php

     Esto evita:
     - Nombre duplicado
     - Botón Salir duplicado
     - Menú encimado
     - Elementos fuera de lugar
     ========================================================= --}}


@section('subnav')


    {{-- =====================================================
         INICIO
         ===================================================== --}}

    <li class="nav-item coordinst-nav-item">

        <a
            href="{{ route('coordinst.index') }}"
            class="nav-link coordinst-nav-link
                {{ request()->routeIs('coordinst.index') ? 'active' : '' }}"
        >

            <i class="bi bi-house-door-fill nav-icon"></i>

            <span>
                Inicio
            </span>

        </a>

    </li>


    {{-- =====================================================
         ESTUDIANTES
         ===================================================== --}}

    <li class="nav-item coordinst-nav-item">

        <a
            href="{{ route('coordinst.estudiantes') }}"
            class="nav-link coordinst-nav-link
                {{ request()->routeIs('coordinst.estudiantes') ? 'active' : '' }}"
        >

            <i class="bi bi-people-fill nav-icon"></i>

            <span>
                Estudiantes
            </span>

        </a>

    </li>


    {{-- =====================================================
         DOCENTES
         ===================================================== --}}

    <li class="nav-item coordinst-nav-item">

        <a
            href="{{ route('coordinst.docentes') }}"
            class="nav-link coordinst-nav-link
                {{ request()->routeIs('coordinst.docentes') ? 'active' : '' }}"
        >

            <i class="bi bi-person-badge-fill nav-icon"></i>

            <span>
                Docentes
            </span>

        </a>

    </li>


    {{-- =====================================================
         TUTORÍAS
         ===================================================== --}}

    <li class="nav-item coordinst-nav-item">

        <a
            href="{{ route('coordinst.tutorias') }}"
            class="nav-link coordinst-nav-link
                {{ request()->routeIs('coordinst.tutorias') ? 'active' : '' }}"
        >

            <i class="bi bi-calendar-check-fill nav-icon"></i>

            <span>
                Tutorías
            </span>

        </a>

    </li>


    {{-- =====================================================
         CANALIZACIONES
         ===================================================== --}}

    <li class="nav-item coordinst-nav-item">

        <a
            href="{{ route('coordinst.canalizaciones') }}"
            class="nav-link coordinst-nav-link
                {{ request()->routeIs('coordinst.canalizaciones') ? 'active' : '' }}"
        >

            <i class="bi bi-send-fill nav-icon"></i>

            <span>
                Canalizaciones
            </span>

        </a>

    </li>


    {{-- =====================================================
         PERFIL
         ===================================================== --}}

    <li class="nav-item coordinst-nav-item">

        <a
            href="{{ route('coordinst.perfil.view') }}"
            class="nav-link coordinst-nav-link
                {{ request()->routeIs('coordinst.perfil.view') ? 'active' : '' }}"
        >

            <i class="bi bi-person-circle nav-icon"></i>

            <span>
                Perfil
            </span>

        </a>

    </li>


@endsection