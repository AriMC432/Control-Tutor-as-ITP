@section('subnav')
    
    {{-- PESTAÑAS DE NAVEGACIÓN (Izquierda) --}}
    <li class="nav-item">
        <a href="{{ route('alumno.index') }}" class="nav-link {{ request()->routeIs('alumno.index') ? 'active' : '' }}">
            Inicio
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('alumno.tutorias') }}" class="nav-link {{ request()->routeIs('alumno.tutorias') ? 'active' : '' }}">
            Mis tutorías
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('alumno.canalizaciones') }}" class="nav-link {{ request()->routeIs('alumno.canalizaciones') ? 'active' : '' }}">
            Canalizaciones
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('alumno.perfil') }}" class="nav-link {{ request()->routeIs('alumno.perfil') ? 'active' : '' }}">
            Perfil
        </a>
    </li>

    {{-- ÁREA DERECHA: Nombre y Botón de Salir --}}
    <li class="nav-item ms-auto d-flex align-items-center gap-3" id="li-logout">
        
        {{-- Nombre del usuario (Solo visible en pantallas medianas o grandes) --}}
        @if(session('user_name'))
            <span class="text-white fw-semibold d-none d-md-block">
                {{ session('user_name') }}
            </span>
        @endif

        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            {{-- Botón Rojo y Ancho --}}
            <button type="submit" class="btn btn-danger btn-sm fw-bold text-white px-5 rounded-pill shadow-sm" style="border: none;">
                <i class="bi bi-box-arrow-right me-1"></i> Salir
            </button>
        </form>
    </li>

    {{-- SCRIPT DE AJUSTE VISUAL (Mantiene todo a la derecha) --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var logoutItem = document.getElementById('li-logout');
            if (logoutItem) {
                var parentUl = logoutItem.closest('ul');
                if (parentUl) {
                    parentUl.style.width = '100%';
                }
            }
        });
    </script>

@endsection