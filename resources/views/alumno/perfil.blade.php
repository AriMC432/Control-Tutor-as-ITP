@extends('layouts.app')

@section('title', 'Mi Perfil')

{{-- ============================================================ --}}
{{-- MENÚ DEL ALUMNO                                              --}}
{{-- ============================================================ --}}
@includeWhen(true, 'alumno._subnav')


@section('content')

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-12 col-md-10">

            {{-- ================================================= --}}
            {{-- TARJETA PRINCIPAL DEL PERFIL                      --}}
            {{-- ================================================= --}}

            <div class="card perfil-card p-4 text-start shadow-sm border-0">


                {{-- ================================================= --}}
                {{-- PERIODO ESCOLAR ACTIVO                            --}}
                {{-- ================================================= --}}

                @if($periodoActual)

                    <div class="periodo-perfil">

                        <i class="bi bi-calendar-check"></i>

                        <span>
                            Periodo activo:
                            <strong>{{ $periodoActual->nombre }}</strong>
                        </span>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- FOTO DE PERFIL                                     --}}
                {{-- ================================================= --}}

                <div class="foto-container">

                    @php
                        /*
                        |--------------------------------------------------------------------------
                        | OBTENER FOTO
                        |--------------------------------------------------------------------------
                        | Se utiliza la URL que ya proporciona el modelo.
                        | Si no existe, se utiliza la imagen predeterminada.
                        */

                        $fotoPerfil = $estudiante->foto_url ?? null;

                        $fotoPredeterminada = asset('images/default-avatar.png');

                        /*
                        |--------------------------------------------------------------------------
                        | Si foto_url está vacío, usamos directamente el avatar.
                        |--------------------------------------------------------------------------
                        */

                        $fotoMostrar = !empty($fotoPerfil)
                            ? $fotoPerfil
                            : $fotoPredeterminada;
                    @endphp


                    {{-- ================================================= --}}
                    {{-- IMAGEN                                             --}}
                    {{-- ================================================= --}}

                    <img
                        src="{{ $fotoMostrar }}"
                        alt="Foto de perfil"
                        class="profile-img"
                        id="fotoPerfilAlumno"

                        /*
                        |--------------------------------------------------------------------------
                        | Si la imagen no existe, automáticamente utiliza
                        | el avatar predeterminado.
                        |--------------------------------------------------------------------------
                        */

                        onerror="this.onerror=null; this.src='{{ $fotoPredeterminada }}';"
                    >


                    {{-- ================================================= --}}
                    {{-- BOTÓN EDITAR FOTO                                 --}}
                    {{-- ================================================= --}}

                    <a
                        href="{{ route('alumno.perfil.editar-foto') }}"
                        class="btn-edit-foto"
                        title="Cambiar foto de perfil"
                        aria-label="Cambiar foto de perfil"
                    >

                        <i class="bi bi-pencil-fill"></i>

                    </a>

                </div>


                {{-- ================================================= --}}
                {{-- TÍTULO DEL PERFIL                                  --}}
                {{-- ================================================= --}}

                <div class="perfil-heading">

                    <h5 class="fw-bold mb-2">
                        Mi Perfil
                    </h5>

                    <p class="text-muted mb-0">
                        Consulta tus datos registrados y actualiza tu contraseña.
                    </p>

                </div>


                <hr>


                {{-- ================================================= --}}
                {{-- MENSAJE DE ÉXITO                                  --}}
                {{-- ================================================= --}}

                @if(session('success'))

                    <div
                        class="alert alert-success d-flex align-items-center shadow-sm"
                        role="alert"
                    >

                        <i class="bi bi-check-circle-fill me-2"></i>

                        <div>
                            {{ session('success') }}
                        </div>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- ERRORES                                            --}}
                {{-- ================================================= --}}

                @if($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- SECCIÓN 1: INFORMACIÓN ACADÉMICA                   --}}
                {{-- ================================================= --}}

                <h6 class="perfil-section-title text-uppercase fw-bold mt-3 mb-3">

                    <i class="bi bi-mortarboard-fill me-2"></i>

                    Información Académica

                </h6>


                <div class="row g-3 mb-5">


                    {{-- ================================================= --}}
                    {{-- NOMBRE COMPLETO                                   --}}
                    {{-- ================================================= --}}

                    <div class="col-12 col-md-6">

                        <label class="form-label fw-semibold">
                            Nombre Completo
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $estudiante->nombre }}
                            {{ $estudiante->paterno }}
                            {{ $estudiante->materno }}"
                            readonly
                        >

                    </div>


                    {{-- ================================================= --}}
                    {{-- NÚMERO DE CONTROL                                 --}}
                    {{-- ================================================= --}}

                    <div class="col-12 col-md-6">

                        <label class="form-label fw-semibold">
                            Número de Control
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $estudiante->num_control }}"
                            readonly
                        >

                    </div>


                    {{-- ================================================= --}}
                    {{-- CORREO                                            --}}
                    {{-- ================================================= --}}

                    <div class="col-12 col-md-6">

                        <label class="form-label fw-semibold">
                            Correo
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            value="{{ $estudiante->correo }}"
                            readonly
                        >

                    </div>


                    {{-- ================================================= --}}
                    {{-- GRUPO                                             --}}
                    {{-- ================================================= --}}

                    <div class="col-12 col-md-6">

                        <label class="form-label fw-semibold">
                            Grupo
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $estudiante->grupo->nombre ?? 'Sin grupo asignado' }}"
                            readonly
                        >

                    </div>

                </div>


                <hr>


                {{-- ================================================= --}}
                {{-- SECCIÓN 2: SEGURIDAD                               --}}
                {{-- ================================================= --}}

                <h6 class="perfil-section-title perfil-security-title text-uppercase fw-bold mt-4 mb-3">

                    <i class="bi bi-shield-lock-fill me-2"></i>

                    Seguridad y Acceso

                </h6>


                {{-- ================================================= --}}
                {{-- FORMULARIO CAMBIO DE CONTRASEÑA                   --}}
                {{-- ================================================= --}}

                <form
                    action="{{ route('alumno.perfil.update_password') }}"
                    method="POST"
                >

                    @csrf


                    <div class="row g-3">


                        {{-- ================================================= --}}
                        {{-- CONTRASEÑA ACTUAL                                 --}}
                        {{-- ================================================= --}}

                        <div class="col-12">

                            <label
                                for="current_password"
                                class="form-label fw-semibold"
                            >

                                Contraseña Actual

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input
                                type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password"
                                name="current_password"
                                required
                            >


                            @error('current_password')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- ================================================= --}}
                        {{-- NUEVA CONTRASEÑA                                 --}}
                        {{-- ================================================= --}}

                        <div class="col-12 col-md-6">

                            <label
                                for="password"
                                class="form-label fw-semibold"
                            >

                                Nueva Contraseña

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                required
                            >


                            {{-- ================================================= --}}
                            {{-- REQUISITOS                                      --}}
                            {{-- ================================================= --}}

                            <div class="password-requirements mt-2">

                                <div class="small fw-bold mb-1">

                                    <i class="bi bi-shield-check me-1"></i>

                                    REQUISITOS DE SEGURIDAD

                                </div>


                                <ul class="mb-0">

                                    <li>
                                        Mínimo 8 caracteres.
                                    </li>

                                    <li>
                                        Al menos una mayúscula y una minúscula.
                                    </li>

                                    <li>
                                        Al menos una letra y un número.
                                    </li>

                                    <li>
                                        Al menos un símbolo (ej. !@#$%*).
                                    </li>

                                </ul>

                            </div>


                            @error('password')

                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- ================================================= --}}
                        {{-- CONFIRMAR CONTRASEÑA                              --}}
                        {{-- ================================================= --}}

                        <div class="col-12 col-md-6">

                            <label
                                for="password_confirmation"
                                class="form-label fw-semibold"
                            >

                                Confirmar Nueva Contraseña

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                            >

                        </div>


                    </div>


                    {{-- ================================================= --}}
                    {{-- BOTÓN ACTUALIZAR                                  --}}
                    {{-- ================================================= --}}

                    <div class="d-flex justify-content-end mt-4">

                        <button
                            type="submit"
                            class="btn btn-primary perfil-password-btn px-5 fw-semibold"
                        >

                            <i class="bi bi-key-fill me-2"></i>

                            Actualizar Contraseña

                        </button>

                    </div>


                </form>


            </div>
            {{-- FIN TARJETA PRINCIPAL --}}

        </div>

    </div>

</div>


{{-- ============================================================ --}}
{{-- ESTILOS EXCLUSIVOS DEL PERFIL                               --}}
{{-- ============================================================ --}}

<style>

    /* ========================================================= */
    /* TARJETA PRINCIPAL                                        */
    /* ========================================================= */

    .perfil-card {

        border-radius: 18px !important;

        background: #ffffff;

        border: 1px solid #e4ebf5 !important;

        box-shadow:
            0 8px 25px rgba(23, 76, 155, 0.08) !important;

        overflow: hidden;

    }


    /* ========================================================= */
    /* PERIODO ACTIVO                                           */
    /* ========================================================= */

    .periodo-perfil {

        width: 100%;

        display: flex;

        justify-content: center;

        align-items: center;

        gap: 10px;

        padding: 11px 20px;

        margin-bottom: 25px;

        border-radius: 9px;

        background: linear-gradient(
            90deg,
            #08bde5,
            #18c5e8
        );

        color: #ffffff;

        font-size: 1.05rem;

        font-weight: 600;

        box-shadow:
            0 4px 12px rgba(8, 189, 229, 0.25);

    }


    .periodo-perfil i {

        font-size: 1.35rem;

    }


    /* ========================================================= */
    /* CONTENEDOR DE FOTO                                       */
    /* ========================================================= */

    .foto-container {

        position: relative;

        width: 190px;

        height: 190px;

        margin: 0 auto 25px auto;

        display: flex;

        align-items: center;

        justify-content: center;

    }


    /* ========================================================= */
    /* FOTO                                                     */
    /* ========================================================= */

    .profile-img {

        width: 180px;

        height: 180px;

        border-radius: 50%;

        object-fit: cover;

        object-position: center;

        display: block;

        background-color: #f1f5f9;

        border: 5px solid #ffffff;

        box-shadow:
            0 8px 20px rgba(0, 0, 0, 0.12);

        transition:
            transform .25s ease,
            box-shadow .25s ease;

    }


    .profile-img:hover {

        transform: scale(1.02);

        box-shadow:
            0 10px 25px rgba(13, 110, 253, 0.18);

    }


    /* ========================================================= */
    /* BOTÓN EDITAR FOTO                                        */
    /* ========================================================= */

    .btn-edit-foto {

        position: absolute;

        right: 4px;

        bottom: 7px;

        width: 46px;

        height: 46px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 50%;

        background: linear-gradient(
            135deg,
            #1677f2,
            #0d6efd
        );

        color: #ffffff;

        border: 3px solid #ffffff;

        text-decoration: none;

        box-shadow:
            0 5px 14px rgba(13, 110, 253, 0.35);

        transition:
            transform .2s ease,
            box-shadow .2s ease,
            background .2s ease;

        z-index: 5;

    }


    .btn-edit-foto:hover {

        color: #ffffff;

        transform: scale(1.1);

        background: linear-gradient(
            135deg,
            #3b91ff,
            #0d6efd
        );

        box-shadow:
            0 0 8px rgba(13, 110, 253, 0.8),
            0 0 18px rgba(13, 110, 253, 0.45);

    }


    .btn-edit-foto i {

        font-size: 1.1rem;

    }


    /* ========================================================= */
    /* ENCABEZADO DEL PERFIL                                    */
    /* ========================================================= */

    .perfil-heading {

        margin-top: 5px;

    }


    .perfil-heading h5 {

        color: #174c9b;

        font-size: 1.55rem;

    }


    .perfil-heading p {

        font-size: 1rem;

    }


    /* ========================================================= */
    /* TÍTULOS DE SECCIÓN                                       */
    /* ========================================================= */

    .perfil-section-title {

        color: #1769e0;

        font-size: 1rem;

        letter-spacing: .3px;

    }


    .perfil-security-title {

        color: #174c9b;

    }


    /* ========================================================= */
    /* INPUTS                                                    */
    /* ========================================================= */

    .perfil-card .form-control {

        min-height: 48px;

        border-radius: 9px;

        border: 1px solid #d7e1ef;

        background-color: #ffffff;

        transition:
            border-color .2s ease,
            box-shadow .2s ease;

    }


    .perfil-card .form-control:focus {

        border-color: #1769e0;

        box-shadow:
            0 0 0 3px rgba(23, 105, 224, .12);

    }


    .perfil-card .form-control[readonly] {

        background-color: #f8fafc;

        color: #475569;

    }


    /* ========================================================= */
    /* REQUISITOS DE CONTRASEÑA                                 */
    /* ========================================================= */

    .password-requirements {

        padding: 12px 15px;

        border-radius: 9px;

        background: #f5f8fc;

        border: 1px solid #e1e8f2;

        color: #64748b;

    }


    .password-requirements > div {

        color: #475569;

        font-size: .75rem;

    }


    .password-requirements ul {

        padding-left: 18px;

        margin-top: 5px;

        font-size: .72rem;

    }


    .password-requirements li {

        margin-bottom: 2px;

    }


    /* ========================================================= */
    /* BOTÓN ACTUALIZAR                                         */
    /* ========================================================= */

    .perfil-password-btn {

        border-radius: 9px;

        min-height: 46px;

        background: linear-gradient(
            135deg,
            #1769e0,
            #0d6efd
        );

        border: none;

        box-shadow:
            0 4px 12px rgba(13, 110, 253, .20);

        transition:
            transform .2s ease,
            box-shadow .2s ease;

    }


    .perfil-password-btn:hover {

        background: linear-gradient(
            135deg,
            #287cf0,
            #0d6efd
        );

        transform: translateY(-1px);

        box-shadow:
            0 0 8px rgba(13, 110, 253, .55),
            0 6px 18px rgba(13, 110, 253, .25);

    }


    /* ========================================================= */
    /* RESPONSIVE                                                */
    /* ========================================================= */

    @media (max-width: 767px) {

        .perfil-card {

            padding: 20px !important;

        }


        .periodo-perfil {

            text-align: center;

            font-size: .95rem;

        }


        .foto-container {

            width: 165px;

            height: 165px;

        }


        .profile-img {

            width: 155px;

            height: 155px;

        }


        .btn-edit-foto {

            width: 42px;

            height: 42px;

            right: 0;

            bottom: 3px;

        }


        .perfil-password-btn {

            width: 100%;

        }

    }

</style>

@endsection