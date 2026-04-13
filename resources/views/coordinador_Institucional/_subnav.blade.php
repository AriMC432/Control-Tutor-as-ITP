@section('subnav')

    {{-- === ENLACES DEL COORDINADOR INSTITUCIONAL === --}}
    <li class="nav-item">
        <a href="{{ route('coordinst.index') }}" class="nav-link {{ request()->routeIs('coordinst.index') ? 'active' : '' }}">
            Inicio
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('coordinst.estudiantes') }}" class="nav-link {{ request()->routeIs('coordinst.estudiantes') ? 'active' : '' }}">
            Estudiantes
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('coordinst.docentes') }}" class="nav-link {{ request()->routeIs('coordinst.docentes') ? 'active' : '' }}">
            Docentes
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('coordinst.tutorias') }}" class="nav-link {{ request()->routeIs('coordinst.tutorias') ? 'active' : '' }}">
            Tutorías
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('coordinst.canalizaciones') }}" class="nav-link {{ request()->routeIs('coordinst.canalizaciones') ? 'active' : '' }}">
            Canalizaciones
        </a>
    </li>

    {{-- === MI PERFIL === --}}
    <li class="nav-item">
        <a href="{{ route('coordinst.perfil.view') }}" class="nav-link {{ request()->routeIs('coordinst.perfil.view') ? 'active' : '' }}">
            <i class="bi bi-person-circle me-1"></i> Mi Perfil
        </a>
    </li>

    {{-- === ÁREA DERECHA: NOMBRE Y LOGOUT === --}}
    <li class="nav-item ms-auto d-flex align-items-center gap-3" id="li-logout-coordinst">
        
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
            var logoutItem = document.getElementById('li-logout-coordinst');
            if (logoutItem) {
                var parentUl = logoutItem.closest('ul');
                if (parentUl) {
                    parentUl.style.width = '100%';
                }
            }
        });
    </script>

@endsection