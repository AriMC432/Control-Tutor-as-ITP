
@extends('layouts.app')

@section('title', 'Crear Nuevo Grupo')

@section('content')

    {{-- =====================================================
         ESTILOS DEL MENÚ SUPERIOR DEL JEFE
         Únicamente modifica los botones de navegación.
         No afecta el formulario ni sus botones.
    ====================================================== --}}
    <style>

        /* Contenedor de los botones del menú */
        .jefe-nav {
            gap: 8px !important;
            margin-top: 14px !important;

            /* En pantallas grandes se intenta mantener una línea */
            flex-wrap: nowrap !important;
        }

        /* Botones individuales del menú */
        .jefe-nav a {
            min-height: 48px !important;
            height: 48px !important;

            /* Reduce el espacio interno horizontal */
            padding: 0 14px !important;

            /* Tamaño uniforme de texto */
            font-size: 14px !important;
            line-height: 1.2 !important;

            /* Mantiene las esquinas redondeadas */
            border-radius: 10px !important;

            /* Evita que el texto se divida */
            white-space: nowrap !important;

            /* Evita que los botones se estiren */
            flex: 0 0 auto !important;
        }

        /* =====================================================
           TABLETS
           Permite que los botones pasen a otra línea
           cuando el espacio disponible sea insuficiente.
        ====================================================== */
        @media (max-width: 1100px) {

            .jefe-nav {
                flex-wrap: wrap !important;
            }

        }

        /* =====================================================
           CELULARES
           Reduce un poco más el tamaño de los botones.
        ====================================================== */
        @media (max-width: 768px) {

            .jefe-nav {
                gap: 8px !important;
                flex-wrap: wrap !important;
            }

            .jefe-nav a {
                min-height: 45px !important;
                height: 45px !important;

                padding: 0 12px !important;

                font-size: 13px !important;
            }

        }

    </style>


    {{-- =====================================================
         MENÚ DE NAVEGACIÓN DEL JEFE
         Se conserva el archivo original.
    ====================================================== --}}
    @include('jefe._subnav')


    {{-- =====================================================
         CONTENEDOR PRINCIPAL
         Centra el contenido de la página.
    ====================================================== --}}
    <div class="container pb-5">

        {{-- Distribución de las columnas --}}
        <div class="row justify-content-center">

            {{-- Ancho del contenido --}}
            <div class="col-12 col-md-10 col-lg-8">


                {{-- =================================================
                     ENCABEZADO DE LA PÁGINA
                ================================================== --}}
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">

                    {{-- Título principal --}}
                    <h2 class="fw-bold text-dark mb-0">
                        Gestión de Grupos
                    </h2>

                    {{-- Descripción --}}
                    <span class="text-muted">
                        Registro de Nuevos Grupos
                    </span>

                </div>


                {{-- =================================================
                     PERIODO ACTIVO
                     Se muestra únicamente si existe un periodo.
                ================================================== --}}
                @if($periodoActual)

                    <span class="badge bg-info fs-5 p-2 shadow-sm">

                        {{-- Icono del calendario --}}
                        <i class="bi bi-calendar-check me-1"></i>

                        {{-- Nombre del periodo --}}
                        Periodo activo: {{ $periodoActual->nombre }}

                    </span>

                @endif



                {{-- =================================================
                     MENSAJE DE ÉXITO
                     Se muestra cuando Laravel recibe una sesión success.
                ================================================== --}}
                @if(session('success'))

                    <div
                        class="alert alert-success d-flex align-items-center shadow-sm border-0"
                        role="alert"
                    >

                        {{-- Icono de confirmación --}}
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>

                        {{-- Texto del mensaje --}}
                        <div>
                            {{ session('success') }}
                        </div>

                    </div>

                @endif



                {{-- =================================================
                     MENSAJE DE ERROR
                     Se muestra cuando Laravel recibe una sesión error.
                ================================================== --}}
                @if(session('error'))

                    <div
                        class="alert alert-danger d-flex align-items-center shadow-sm border-0"
                        role="alert"
                    >

                        {{-- Icono de advertencia --}}
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>

                        {{-- Texto del mensaje --}}
                        <div>
                            {{ session('error') }}
                        </div>

                    </div>

                @endif



                {{-- =================================================
                     TARJETA DE CREACIÓN DE GRUPOS
                ================================================== --}}
                <div class="card shadow-sm border-0">


                    {{-- -------------------------------------------------
                         ENCABEZADO DE LA TARJETA
                    -------------------------------------------------- --}}
                    <div class="card-header bg-white py-3 border-bottom">

                        {{-- Título de la tarjeta --}}
                        <h5 class="mb-0 fw-semibold text-primary">

                            {{-- Icono --}}
                            <i class="bi bi-plus-square-fill me-2"></i>

                            {{-- Texto --}}
                            Crear Nuevo Grupo

                        </h5>

                    </div>



                    {{-- -------------------------------------------------
                         CUERPO DE LA TARJETA
                    -------------------------------------------------- --}}
                    <div class="card-body p-4">


                        {{-- =================================================
                             AVISO DEL PERIODO
                             Indica en qué periodo se creará el grupo.
                        ================================================== --}}
                        <div class="alert alert-light border mb-4 d-flex align-items-center">

                            {{-- Icono --}}
                            <i class="bi bi-calendar-event text-primary me-2"></i>

                            {{-- Texto informativo --}}
                            <div>

                                El grupo se creará automáticamente en el periodo:

                                <strong>

                                    {{-- Si existe el periodo, muestra su nombre --}}
                                    @if(isset($periodoActual))

                                        <span class="text-success">
                                            {{ $periodoActual->nombre }}
                                        </span>

                                    {{-- Si no existe, muestra aviso --}}
                                    @else

                                        <span class="text-danger">
                                            No configurado
                                        </span>

                                    @endif

                                </strong>

                            </div>

                        </div>



                        {{-- =================================================
                             FORMULARIO PARA CREAR UN GRUPO
                             Conserva la ruta original.
                        ================================================== --}}
                        <form
                            action="{{ route('jefe.guardar_grupo') }}"
                            method="POST"
                        >

                            {{-- Token de seguridad de Laravel --}}
                            @csrf


                            {{-- =================================================
                                 CAMPOS DEL FORMULARIO
                            ================================================== --}}
                            <div class="row g-3">


                                {{-- -------------------------------------------------
                                     NOMBRE DEL GRUPO
                                -------------------------------------------------- --}}
                                <div class="col-md-6">

                                    {{-- Etiqueta --}}
                                    <label class="form-label fw-medium">

                                        Nombre del Grupo

                                        {{-- Campo obligatorio --}}
                                        <span class="text-danger">
                                            *
                                        </span>

                                    </label>

                                    {{-- Campo de texto --}}
                                    <input
                                        type="text"
                                        name="nombre"
                                        class="form-control"
                                        placeholder="Ej. ISC-1A"
                                        required
                                    >

                                    {{-- Ayuda --}}
                                    <div class="form-text small">

                                        Identificador único (Ej: ISC-1A, MEC-3B).

                                    </div>

                                </div>



                                {{-- -------------------------------------------------
                                     SEMESTRE
                                -------------------------------------------------- --}}
                                <div class="col-md-6">

                                    {{-- Etiqueta --}}
                                    <label class="form-label fw-medium">

                                        Semestre

                                        {{-- Campo obligatorio --}}
                                        <span class="text-danger">
                                            *
                                        </span>

                                    </label>

                                    {{-- Campo numérico --}}
                                    <input
                                        type="number"
                                        name="semestre"
                                        class="form-control"
                                        min="1"
                                        max="14"
                                        placeholder="Ej. 1"
                                        required
                                    >

                                </div>



                                {{-- -------------------------------------------------
                                     SEPARADOR VISUAL
                                -------------------------------------------------- --}}
                                <div class="col-12">

                                    <hr class="text-muted opacity-25 my-2">

                                </div>



                                {{-- -------------------------------------------------
                                     CARRERA
                                -------------------------------------------------- --}}
                                <div class="col-md-6">

                                    {{-- Etiqueta --}}
                                    <label class="form-label fw-medium">

                                        Carrera

                                        {{-- Campo obligatorio --}}
                                        <span class="text-danger">
                                            *
                                        </span>

                                    </label>

                                    {{-- Lista de carreras --}}
                                    <select
                                        name="id_carrera"
                                        class="form-select"
                                        required
                                    >

                                        {{-- Opción inicial --}}
                                        <option value="" selected disabled>

                                            -- Seleccione Carrera --

                                        </option>

                                        {{-- Recorre las carreras recibidas --}}
                                        @foreach($carreras as $carrera)

                                            <option
                                                value="{{ $carrera->id_carrera }}"
                                            >

                                                {{ $carrera->nombre }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>



                                {{-- -------------------------------------------------
                                     GENERACIÓN
                                -------------------------------------------------- --}}
                                <div class="col-md-6">

                                    {{-- Etiqueta --}}
                                    <label class="form-label fw-medium">

                                        Generación

                                        {{-- Campo obligatorio --}}
                                        <span class="text-danger">
                                            *
                                        </span>

                                    </label>

                                    {{-- Lista de generaciones --}}
                                    <select
                                        name="id_generacion"
                                        class="form-select"
                                        required
                                    >

                                        {{-- Opción inicial --}}
                                        <option value="" selected disabled>

                                            -- Seleccione Generación --

                                        </option>

                                        {{-- Recorre las generaciones recibidas --}}
                                        @foreach($generaciones as $gen)

                                            <option
                                                value="{{ $gen->id_generacion }}"
                                            >

                                                {{-- Año de inicio y fin --}}
                                                {{ $gen->ano_inicio }} - {{ $gen->ano_fin }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                            </div>



                            {{-- =================================================
                                 BOTONES DE ACCIÓN DEL FORMULARIO
                                 No se modifican sus estilos ni funcionamiento.
                            ================================================== --}}
                            <div class="d-flex justify-content-end gap-2 mt-4">


                                {{-- -------------------------------------------------
                                     BOTÓN PARA IR A ASIGNAR TUTORES
                                -------------------------------------------------- --}}
                                <a
                                    href="{{ route('jefe.grupos.asignar') }}"
                                    class="btn btn-outline-secondary"
                                >

                                    Ir a Asignar Tutores

                                </a>



                                {{-- -------------------------------------------------
                                     BOTÓN PARA GUARDAR EL GRUPO
                                -------------------------------------------------- --}}
                                <button
                                    type="submit"
                                    class="btn btn-primary px-4 fw-semibold"
                                >

                                    {{-- Icono de guardar --}}
                                    <i class="bi bi-save me-2"></i>

                                    {{-- Texto --}}
                                    Guardar Grupo

                                </button>


                            </div>


                        </form>


                    </div>


                </div>


            </div>

        </div>

    </div>

@endsection
