@section('subnav')

{{-- === 1. INICIO === --}}
<li class="nav-item">
    <a href="{{ route('soporte.index') }}" class="nav-link {{ request()->routeIs('soporte.index') ? 'active' : '' }}">
        Inicio
    </a>
</li>

{{-- === 2. ALTA DE ALUMNOS === --}}
<li class="nav-item">
    {{-- Nota: La ruta en web.php es 'soporte.alumnos' --}}
    <a href="{{ route('soporte.alumnos') }}" class="nav-link {{ request()->routeIs('soporte.alumnos') ? 'active' : '' }}">
        Alta de Alumnos
    </a>
</li>

{{-- === 3. ALTA DE GRUPOS (Creación) === --}}
<li class="nav-item">
    <a href="{{ route('soporte.grupos.crear') }}" class="nav-link {{ request()->routeIs('soporte.grupos.crear') ? 'active' : '' }}">
        Alta de Grupos
    </a>
</li>

{{-- === 4. ASIGNAR GRUPOS (Vinculación) === --}}
<li class="nav-item">
    <a href="{{ route('soporte.grupos.asignar') }}" class="nav-link {{ request()->routeIs('soporte.grupos.asignar') ? 'active' : '' }}">
        Asignar Grupos
    </a>
</li>

{{-- === 5. PERIODOS ESCOLARES === --}}
<li class="nav-item">
    <a href="{{ route('soporte.periodos') }}" class="nav-link {{ request()->routeIs('soporte.periodos') ? 'active' : '' }}">
        Periodos
    </a>
</li>

{{-- === 6. ENCABEZADO === --}}
<li class="nav-item">
    <a href="{{ route('encabezados.index') }}" class="nav-link {{ request()->routeIs('encabezados.*') ? 'active' : '' }}">
        Encabezados
    </a>
</li>

{{-- === 7. FIRMAS === --}}
{{-- === 7. FIRMAS REPORTES === --}}
<li class="nav-item">
    <a href="{{ route('firmas.index') }}" class="nav-link {{ request()->routeIs('firmas.*') ? 'active' : '' }}">
        Firmas reportes
    </a>
</li>

{{-- === ÁREA DERECHA: NOMBRE Y LOGOUT === --}}
<li class="nav-item ms-auto d-flex align-items-center gap-3" id="li-logout-soporte">

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

{{-- SCRIPT VISUAL (Para forzar alineación a la derecha) --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var logoutItem = document.getElementById('li-logout-soporte');
        if (logoutItem) {
            var parentUl = logoutItem.closest('ul');
            if (parentUl) {
                parentUl.style.width = '100%';
            }
        }
    });
</script>

@endsection