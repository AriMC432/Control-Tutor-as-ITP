@extends('layouts.app')

@section('title', 'Editar Foto de Perfil')

{{-- ========================================================= --}}
{{-- MENÚ DE NAVEGACIÓN DEL ALUMNO                             --}}
{{-- ========================================================= --}}
@includeWhen(true, 'alumno._subnav')


@section('content')

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-12 col-md-8 col-lg-6">

            {{-- ================================================= --}}
            {{-- TARJETA PRINCIPAL                                 --}}
            {{-- ================================================= --}}

            <div class="card p-4 shadow-sm border-0">

                {{-- Título --}}
                <h4 class="text-center mb-4 fw-bold">
                    <i class="bi bi-camera-fill me-2 text-primary"></i>
                    Editar foto de perfil
                </h4>


                {{-- ================================================= --}}
                {{-- FOTO ACTUAL                                      --}}
                {{-- ================================================= --}}

                <div class="text-center mb-4">

                    <div
                        class="foto-container"
                        style="
                            width: 200px;
                            height: 200px;
                            margin: 0 auto;
                            position: relative;
                        "
                    >

                        {{-- Foto del estudiante --}}
                        <img
                            id="fotoPreview"
                            src="{{ $estudiante->foto_url }}"
                            alt="Foto de perfil"
                            class="profile-img"
                            style="
                                width: 200px;
                                height: 200px;
                                object-fit: cover;
                                border-radius: 50%;
                                display: block;
                            "
                            onerror="
                                this.onerror=null;
                                this.src='{{ asset('images/default-avatar.png') }}';
                            "
                        >

                    </div>

                    <p class="text-muted mt-3 mb-0">
                        Foto actual
                    </p>

                </div>


                {{-- ================================================= --}}
                {{-- MENSAJES DE ERROR                                --}}
                {{-- ================================================= --}}

                @if($errors->any())

                    <div class="alert alert-danger shadow-sm">

                        <div class="fw-bold mb-2">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            No se pudo actualizar la foto
                        </div>

                        <ul class="mb-0 ps-3">

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- MENSAJE DE ÉXITO                                 --}}
                {{-- ================================================= --}}

                @if(session('success'))

                    <div class="alert alert-success shadow-sm">

                        <i class="bi bi-check-circle-fill me-2"></i>

                        {{ session('success') }}

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- FORMULARIO PARA SUBIR FOTO                       --}}
                {{-- ================================================= --}}

                <form
                    action="{{ route('alumno.perfil.actualizar-foto') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="fotoForm"
                >

                    @csrf


                    {{-- ================================================= --}}
                    {{-- SELECCIONAR FOTO                                 --}}
                    {{-- ================================================= --}}

                    <div class="mb-3">

                        <label
                            for="foto"
                            class="form-label fw-semibold"
                        >
                            Seleccionar nueva foto
                        </label>


                        <input
                            type="file"
                            class="form-control @error('foto') is-invalid @enderror"
                            id="foto"
                            name="foto"
                            accept="image/jpeg,image/png,image/gif,image/webp"
                            required
                        >


                        <small class="text-muted d-block mt-2">

                            <i class="bi bi-info-circle me-1"></i>

                            Formatos permitidos:
                            JPG, PNG, GIF o WEBP.
                            Tamaño máximo: 2 MB.

                        </small>


                        @error('foto')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- ================================================= --}}
                    {{-- VISTA PREVIA DE LA FOTO NUEVA                   --}}
                    {{-- ================================================= --}}

                    <div
                        id="previewContainer"
                        class="text-center mt-4"
                        style="display: none;"
                    >

                        <p class="fw-semibold text-primary mb-2">
                            Vista previa
                        </p>


                        <img
                            id="nuevaFotoPreview"
                            src=""
                            alt="Vista previa de la nueva foto"
                            style="
                                width: 150px;
                                height: 150px;
                                object-fit: cover;
                                border-radius: 50%;
                                border: 4px solid #ffffff;
                                box-shadow:
                                    0 0 0 2px #0d6efd,
                                    0 5px 18px rgba(13, 110, 253, .25);
                            "
                        >

                    </div>


                    {{-- ================================================= --}}
                    {{-- BOTONES                                          --}}
                    {{-- ================================================= --}}

                    <div class="d-flex justify-content-between mt-4 gap-3">

                        {{-- Cancelar --}}
                        <a
                            href="{{ route('alumno.perfil') }}"
                            class="btn btn-secondary px-4"
                        >

                            <i class="bi bi-arrow-left me-2"></i>

                            Cancelar

                        </a>


                        {{-- Subir --}}
                        <button
                            type="submit"
                            class="btn btn-primary px-4"
                            id="btnSubirFoto"
                        >

                            <i class="bi bi-upload me-2"></i>

                            Subir Foto

                        </button>

                    </div>

                </form>


                {{-- ================================================= --}}
                {{-- ELIMINAR FOTO                                    --}}
                {{-- ================================================= --}}

                @if($estudiante->foto)

                    <hr class="my-4">


                    <form
                        action="{{ route('alumno.perfil.eliminar-foto') }}"
                        method="POST"
                        onsubmit="
                            return confirm(
                                '¿Estás seguro de eliminar tu foto de perfil?'
                            );
                        "
                    >

                        @csrf


                        <button
                            type="submit"
                            class="btn btn-outline-danger w-100"
                        >

                            <i class="bi bi-trash me-2"></i>

                            Eliminar foto actual

                        </button>

                    </form>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- JAVASCRIPT                                                --}}
{{-- ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const inputFoto = document.getElementById('foto');

    const previewContainer =
        document.getElementById('previewContainer');

    const nuevaFotoPreview =
        document.getElementById('nuevaFotoPreview');

    const fotoForm =
        document.getElementById('fotoForm');

    const btnSubirFoto =
        document.getElementById('btnSubirFoto');


    /* ========================================================= */
    /* VISTA PREVIA DE LA FOTO SELECCIONADA                     */
    /* ========================================================= */

    inputFoto.addEventListener('change', function () {

        const archivo = this.files[0];


        // Si no seleccionó archivo
        if (!archivo) {

            previewContainer.style.display = 'none';

            nuevaFotoPreview.src = '';

            return;
        }


        // Validar que sea una imagen
        if (!archivo.type.startsWith('image/')) {

            alert('El archivo seleccionado no es una imagen.');

            this.value = '';

            previewContainer.style.display = 'none';

            return;
        }


        // Validar tamaño máximo: 2 MB
        const maxSize = 2 * 1024 * 1024;

        if (archivo.size > maxSize) {

            alert('La imagen no puede superar los 2 MB.');

            this.value = '';

            previewContainer.style.display = 'none';

            return;
        }


        // Crear vista previa
        const reader = new FileReader();


        reader.onload = function (evento) {

            nuevaFotoPreview.src = evento.target.result;

            previewContainer.style.display = 'block';

        };


        reader.readAsDataURL(archivo);

    });


    /* ========================================================= */
    /* EVITAR DOBLE ENVÍO                                       */
    /* ========================================================= */

    fotoForm.addEventListener('submit', function () {

        btnSubirFoto.disabled = true;

        btnSubirFoto.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2"></span>' +
            'Subiendo...';

    });

});

</script>

@endsection