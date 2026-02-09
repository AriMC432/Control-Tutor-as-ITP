@section('subnav')

    {{-- === ENLACES DEL COORDINADOR === --}}
    <li class="nav-item">
        <a href="{{ route('coord.index') }}" class="nav-link {{ request()->routeIs('coord.index') ? 'active' : '' }}">
            Inicio
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('coord.seguimiento') }}" class="nav-link {{ request()->routeIs('coord.seguimiento') ? 'active' : '' }}">
            Seguimiento a tutores
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('coord.informes') }}" class="nav-link {{ request()->routeIs('coord.informes') ? 'active' : '' }}">
            Informes
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('coord.reportes') }}" class="nav-link {{ request()->routeIs('coord.reportes') ? 'active' : '' }}">
            Reportes
        </a>
    </li>

    {{-- === NUEVO: MI PERFIL === --}}
    <li class="nav-item">
        <a href="{{ route('coordinador.perfil.view') }}" class="nav-link {{ request()->routeIs('coordinador.perfil.view') ? 'active' : '' }}">
            <i class="bi bi-person-circle me-1"></i> Mi Perfil
        </a>
    </li>

    {{-- === ÁREA DERECHA: NOMBRE Y LOGOUT === --}}
    {{-- Usamos ms-auto y el mismo estilo que en Alumno --}}
    <li class="nav-item ms-auto d-flex align-items-center gap-3" id="li-logout-coord">
        
        {{-- Nombre del usuario --}}
        @if(session('user_name'))
            <span class="text-white fw-semibold d-none d-md-block">
                {{ session('user_name') }}
            </span>
        @endif

        {{-- Botón Rojo Ancho --}}
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm fw-bold text-white px-5 rounded-pill shadow-sm" style="border: none;">
                <i class="bi bi-box-arrow-right me-1"></i> Salir
            </button>
        </form>
    </li>

    {{-- SCRIPT VISUAL --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Usamos un ID específico para el coordinador por si acaso
            var logoutItem = document.getElementById('li-logout-coord');
            if (logoutItem) {
                var parentUl = logoutItem.closest('ul');
                if (parentUl) {
                    parentUl.style.width = '100%';
                }
            }
        });
    </script>

@endsection