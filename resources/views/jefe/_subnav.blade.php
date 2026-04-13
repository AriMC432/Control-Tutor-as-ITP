@section('subnav')

    {{-- 1. INICIO --}}
    <li class="nav-item">
        <a href="{{ route('jefe.index') }}" class="nav-link {{ request()->routeIs('jefe.index') ? 'active' : '' }}">
            Inicio
        </a>
    </li>

    {{-- 2. ALTA DE ALUMNOS --}}
    <li class="nav-item">
        <a href="{{ route('jefe.alumnos') }}" class="nav-link {{ request()->routeIs('jefe.alumnos') ? 'active' : '' }}">
            Alta de Alumnos
        </a>
    </li>

    {{-- 4. ALTA DE USUARIOS --}}
    <li class="nav-item">
        <a href="{{ route('jefe.usuarios') }}" class="nav-link {{ request()->routeIs('jefe.usuarios') ? 'active' : '' }}">
            Alta de Usuarios
        </a>
    </li>

    {{-- 5. ALTA DE GRUPOS (Ruta Específica) --}}
    <li class="nav-item">
        <a href="{{ route('jefe.grupos.crear') }}" class="nav-link {{ request()->routeIs('jefe.grupos.crear') ? 'active' : '' }}">
            Alta de Grupos
        </a>
    </li>

    {{-- 6. ASIGNAR GRUPOS (Ruta Específica) --}}
    <li class="nav-item">
        <a href="{{ route('jefe.grupos.asignar') }}" class="nav-link {{ request()->routeIs('jefe.grupos.asignar') ? 'active' : '' }}">
            Asignar Grupos
        </a>
    </li>

    {{-- 7. PERIODOS (SECCIÓN AGREGADA) --}}
    <li class="nav-item">
        <a href="{{ route('jefe.periodos') }}" class="nav-link {{ request()->routeIs('jefe.periodos') ? 'active' : '' }}">
            Periodos
        </a>
        </li>
        {{-- 8. Crear docente (SECCIÓN AGREGADA) --}}
        <li class="nav-item">
            <a href="{{ route('jefe.alta_docente') }}"
                class="nav-link {{ request()->routeIs('jefe.docentes.crear') ? 'active' : '' }}">
                Crear Docente
            </a>
        </li>

    {{-- 9. MI PERFIL --}}
    <li class="nav-item">
        <a href="{{ route('jefe.perfil.view') }}" class="nav-link {{ request()->routeIs('jefe.perfil.view') ? 'active' : '' }}">
            <i class="bi bi-person-circle me-1"></i> Mi Perfil
        </a>
    </li>

    {{-- ÁREA DERECHA --}}
    <li class="nav-item ms-auto d-flex align-items-center gap-3" id="li-logout-jefe">
        @if(session('user_name'))
            <span class="text-white fw-semibold d-none d-md-block">
                {{ session('user_name') }}
            </span>
        @endif

        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm fw-bold text-white px-5 rounded-pill shadow-sm" style="border: none;">
                <i class="bi bi-box-arrow-right me-1"></i> Salir
            </button>
        </form>
    </li>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var logoutItem = document.getElementById('li-logout-jefe');
            if (logoutItem) {
                var parentUl = logoutItem.closest('ul');
                if (parentUl) { parentUl.style.width = '100%'; }
            }
        });
    </script>

@endsection