@section('subnav')
    
    <li class="nav-item">
        <a href="{{ route('superadmin.index') }}" class="nav-link {{ request()->routeIs('superadmin.index') ? 'active' : '' }}">
            Inicio
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('superadmin.create_docente') }}" class="nav-link {{ request()->routeIs('superadmin.create_docente') ? 'active' : '' }}">
            Alta de Usuarios
        </a>
    </li>

    {{-- Botón Salir --}}
    <li class="nav-item ms-auto d-flex align-items-center gap-3" id="li-logout-admin">
        @if(session('user_name'))
            <span class="text-white fw-semibold d-none d-md-block">
                {{ session('user_name') }} (SuperAdmin)
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
            var logoutItem = document.getElementById('li-logout-admin');
            if (logoutItem) {
                var parentUl = logoutItem.closest('ul');
                if (parentUl) { parentUl.style.width = '100%'; }
            }
        });
    </script>
@endsection