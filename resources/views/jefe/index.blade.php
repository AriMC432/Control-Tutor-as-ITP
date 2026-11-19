
@extends('layouts.app')

@section('title', 'Jefe de Departamento')

@section('content')

<style>
    .jefe-dashboard {
        width: 100%;
        max-width: 1520px;
        margin: 0 auto;
    }

    .jefe-hero {
        width: 100%;
        min-height: 250px;
        padding: 20px 30px 10px;
        border-radius: 18px;
        background: linear-gradient(135deg, #2057a4 0%, #16468d 48%, #0b326f 100%);
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 28px rgba(20, 62, 120, .22);
        color: #ffffff;
    }

    .jefe-hero::before {
        content: "";
        position: absolute;
        width: 600px;
        height: 300px;
        top: -120px;
        left: 300px;
        border-radius: 50%;
        background: rgba(80, 160, 255, .18);
        pointer-events: none;
    }

    .jefe-hero::after {
        content: "";
        position: absolute;
        width: 430px;
        height: 300px;
        right: -80px;
        top: -70px;
        border-radius: 50%;
        background: rgba(0, 70, 160, .20);
        pointer-events: none;
    }

    .jefe-hero-top {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 35px;
        min-height: 125px;
    }

    .jefe-panel-info {
        display: flex;
        align-items: center;
        gap: 22px;
        min-width: 0;
    }

    .jefe-panel-icon {
        width: 82px;
        height: 82px;
        flex-shrink: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        color: #ffffff;
        border: 2px solid rgba(126, 196, 255, .65);
        background: rgba(255,255,255,.08);
        box-shadow: 0 0 8px rgba(71,164,255,.75),
                    0 0 20px rgba(71,164,255,.35),
                    inset 0 0 15px rgba(255,255,255,.08);
    }

    .jefe-panel-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        display: block;
    }

    .jefe-panel-icon i {
        font-size: 2.4rem;
    }

    .jefe-panel-title {
        margin: 0;
        color: #ffffff;
        font-size: 2.15rem;
        font-weight: 800;
        line-height: 1.1;
    }

    .jefe-panel-subtitle {
        margin: 8px 0 0;
        color: rgba(255,255,255,.90);
        font-size: 1rem;
        font-weight: 500;
    }

    .jefe-periodo {
        min-width: 350px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 18px;
        padding-left: 28px;
        border-left: 1px solid rgba(255,255,255,.28);
    }

    .jefe-periodo-text {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .jefe-periodo-label {
        color: rgba(255,255,255,.80);
        font-size: .78rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }

    .jefe-periodo-name {
        color: #ffffff;
        font-size: 1.45rem;
        font-weight: 800;
        line-height: 1.1;
        white-space: nowrap;
    }

    .jefe-nav {
        position: relative;
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 22px;
        flex-wrap: wrap;
    }

    .jefe-nav a {
        min-height: 48px;
        padding: 0 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        border: 1px solid rgba(126, 196, 255, .45);
        background: rgba(31, 100, 180, .35);
        color: #ffffff;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 700;
        transition: .25s ease;
        white-space: nowrap;
    }

    .jefe-nav a:hover {
        background: rgba(50, 145, 235, .65);
        box-shadow: 0 0 14px rgba(70,170,255,.35);
        transform: translateY(-1px);
        color: #ffffff;
    }

    .jefe-nav a.active {
        background: linear-gradient(180deg, #3298f5, #1673d7);
        border-color: #6fc0ff;
        box-shadow: 0 0 14px rgba(71,164,255,.65),
                    0 0 28px rgba(71,164,255,.25);
    }

    .jefe-welcome {
        width: 100%;
        margin-top: 30px;
        padding: 28px 32px;
        border-radius: 18px;
        border: 1px solid #d5e4f7;
        background: linear-gradient(135deg, #f3f8ff, #eaf3ff);
        box-shadow: 0 8px 22px rgba(30, 80, 140, .08);
    }

    .jefe-welcome-title {
        margin: 0 0 8px;
        color: #1e63bd;
        font-size: 1.65rem;
        font-weight: 800;
    }

    .jefe-welcome-text {
        margin: 0;
        color: #58708f;
        font-size: 1rem;
    }

    @media (max-width: 1100px) {
        .jefe-hero-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .jefe-periodo {
            width: 100%;
            min-width: 0;
            justify-content: flex-start;
            padding-left: 0;
            padding-top: 15px;
            border-left: none;
            border-top: 1px solid rgba(255,255,255,.28);
        }

        .jefe-nav a {
            flex: 1 1 auto;
        }
    }

    @media (max-width: 768px) {
        .jefe-hero {
            padding: 22px 18px 18px;
        }

        .jefe-panel-icon {
            width: 65px;
            height: 65px;
        }

        .jefe-panel-title {
            font-size: 1.65rem;
        }

        .jefe-panel-subtitle {
            font-size: .9rem;
        }

        .jefe-nav {
            gap: 8px;
        }

        .jefe-nav a {
            width: 100%;
            white-space: normal;
            min-height: 55px;
        }

        .jefe-periodo-name {
            white-space: normal;
        }
    }
</style>

<div class="jefe-dashboard">

    <div class="jefe-hero">

        <div class="jefe-hero-top">

            <div class="jefe-panel-info">

                <div class="jefe-panel-icon">
                    @if($usuario->foto)
                        <img
                            src="{{ asset('storage/fotos/docentes/' . $usuario->foto) }}"
                            alt="Foto del jefe"
                        >
                    @else
                        <i class="bi bi-person-workspace"></i>
                    @endif
                </div>

                <div>
                    <h1 class="jefe-panel-title">
                        Panel del Jefe de Departamento
                    </h1>

                    <p class="jefe-panel-subtitle">
                        Gestiona alumnos, docentes y grupos del departamento
                    </p>
                </div>

            </div>

            <div class="jefe-periodo">
                <div class="jefe-periodo-text">
                    <span class="jefe-periodo-label">
                        Ciclo escolar actual
                    </span>

                    <span class="jefe-periodo-name">
                        {{ $periodoActivo ? $periodoActivo->nombre : 'Sin periodo activo' }}
                    </span>
                </div>
            </div>

        </div>

        <nav class="jefe-nav" aria-label="Menú de Jefe Departamental">

            <a
                href="{{ route('jefe.index') }}"
                class="{{ request()->routeIs('jefe.index') ? 'active' : '' }}"
            >
                Inicio
            </a>

            <a
                href="{{ route('jefe.alta_docente') }}"
                class="{{ request()->routeIs('jefe.alta_docente') ? 'active' : '' }}"
            >
                Alta de Usuarios
            </a>

            <a
                href="{{ route('jefe.grupos.crear') }}"
                class="{{ request()->routeIs('jefe.grupos.crear') ? 'active' : '' }}"
            >
                Alta de Grupos
            </a>

            <a
                href="{{ route('jefe.grupos.asignar') }}"
                class="{{ request()->routeIs('jefe.grupos.asignar') ? 'active' : '' }}"
            >
                Asignación de Grupos
            </a>

            <a
                href="{{ route('jefe.alumnos') }}"
                class="{{ request()->routeIs('jefe.alumnos') ? 'active' : '' }}"
            >
                Alta de Alumnos
            </a>

            <a
                href="{{ route('jefe.perfil.view') }}"
                class="{{ request()->routeIs('jefe.perfil.view') ? 'active' : '' }}"
            >
                Mi Perfil
            </a>

            <a
                href="{{ route('encabezados.index') }}"
                class="{{ request()->routeIs('encabezados.*') ? 'active' : '' }}"
            >
                Encabezados
            </a>

            <a
                href="{{ route('jefe.asesorias') }}"
                class="{{ request()->routeIs('jefe.asesorias') ? 'active' : '' }}"
            >
                Gestión de Asesorías
            </a>

        </nav>
    </div>

    <div class="jefe-welcome">
        <h2 class="jefe-welcome-title">
            👋 Bienvenido(a), {{ session('user_name') ?? 'Usuario' }}!
        </h2>

        <p class="jefe-welcome-text">
            Desde este panel puedes gestionar alumnos, docentes y grupos
            del departamento.
        </p>
    </div>

</div>

@endsection
