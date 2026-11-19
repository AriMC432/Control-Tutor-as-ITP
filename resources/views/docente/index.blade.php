@extends('layouts.app')

@section('title', 'Panel Docente - Inicio')

@section('content')

<style>
/* ============================================================
   CONTENEDOR GENERAL
   ============================================================ */

.docente-dashboard {
    width: 100%;
    max-width: 1520px;
    margin: 0 auto;
}

/* ============================================================
   PANEL PRINCIPAL
   ============================================================ */

.docente-hero {
    width: 100%;
    min-height: 245px;
    padding: 28px 30px 20px;
    border-radius: 18px;

    background: linear-gradient(
        135deg,
        #2057a4 0%,
        #16468d 48%,
        #0b326f 100%
    );

    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 28px rgba(20, 62, 120, .22);
    color: #ffffff;
}

/* Decoración del panel */

.docente-hero::before {
    content: "";
    position: absolute;
    width: 500px;
    height: 300px;
    top: -180px;
    left: 25%;
    border-radius: 50%;
    background: rgba(63, 139, 255, .16);
    pointer-events: none;
}

.docente-hero::after {
    content: "";
    position: absolute;
    width: 450px;
    height: 250px;
    right: -180px;
    top: -80px;
    border-radius: 50%;
    background: rgba(44, 117, 235, .12);
    pointer-events: none;
}

/* ============================================================
   PARTE SUPERIOR DEL PANEL
   ============================================================ */

.docente-hero-top {
    position: relative;
    z-index: 2;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 35px;

    min-height: 125px;
}

/* Identidad */

.docente-panel-info {
    display: flex;
    align-items: center;
    gap: 22px;
    min-width: 0;
}



.docente-panel-title {
    margin: 0;
    color: #ffffff;
    font-size: 2rem;
    font-weight: 800;
    line-height: 1.1;
}

.docente-panel-subtitle {
    margin: 8px 0 0;
    color: rgba(255,255,255,.90);
    font-size: 1rem;
    font-weight: 500;
}

.docente-panel-icon {
    width: 102px;
    height: 102px;
    border-radius: 50%;
    overflow: hidden;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 3px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.08);

    flex-shrink: 0;

}

.docente-panel-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.docente-panel-fallback {
    font-size: 45px;
    color: #ffffff;
}

/* ============================================================
   CICLO ESCOLAR
   ============================================================ */

.docente-periodo {
    min-width: 350px;

    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 18px;

    padding-left: 28px;
    border-left: 1px solid rgba(255,255,255,.28);
}

.docente-periodo-icon {
    width: 58px;
    height: 58px;
    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 14px;
    color: #ffffff;
    font-size: 1.7rem;

    border: 1px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.10);
}

.docente-periodo-text {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.docente-periodo-label {
    color: rgba(255,255,255,.80);
    font-size: .78rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.docente-periodo-name {
    color: #ffffff;
    font-size: 1.45rem;
    font-weight: 800;
    line-height: 1.1;
    white-space: nowrap;
}

/* ============================================================
   MENÚ DENTRO DEL PANEL AZUL
   ============================================================ */

.docente-panel-nav {
    position: relative;
    z-index: 3;

    width: 100%;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    flex-wrap: wrap;

    gap: 9px;
    margin-top: 10px;
    padding: 0 2px;
}

.docente-nav-link {
    min-width: 145px;
    height: 50px;
    padding: 0 20px;

    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;

    border-radius: 11px;
    border: 1px solid rgba(99,173,255,.55);
    background: rgba(25,84,160,.34);

    color: #ffffff;
    text-decoration: none;
    font-size: .95rem;
    font-weight: 700;
    white-space: nowrap;

    transition: all .22s ease;
}

.docente-nav-link .nav-icon {
    font-size: 1rem;
}

/* Efecto al pasar el cursor */

.docente-nav-link:hover {
    color: #ffffff;

    background: linear-gradient(
        180deg,
        #3195ff 0%,
        #176bd7 100%
    );

    border-color: #82ccff;

    box-shadow:
        0 0 6px rgba(59,165,255,1),
        0 0 14px rgba(59,165,255,.90),
        0 0 27px rgba(59,165,255,.55),
        inset 0 1px 0 rgba(255,255,255,.48);

    transform: translateY(-1px);
}

/* Opción activa */

.docente-nav-link.active {
    color: #ffffff;

    background: linear-gradient(
        180deg,
        #3195ff 0%,
        #176bd7 100%
    );

    border-color: #82ccff;

    box-shadow:
        0 0 7px rgba(59,165,255,1),
        0 0 17px rgba(59,165,255,.90),
        0 0 30px rgba(59,165,255,.55),
        inset 0 1px 0 rgba(255,255,255,.50);
}

/* ============================================================
   CONTENIDO INFERIOR
   ============================================================ */

.docente-content {
    margin-top: 26px;
}

/* Encabezado de bienvenida */

.docente-welcome {
    margin-bottom: 22px;
    padding: 24px 28px;

    background: linear-gradient(
        135deg,
        #f5f9ff,
        #edf4fd
    );

    border: 1px solid #d8e5f5;
    border-radius: 16px;
    box-shadow: 0 5px 16px rgba(30,70,120,.07);
}

.docente-welcome-title {
    margin: 0 0 7px;
    color: #1763c4;
    font-size: 1.45rem;
    font-weight: 800;
}

.docente-welcome-text {
    margin: 0;
    color: #61728b;
    font-size: 1rem;
}

/* Tarjetas */

.docente-card {
    height: 100%;
    background: #ffffff;
    border: 1px solid #dce6f2;
    border-radius: 16px;
    box-shadow: 0 5px 16px rgba(30,70,120,.07);
    overflow: hidden;
}

.docente-card-header {
    padding: 18px 22px;
    background: #ffffff;
    border-bottom: 1px solid #e1e8f0;
}

.docente-card-header h5 {
    margin: 0;
    color: #52647c;
    font-size: 1.05rem;
    font-weight: 800;
}

.docente-card-body {
    background: #ffffff;
}

/* Filas de grupos */

.docente-grupo-item {
    padding: 17px 22px;
    border-bottom: 1px solid #e8edf3;
}

.docente-grupo-item:last-child {
    border-bottom: 0;
}

/* Botón Anexo */

.docente-btn-anexo {
    background: #1a3a6b;
    color: #ffffff;
    border: none;
    border-radius: 7px;
    padding: 7px 12px;
    font-size: .8rem;
    font-weight: 700;
    text-decoration: none;
}

.docente-btn-anexo:hover {
    background: #2461ad;
    color: #ffffff;
}

/* Tabla */

.docente-table {
    margin-bottom: 0;
}

.docente-table thead th {
    background: #f4f7fb;
    color: #52647c;
    border-bottom: 1px solid #dce5ef;
    font-size: .80rem;
    font-weight: 800;
    text-transform: uppercase;
    padding: 13px 12px;
}

.docente-table tbody td {
    padding: 15px 12px;
    border-color: #e8edf3;
    color: #43536a;
    font-size: .9rem;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 1000px) {

    .docente-hero-top {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }

    .docente-periodo {
        width: 100%;
        min-width: 0;
        padding-left: 0;
        border-left: 0;
        border-top: 1px solid rgba(255,255,255,.20);
        padding-top: 15px;
        justify-content: flex-start;
    }

    .docente-panel-nav {
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 5px;
    }
}

@media (max-width: 768px) {

    .docente-hero {
        padding: 22px 18px 15px;
    }

    .docente-panel-info {
        gap: 15px;
    }

    .docente-panel-icon {
        width: 65px;
        height: 65px;
        font-size: 1.8rem;
    }

    .docente-panel-title {
        font-size: 1.55rem;
    }

    .docente-periodo-name {
        font-size: 1.15rem;
    }

    .docente-nav-link {
        min-width: 135px;
    }
}
</style>


<div class="docente-dashboard">

    {{-- =====================================================
         PANEL PRINCIPAL CON MENÚ INTEGRADO
         ===================================================== --}}

<section class="docente-hero">

    {{-- PARTE SUPERIOR: FOTO, TÍTULO Y CICLO ESCOLAR --}}

    <div class="docente-hero-top">

        <div class="docente-panel-info">

            {{-- FOTO DE PERFIL DEL DOCENTE --}}
            <div class="docente-panel-icon">

                @if($usuario->foto)

                    <img
                        src="{{ asset('storage/fotos/docentes/' . $usuario->foto) }}"
                        alt="Foto de perfil"
                        class="docente-panel-photo"
                    >

                @else

                    <i class="bi bi-person-fill docente-panel-fallback"></i>

                @endif

            </div>


            {{-- INFORMACIÓN DEL PANEL --}}

            <div>

                <h1 class="docente-panel-title">
                    Panel del Docente
                </h1>

                <p class="docente-panel-subtitle">
                    Gestiona tus grupos y da seguimiento al proceso de tutorías
                </p>

            </div>

        </div>


        {{-- CICLO ESCOLAR ACTUAL --}}

        <div class="docente-periodo">

            {{-- AQUÍ QUITAMOS SOLAMENTE EL CUADRITO DEL CALENDARIO --}}

            <div class="docente-periodo-text">

                <span class="docente-periodo-label">
                    Ciclo escolar actual
                </span>

                <span class="docente-periodo-name">
                    {{ $periodoActivo ? $periodoActivo->nombre : 'Sin periodo activo' }}
                </span>

            </div>

        </div>

    </div>


    {{-- MENÚ DENTRO DEL MISMO PANEL AZUL --}}

    <nav class="docente-panel-nav">

        <a
            href="{{ route('docente.index') }}"
            class="docente-nav-link {{ request()->routeIs('docente.index') ? 'active' : '' }}"
        >
            <i class="bi bi-house-door-fill nav-icon"></i>
            <span>Inicio</span>
        </a>


        <a
            href="{{ route('docente.tutorias') }}"
            class="docente-nav-link {{ request()->routeIs('docente.tutorias') ? 'active' : '' }}"
        >
            <i class="bi bi-calendar-plus-fill nav-icon"></i>
            <span>Agendar Tutoría</span>
        </a>


        <a
            href="{{ route('docente.canalizaciones') }}"
            class="docente-nav-link {{ request()->routeIs('docente.canalizaciones') ? 'active' : '' }}"
        >
            <i class="bi bi-people-fill nav-icon"></i>
            <span>Gestionar Canalizaciones</span>
        </a>


        <a
            href="{{ route('docente.perfil.view') }}"
            class="docente-nav-link {{ request()->routeIs('docente.perfil.view') ? 'active' : '' }}"
        >
            <i class="bi bi-person-circle nav-icon"></i>
            <span>Perfil</span>
        </a>

    </nav>

</section>


    {{-- =====================================================
         CONTENIDO DE LA PÁGINA
         ===================================================== --}}

    <div class="docente-content">

        {{-- BIENVENIDA --}}

        <section class="docente-welcome">

            <h2 class="docente-welcome-title">
                👋 Bienvenido(a), {{ session('user_name', 'Docente') }}!
            </h2>

            <p class="docente-welcome-text">
                Desde este panel puedes consultar tus grupos asignados
                y revisar el historial de tutorías registradas.
            </p>

        </section>


        <div class="row g-4">

            {{-- =================================================
                 COLUMNA IZQUIERDA: GRUPOS ASIGNADOS
                 ================================================= --}}

            <div class="col-12 col-lg-5">

                <div class="docente-card">

                    <div class="docente-card-header">
                        <h5>
                            <i class="bi bi-people-fill me-2 text-primary"></i>
                            Mis grupos
                        </h5>
                    </div>

                    <div class="docente-card-body">

                        @if(isset($grupos) && count($grupos))

                            <ul class="list-group list-group-flush">

                                @foreach($grupos as $g)

                                    <li class="list-group-item docente-grupo-item">

                                        <div class="d-flex justify-content-between align-items-center gap-3">

                                            <div>
                                                <div class="fw-bold text-dark fs-5">
                                                    {{ $g->nombre }}
                                                </div>

                                                <div class="small text-muted">
                                                    Sem {{ $g->semestre }} ·
                                                    {{ $g->carrera ? $g->carrera->nombre : 'Ingeniería' }}
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column flex-sm-row gap-2 align-items-center">

                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-3 py-2">
                                                    Asignado
                                                </span>

                                                <a
                                                    href="{{ route('docente.reporte.configurar', [$g->id_grupo, $periodoActual->id_periodo]) }}"
                                                    class="docente-btn-anexo"
                                                >
                                                    Anexo 19
                                                </a>

                                            </div>

                                        </div>

                                    </li>

                                @endforeach

                            </ul>

                        @else

                            <div class="p-5 text-center text-muted">

                                <i class="bi bi-folder-x fs-1 d-block mb-3 opacity-50"></i>

                                <h6 class="fw-bold">
                                    Sin grupos asignados
                                </h6>

                                <small>
                                    Contacta a tu Jefe de Departamento.
                                </small>

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- =================================================
                 COLUMNA DERECHA: HISTORIAL DE TUTORÍAS
                 ================================================= --}}

            <div class="col-12 col-lg-7">

                <div class="docente-card">

                    <div class="docente-card-header d-flex justify-content-between align-items-center">

                        <h5>
                            <i class="bi bi-journal-text me-2 text-success"></i>
                            Historial Reciente
                        </h5>

                        <span class="badge bg-light text-secondary border">
                            Últimos registros
                        </span>

                    </div>

                    <div class="docente-card-body">

                        @if(isset($tutorias) && count($tutorias))

                            <div class="table-responsive">

                                <table class="table table-hover align-middle docente-table">

                                    <thead>
                                        <tr>
                                            <th class="ps-4 py-3">Fecha</th>
                                            <th class="py-3">Tipo</th>
                                            <th class="py-3">Tema / Motivo</th>
                                            <th class="py-3">Atención a:</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach($tutorias as $t)

                                            <tr>

                                                <td class="ps-4 text-nowrap text-secondary">
                                                    <i class="bi bi-calendar3 me-2 small"></i>
                                                    {{ \Illuminate\Support\Carbon::parse($t->fecha)->format('d/m/Y') }}
                                                </td>

                                                <td>

                                                    @if($t->tipo == 'Grupal')

                                                        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3">
                                                            Grupal
                                                        </span>

                                                    @else

                                                        <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning text-dark px-3">
                                                            Individual
                                                        </span>

                                                    @endif

                                                </td>

                                                <td class="fw-semibold text-dark" style="max-width: 250px;">

                                                    <div class="text-truncate" title="{{ $t->tema }}">
                                                        {{ $t->tema }}
                                                    </div>

                                                </td>

                                                <td class="small text-muted fw-medium">

                                                    @if($t->tipo == 'Grupal')
                                                        <i class="bi bi-people me-1"></i>
                                                    @else
                                                        <i class="bi bi-person me-1"></i>
                                                    @endif

                                                    {{ $t->info }}

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @else

                            <div class="text-center py-5 text-muted">

                                <div class="mb-3">
                                    <i class="bi bi-calendar2-plus fs-1 text-success opacity-50"></i>
                                </div>

                                <h5 class="fw-bold text-dark">
                                    No hay tutorías registradas
                                </h5>

                                <p class="mb-4 small">
                                    Comienza registrando tu primera sesión para ver el historial.
                                </p>

                                <a
                                    href="{{ route('docente.tutorias') }}"
                                    class="btn btn-success px-4 rounded-pill"
                                >
                                    <i class="bi bi-plus-lg me-2"></i>
                                    Registrar Tutoría
                                </a>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection