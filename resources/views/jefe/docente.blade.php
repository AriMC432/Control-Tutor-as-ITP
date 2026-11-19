
@extends('layouts.app')

{{-- Título de la pestaña --}}
@section('title', 'Alta de Usuarios')

{{-- Contenido principal --}}
@section('content')

    {{-- Menú de navegación del jefe de departamento --}}
    @include('jefe._subnav')

    {{-- Contenedor principal --}}
    <div class="container pb-4">

        {{-- Tarjeta de registro --}}
        <div class="card shadow-sm border-0 p-3">

            {{-- ========================================= --}}
            {{-- ENCABEZADO: TÍTULO Y PERIODO ACTIVO      --}}
            {{-- ========================================= --}}

            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">

                {{-- Título y descripción --}}
                <div>

                    <h4 class="mb-2">
                        Alta de Usuarios
                    </h4>

                    <div class="text-muted">
                        Registra usuarios nuevos
                    </div>

                </div>

                {{-- Periodo activo en la esquina superior derecha --}}
                @if(isset($periodoActual) && $periodoActual)

                    <span class="badge bg-info fs-6 p-2 shadow-sm">

                        <i class="bi bi-calendar-check me-1"></i>

                        Periodo activo:
                        {{ $periodoActual->nombre }}

                    </span>

                @endif

            </div>

            {{-- Separador del encabezado --}}
            <hr>

            {{-- ========================================= --}}
            {{-- MENSAJE DE REGISTRO EXITOSO               --}}
            {{-- ========================================= --}}

            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show"
                     role="alert">

                    {{ session('success') }}

                    {{-- Botón para cerrar el mensaje --}}
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Cerrar">
                    </button>

                </div>

            @endif

            {{-- ========================================= --}}
            {{-- MENSAJES DE ERROR                         --}}
            {{-- ========================================= --}}

            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        {{-- Mostrar todos los errores --}}
                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- ========================================= --}}
            {{-- FORMULARIO DE ALTA DE USUARIOS             --}}
            {{-- ========================================= --}}

            <form action="{{ route('jefe.docentes.store') }}"
                  method="POST">

                {{-- Protección CSRF --}}
                @csrf

                {{-- Distribución de campos --}}
                <div class="row g-2">

                    {{-- ================================= --}}
                    {{-- NOMBRE                              --}}
                    {{-- ================================= --}}

                    <div class="col-md-6">

                        <label class="form-label">
                            Nombre(s)
                        </label>

                        <input type="text"
                               class="form-control"
                               name="nombre"
                               value="{{ old('nombre') }}"
                               required>

                    </div>

                    {{-- ================================= --}}
                    {{-- APELLIDO PATERNO                    --}}
                    {{-- ================================= --}}

                    <div class="col-md-6">

                        <label class="form-label">
                            Apellido paterno
                        </label>

                        <input type="text"
                               class="form-control"
                               name="paterno"
                               value="{{ old('paterno') }}"
                               required>

                    </div>

                    {{-- ================================= --}}
                    {{-- APELLIDO MATERNO                    --}}
                    {{-- ================================= --}}

                    <div class="col-md-6">

                        <label class="form-label">
                            Apellido materno
                        </label>

                        <input type="text"
                               class="form-control"
                               name="materno"
                               value="{{ old('materno') }}">

                    </div>

                    {{-- ================================= --}}
                    {{-- MATRÍCULA                           --}}
                    {{-- ================================= --}}

                    <div class="col-md-6">

                        <label class="form-label">
                            Matrícula
                        </label>

                        <input type="text"
                               class="form-control"
                               name="num_control"
                               value="{{ old('num_control') }}"
                               required>

                    </div>

                    {{-- ================================= --}}
                    {{-- CORREO INSTITUCIONAL                --}}
                    {{-- ================================= --}}

                    <div class="col-md-8">

                        <label class="form-label">
                            Correo institucional
                        </label>

                        <input type="email"
                               class="form-control"
                               name="correo"
                               value="{{ old('correo') }}"
                               required>

                    </div>

                    {{-- ================================= --}}
                    {{-- CONTRASEÑA                          --}}
                    {{-- ================================= --}}

                    <div class="col-md-4">

                        <label class="form-label">
                            Contraseña
                        </label>

                        <input type="password"
                               class="form-control"
                               name="contrasena"
                               required>

                    </div>

                    {{-- ================================= --}}
                    {{-- SELECCIÓN DE ROL                    --}}
                    {{-- ================================= --}}

                    <div class="col-12">

                        <label class="form-label">
                            Rol
                        </label>

                        <select class="form-select"
                                name="id_rol"
                                required>

                            {{-- Opción inicial --}}
                            <option value="">
                                Selecciona un rol
                            </option>

                            {{-- Recorrer roles enviados por el controlador --}}
                            @foreach($roles as $rol)

                                <option value="{{ $rol->id_rol }}"
                                    {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>

                                    {{ $rol->nombre }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- ================================= --}}
                    {{-- BOTONES DE ACCIÓN                    --}}
                    {{-- ================================= --}}

                    <div class="col-12 d-flex justify-content-end
                                align-items-center gap-2 mt-3">

                        {{-- Registrar usuario --}}
                        <button class="btn btn-success btn-sm px-3"
                                type="submit">

                            <i class="bi bi-person-plus me-1"></i>

                            Registrar usuario

                        </button>

                        {{-- Limpiar formulario --}}
                        <button class="btn btn-outline-secondary btn-sm px-3"
                                type="reset">

                            <i class="bi bi-arrow-counterclockwise me-1"></i>

                            Limpiar

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
