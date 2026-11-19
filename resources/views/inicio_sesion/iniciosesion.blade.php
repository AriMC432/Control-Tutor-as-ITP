{{-- ================================================================
     LOGIN
     
     SOLO APARIENCIA + FUNCIONALIDAD ORIGINAL DEL LOGIN
     
     NO SE MODIFICAN:
     - Rutas
     - Controlador
     - Modelo
     - Base de datos
     - CSRF
     - Validaciones
     ================================================================ --}}

@extends('layouts.app')


{{-- ================================================================
     TÍTULO
     ================================================================ --}}

@section('title', 'Iniciar Sesión')


{{-- ================================================================
     CONTENIDO
     ================================================================ --}}

@section('content')


<style>

    /* ============================================================
       VARIABLES DEL LOGIN
       ============================================================ */

    :root {

        --login-blue:
            #174c9b;

        --login-blue-dark:
            #0b3270;

        --login-blue-light:
            #2d83ff;

        --login-blue-soft:
            #edf5ff;

        --login-text:
            #172033;

        --login-muted:
            #6b7280;

        --login-border:
            #d9e3f2;

    }


    /* ============================================================
       FONDO
       ============================================================ */

        .login-page {
        height: calc(95vh - 245px);
        min-height: 0;
        box-sizing: border-box;
        width: calc(100% - 30px);
        max-width: 1020px;
        margin: 0 auto;
        margin-bottom: -70px;

        /* FONDO SIN DEGRADADO */

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 12px 12px;
    }

    /* ============================================================
       TARJETA
       ============================================================ */

    .login-wrapper {

        width:
            100%;

        max-width:
            850px;

        background:
            #ffffff;

        border:
            1px solid var(--login-border);

        border-radius:
            24px;

        overflow:
            hidden;

        box-shadow:
            0 20px 55px rgba(23,76,155,.14);

        display:
            grid;

        grid-template-columns:
            42% 58%;

    }


    /* ============================================================
       PANEL AZUL
       ============================================================ */

    .login-brand-panel {

        position:
            relative;

        overflow:
            hidden;

        background:
            linear-gradient(
                145deg,
                #205eaf 0%,
                #174c9b 48%,
                #0a2f70 100%
            );

        color:
            #ffffff;

        padding:
            22px 5px;

        display:
            flex;

        flex-direction:
            column;

        justify-content:
            center;

        align-items:
            center;

        text-align:
            center;

    }


    /* ============================================================
       DECORACIÓN
       ============================================================ */

    .login-brand-panel::before {

        content:
            "";

        position:
            absolute;

        width:
            360px;

        height:
            360px;

        border-radius:
            50%;

        background:
            rgba(255,255,255,.06);

        top:
            -80px;

        right:
            -140px;

    }


    .login-brand-panel::after {

        content:
            "";

        position:
            absolute;

        width:
            280px;

        height:
            280px;

        border-radius:
            50%;

        background:
            rgba(255,255,255,.045);

        bottom:
            -150px;

        left:
            -100px;

    }


    .login-brand-content {

        position:
            relative;

        z-index:
            2;

    }


    /* ============================================================
       LOGO
       ============================================================ */

    .login-logo {

        width:
            220px;

        height:
            230px;

        border-radius:
            24px;

        background:
            rgba(255,255,255,.12);

        border:
            1px solid rgba(255,255,255,.30);

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        margin:
            0 auto 18px;

        padding:
            15px;

    }


    .login-logo img {

        width:
            120%;

        height:
            120%;

        object-fit:
            contain;

    }


    /* ============================================================
       TÍTULO
       ============================================================ */

    .login-brand-title {

        font-size:
            1.75rem;

        font-weight:
            750;

        line-height:
            1.2;

        margin:
            0 0 12px;

    }


    /* ============================================================
       DESCRIPCIÓN
       ============================================================ */

    .login-brand-description {

        margin:
            0;

        color:
            rgba(255,255,255,.86);

        font-size:
            .98rem;

        line-height:
            1.6;

    }


    /* ============================================================
       LÍNEA DECORATIVA
       ============================================================ */

    .login-brand-line {

        width:
            70px;

        height:
            4px;

        border-radius:
            10px;

        background:
            #72b4ff;

        margin:
            15px auto 0;

        box-shadow:
            0 0 10px rgba(114,180,255,.65);

    }


    /* ============================================================
       PANEL DEL FORMULARIO
       ============================================================ */

    .login-form-panel {

        padding:
            30px 45px;

        display:
            flex;

        flex-direction:
            column;

        justify-content:
            center;

        background:
            #ffffff;

    }


    /* ============================================================
       ENCABEZADO
       ============================================================ */

    .login-form-header {

        margin-bottom:
            10px;

    }


    .login-form-title {

        color:
            var(--login-text);

        font-size:
            1.9rem;

        font-weight:
            75;

        margin:
            0 0 7px;

    }


    .login-form-subtitle {

        color:
            var(--login-muted);

        margin:
            0;

        font-size:
            .95rem;

    }


    /* ============================================================
       ETIQUETAS
       ============================================================ */

    .login-form-label {

        color:
            #25344d;

        font-size:
            .9rem;

        font-weight:
            650;

        margin-bottom:
            8px;

    }


    /* ============================================================
       CAMPOS
       ============================================================ */

    .login-form-control {

        min-height:
            48px;

        border:
            1px solid #d3ddeb;

        border-radius:
            11px;

        padding:
            .75rem 1rem;

        color:
            var(--login-text);

        background:
            #ffffff;

        transition:
            border-color .2s ease,
            box-shadow .2s ease;

    }


    .login-form-control:focus {

        border-color:
            var(--login-blue-light);

        box-shadow:
            0 0 0 4px rgba(45,131,255,.12);

        outline:
            none;

    }


    .login-form-control::placeholder {

        color:
            #a0aabe;

    }


    /* ============================================================
       CONTRASEÑA
       ============================================================ */

    .login-password-group {

        position:
            relative;

    }


    .login-password-group
    .login-form-control {

        padding-right:
            55px;

    }


    /* ============================================================
       BOTÓN OJO
       ============================================================ */

    .login-password-toggle {

        position:
            absolute;

        top:
            50%;

        right:
            7px;

        transform:
            translateY(-50%);

        width:
            40px;

        height:
            40px;

        border:
            0;

        border-radius:
            9px;

        background:
            transparent;

        color:
            #6b7a91;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        cursor:
            pointer;

        transition:
            background-color .2s ease,
            color .2s ease;

    }


    .login-password-toggle:hover {

        background:
            var(--login-blue-soft);

        color:
            var(--login-blue);

    }


    .login-password-toggle i {

        font-size:
            1.15rem;

    }


    /* ============================================================
       BOTÓN INGRESAR
       ============================================================ */

    .login-submit {

        width:
            100%;

        min-height:
            40px;

        border:
            1px solid var(--login-blue);

        border-radius:
            11px;

        background:
            linear-gradient(
                135deg,
                #205eaf,
                #174c9b
            );

        color:
            #ffffff;

        font-size:
            .98rem;

        font-weight:
            700;

        transition:
            background-color .2s ease,
            box-shadow .2s ease,
            transform .2s ease;

    }


    .login-submit:hover {

        color:
            #ffffff;

        background:
            linear-gradient(
                135deg,
                #2d83ff,
                #1769df
            );

        border-color:
            #5ca1ff;

        box-shadow:
            0 0 14px rgba(45,131,255,.35);

        transform:
            translateY(-1px);

    }


    .login-submit:disabled {

        opacity:
            .75;

        cursor:
            not-allowed;

        transform:
            none;

    }


    /* ============================================================
       ALERTAS
       ============================================================ */

    .login-alert {

        border-radius:
            10px;

        font-size:
            .9rem;

    }


    /* ============================================================
       SEPARADOR
       ============================================================ */

    .login-separator {

        display:
            flex;

        align-items:
            center;

        gap:
            12px;

        margin:
            4px 0 0;

        color:
            #a1adbd;

        font-size:
            .78rem;

    }


    .login-separator::before,
    .login-separator::after {

        content:
            "";

        height:
            1px;

        flex:
            1;

        background:
            #e3e9f2;

    }

    /* ============================================================
       TEXTO INFERIOR
       ============================================================ */
    .login-footer-text {
        margin:
            12px 0 0;
        text-align:
            center;
        color:
            #8a96a8;
        font-size:
            .78rem;
    }
 

    /* ============================================================
       TABLET
       ============================================================ */

    @media (max-width: 900px) {

        .login-wrapper {

            grid-template-columns:
                1fr;

            max-width:
                560px;

        }


        .login-brand-panel {

            padding:
                35px 30px;

        }


        .login-logo {

            width:
                85px;

            height:
                85px;

        }


        .login-brand-title {

            font-size:
                1.45rem;

        }


        .login-form-panel {

            padding:
                40px 35px;

        }

    }
    /* ============================================================
       CELULAR
       ============================================================ */
    @media (max-width: 576px) {

        .login-page {

            min-height:
                calc(100vh - 76px);

            padding:
                25px 12px;
        }
        .login-wrapper {
            border-radius:
                18px;
        }

        .login-brand-panel {
            padding:
                30px 22px;
        }


        .login-logo {

            width:
                75px;
            height:
                75px;
            border-radius:
                18px;

        }


        .login-brand-title {

            font-size:
                1.3rem;

        }


        .login-brand-description {

            font-size:
                .88rem;

        }


        .login-form-panel {

            padding:
                32px 22px;

        }


        .login-form-title {

            font-size:
                1.55rem;

        }

    }

</style>



{{-- ================================================================
     CONTENEDOR DEL LOGIN
     ================================================================ --}}

<div class="login-page">


    <div class="login-wrapper">


        {{-- ========================================================
             PANEL AZUL
             ======================================================== --}}

        <section class="login-brand-panel">

            <div class="login-brand-content">


                {{-- LOGO --}}

                <div class="login-logo">

                    <img
                        src="{{ asset('images/LITP.png') }}"
                        alt="Logo Instituto Tecnológico de Pachuca"
                    >

                </div>


                {{-- NOMBRE DEL SISTEMA --}}

                <h1 class="login-brand-title">

                    Control de Tutorías ITP

                </h1>


                {{-- DESCRIPCIÓN --}}

                <p class="login-brand-description">

                    Sistema de gestión y seguimiento
                    de tutorías del Instituto Tecnológico
                    de Pachuca.

                </p>


                <div class="login-brand-line"></div>

            </div>

        </section>



        {{-- ========================================================
             FORMULARIO
             ======================================================== --}}

        <section class="login-form-panel">


            {{-- ENCABEZADO --}}

            <div class="login-form-header">

                <h2 class="login-form-title">

                    Iniciar Sesión

                </h2>


                <p class="login-form-subtitle">

                    Ingresa tus datos para continuar.

                </p>

            </div>



            {{-- =====================================================
                 ERROR DE SESIÓN
                 ===================================================== --}}

            @if (session('error'))

                <div class="alert alert-danger login-alert mb-4">

                    <i class="bi bi-exclamation-circle-fill me-2"></i>

                    {{ session('error') }}

                </div>

            @endif



            {{-- =====================================================
                 MENSAJE DE ÉXITO
                 ===================================================== --}}

            @if (session('success'))

                <div class="alert alert-success login-alert mb-4">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    {{ session('success') }}

                </div>

            @endif



            {{-- =====================================================
                 FORMULARIO
                 ===================================================== --}}

            <form
                method="POST"
                action="{{ route('login.submit') }}"
                id="loginForm"
                novalidate
            >

                @csrf


                {{-- ERROR EMAIL --}}

                @error('email')

                    <div class="alert alert-danger login-alert mb-3">

                        {{ $message }}

                    </div>

                @enderror


                {{-- =================================================
                     EMAIL
                     ================================================= --}}

                <div class="mb-4">

                    <label
                        for="email"
                        class="login-form-label"
                    >

                        <i class="bi bi-envelope me-1"></i>

                        Correo electrónico

                    </label>


                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control login-form-control"
                        placeholder="usuario@ejemplo.com"
                        required
                        autofocus
                    >

                </div>



                {{-- ERROR PASSWORD --}}

                @error('password')

                    <div class="alert alert-danger login-alert mb-3">

                        {{ $message }}

                    </div>

                @enderror



                {{-- =================================================
                     PASSWORD
                     ================================================= --}}

                <div class="mb-4">

                    <label
                        for="password"
                        class="login-form-label"
                    >

                        <i class="bi bi-lock-fill me-1"></i>

                        Contraseña

                    </label>


                    <div class="login-password-group">


                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control login-form-control"
                            placeholder="Ingresa tu contraseña"
                            required
                        >


                        {{-- BOTÓN DEL OJO --}}

                        <button
                            class="login-password-toggle"
                            type="button"
                            id="togglePass"
                            aria-label="Mostrar contraseña"
                            title="Mostrar contraseña"
                        >

                            <i
                                class="bi bi-eye"
                                id="eyeIcon"
                            ></i>

                        </button>

                    </div>

                </div>



                {{-- =================================================
                     BOTÓN INGRESAR
                     ================================================= --}}

                <button
                    type="submit"
                    class="login-submit"
                    id="submitBtn"
                >

                    <i class="bi bi-box-arrow-in-right me-2"></i>

                    <span id="submitText">

                        Ingresar

                    </span>

                </button>



                {{-- =================================================
                     SEPARADOR
                     ================================================= --}}

                <div class="login-separator">

                    <span>

                        Acceso al sistema

                    </span>

                </div>


            </form>



            {{-- =====================================================
                 PIE DEL LOGIN
                 ===================================================== --}}

            <p class="login-footer-text">

                Instituto Tecnológico de Pachuca · TecNM

            </p>

        </section>

    </div>

</div>



{{-- ================================================================
     JAVASCRIPT DEL LOGIN
     
     NO UTILIZAMOS @push PARA EVITAR DEPENDER DE @stack('scripts')
     EN EL LAYOUT.
     ================================================================ --}}

<script>

    /* ============================================================
       ESPERAMOS A QUE LA PÁGINA ESTÉ CARGADA
       ============================================================ */

    document.addEventListener(
        'DOMContentLoaded',
        function () {


            /* ====================================================
               ELEMENTOS DEL LOGIN
               ==================================================== */

            const password =
                document.getElementById('password');

            const togglePass =
                document.getElementById('togglePass');

            const eyeIcon =
                document.getElementById('eyeIcon');



            /* ====================================================
               MOSTRAR / OCULTAR CONTRASEÑA
               ==================================================== */

            if (
                password &&
                togglePass &&
                eyeIcon
            ) {

                togglePass.addEventListener(
                    'click',
                    function () {


                        /* =========================================
                           CONTRASEÑA OCULTA
                           ========================================= */

                        if (
                            password.type === 'password'
                        ) {

                            password.type =
                                'text';

                            eyeIcon.className =
                                'bi bi-eye-slash';

                            togglePass.setAttribute(
                                'aria-label',
                                'Ocultar contraseña'
                            );

                            togglePass.setAttribute(
                                'title',
                                'Ocultar contraseña'
                            );

                        }


                        /* =========================================
                           CONTRASEÑA VISIBLE
                           ========================================= */

                        else {

                            password.type =
                                'password';

                            eyeIcon.className =
                                'bi bi-eye';

                            togglePass.setAttribute(
                                'aria-label',
                                'Mostrar contraseña'
                            );

                            togglePass.setAttribute(
                                'title',
                                'Mostrar contraseña'
                            );

                        }


                        /* =========================================
                           MANTENER FOCO
                           ========================================= */

                        password.focus();

                    }
                );

            }



            /* ====================================================
               BLOQUEAR BOTÓN AL ENVIAR
               ==================================================== */

            const form =
                document.getElementById('loginForm');

            const submitBtn =
                document.getElementById('submitBtn');

            const submitText =
                document.getElementById('submitText');


            if (
                form &&
                submitBtn
            ) {

                form.addEventListener(
                    'submit',
                    function () {


                        submitBtn.disabled =
                            true;


                        if (submitText) {

                            submitText.innerText =
                                'Ingresando…';

                        }

                    }
                );

            }

        }
    );

</script>


@endsection