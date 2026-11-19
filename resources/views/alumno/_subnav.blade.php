{{-- =========================================================
     MENÚ DE NAVEGACIÓN DEL ALUMNO
     
     IMPORTANTE:
     El nombre del usuario y "Cerrar sesión" YA NO VAN AQUÍ.

     Ahora están en el encabezado principal de:
     
     layouts/app.blade.php

     De esta manera evitamos:
     - Nombre duplicado
     - Botón Salir duplicado
     - Menú encimado
     - Elementos fuera de lugar
     ========================================================= --}}


@section('subnav')


    {{-- =====================================================
         INICIO
         ===================================================== --}}

    <li class="nav-item alumno-nav-item">

        <a
            href="{{ route('alumno.index') }}"
            class="nav-link alumno-nav-link
                {{ request()->routeIs('alumno.index') ? 'active' : '' }}"
        >

            <i class="bi bi-house-door-fill nav-icon"></i>

            <span>
                Inicio
            </span>

        </a>

    </li>


    {{-- =====================================================
         MIS TUTORÍAS
         ===================================================== --}}

    <li class="nav-item alumno-nav-item">

        <a
            href="{{ route('alumno.tutorias') }}"
            class="nav-link alumno-nav-link
                {{ request()->routeIs('alumno.tutorias') ? 'active' : '' }}"
        >

            <i class="bi bi-calendar-check-fill nav-icon"></i>

            <span>
                Mis tutorías
            </span>

        </a>

    </li>


    {{-- =====================================================
         CANALIZACIONES
         ===================================================== --}}

    <li class="nav-item alumno-nav-item">

        <a
            href="{{ route('alumno.canalizaciones') }}"
            class="nav-link alumno-nav-link
                {{ request()->routeIs('alumno.canalizaciones') ? 'active' : '' }}"
        >

            <i class="bi bi-people-fill nav-icon"></i>

            <span>
                Canalizaciones
            </span>

        </a>

    </li>
{{-- ASESORÍAS --}}
        <li class="nav-item">
            <a href="{{ route('alumno.asesorias') }}"
               class="nav-link {{ request()->routeIs('alumno.asesorias') ? 'active' : '' }}">

                <i class="bi bi-journal-check me-2"></i>
                Asesorías

            </a>
        </li>

    {{-- =====================================================
         PERFIL
         ===================================================== --}}

    <li class="nav-item alumno-nav-item">

        <a
            href="{{ route('alumno.perfil') }}"
            class="nav-link alumno-nav-link
                {{ request()->routeIs('alumno.perfil') ? 'active' : '' }}"
        >

            <i class="bi bi-person-circle nav-icon"></i>

            <span>
                Perfil
            </span>

        </a>

    </li>


@endsection