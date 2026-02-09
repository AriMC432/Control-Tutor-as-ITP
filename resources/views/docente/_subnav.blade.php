@section('subnav')

    {{-- ENLACES DEL DOCENTE --}}
    <li class="nav-item">
        <a href="{{ route('docente.index') }}" class="nav-link {{ request()->routeIs('docente.index') ? 'active' : '' }}">
            Inicio
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('docente.tutorias') }}" class="nav-link {{ request()->routeIs('docente.tutorias') ? 'active' : '' }}">
            Agendar Tutoría
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('docente.canalizaciones') }}" class="nav-link {{ request()->routeIs('docente.canalizaciones') ? 'active' : '' }}">
            Gestionar Canalizaciones
        </a>
    </li>
    
    {{-- === NUEVO: MI PERFIL === --}}
    <li class="nav-item">
        <a href="{{ route('docente.perfil.view') }}" class="nav-link {{ request()->routeIs('docente.perfil.view') ? 'active' : '' }}">
            <i class="bi bi-person-circle me-1"></i> Mi Perfil
        </a>
    </li>

    {{-- ÁREA DERECHA: NOMBRE Y LOGOUT --}}
    <li class="nav-item ms-auto d-flex align-items-center gap-3" id="li-logout-docente">
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

    {{-- SCRIPT VISUAL --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var logoutItem = document.getElementById('li-logout-docente');
            if (logoutItem) {
                var parentUl = logoutItem.closest('ul');
                if (parentUl) { parentUl.style.width = '100%'; }
            }
        });
    </script>
@endsection