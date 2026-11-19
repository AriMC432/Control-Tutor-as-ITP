@extends('layouts.app')

@section('title', 'Gestión de Asesores Académicos')

@include('jefe._subnav')

@section('content')

<style>
.asesorias-page {
    --azul: #174780;
    --azul-claro: #2589df;
    --azul-suave: #edf4fc;
    --borde: #d6e3f2;

    width: 100%;
    max-width: 1500px;
    margin: 0 auto;
    padding: 12px 20px 30px;
    color: #26374b;
    font-family: Arial, sans-serif;
}

.asesorias-page * {
    box-sizing: border-box;
}

.asesorias-page .encabezado {
    background: linear-gradient(120deg, #174780, #176b88);
    color: white;
    padding: 25px 30px;
    border-radius: 14px;
    margin-bottom: 20px;
}

.asesorias-page .encabezado h1 {
    font-size: clamp(24px, 3vw, 32px);
    font-weight: 750;
    margin: 0 0 8px;
}

.asesorias-page .encabezado p {
    margin: 0;
    font-size: 15px;
}

.asesorias-page .encabezado .eyebrow {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .5px;
    margin-bottom: 8px;
}

.asesorias-page .panel {
    background: white;
    border: 1px solid var(--borde);
    border-radius: 14px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(25, 48, 75, .04);
}

.asesorias-page .panel h2 {
    color: var(--azul);
    font-size: 21px;
    font-weight: 700;
    margin: 0 0 8px;
}

.asesorias-page .subtitulo {
    color: #718198;
    font-size: 14px;
    margin-bottom: 22px;
}

.asesorias-page .campo-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 7px;
    color: #203b5c;
}

.asesorias-page .form-control,
.asesorias-page .form-select {
    min-height: 43px;
    border: 1px solid #cbdced;
    border-radius: 7px;
    background-color: white;
    color: #26374b;
}

.asesorias-page .form-control:focus,
.asesorias-page .form-select:focus {
    border-color: var(--azul-claro);
    box-shadow: 0 0 0 3px rgba(37, 137, 223, .15);
}

.asesorias-page .campo-oculto {
    display: none;
}

.asesorias-page .campo-extra {
    margin-top: 12px;
}

.asesorias-page .btn-itp {
    background: var(--azul);
    color: white;
    border: 1px solid var(--azul);
    border-radius: 8px;
    padding: 11px 20px;
    font-weight: 600;
}

.asesorias-page .btn-itp:hover {
    background: var(--azul-claro);
    border-color: var(--azul-claro);
    color: white;
}

.asesorias-page .btn-outline-itp {
    background: white;
    color: var(--azul);
    border: 1px solid #b8cce2;
    border-radius: 8px;
    padding: 11px 20px;
    font-weight: 600;
}

.asesorias-page .btn-outline-itp:hover {
    background: var(--azul-suave);
}

.asesorias-page .dia-card {
    border: 1px solid var(--borde);
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 12px;
    background: white;
    transition: background .2s, border-color .2s;
}

.asesorias-page .dia-card.seleccionado {
    background: #edf5ff;
    border-color: #80b9f3;
}

.asesorias-page .dia-titulo {
    font-weight: 700;
    color: #203b5c;
}

.asesorias-page .dia-check {
    width: 19px;
    height: 19px;
    cursor: pointer;
    accent-color: var(--azul);
}

.asesorias-page .horas-dia {
    display: none;
    margin-top: 15px;
    padding-top: 14px;
    border-top: 1px solid #dce7f4;
}

.asesorias-page .dia-card.seleccionado .horas-dia {
    display: block;
}

.asesorias-page .resumen {
    background: #edf4fc;
    border: 1px solid #cbdced;
    border-radius: 11px;
    padding: 18px;
    height: 100%;
}

.asesorias-page .resumen h5 {
    color: var(--azul);
    font-weight: 700;
}

.asesorias-page .resumen-linea {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #d7e3f1;
    font-size: 14px;
}

.asesorias-page .resumen-linea:last-child {
    border-bottom: 0;
}

.asesorias-page .tabla {
    margin-bottom: 0;
}

.asesorias-page .tabla th {
    background: #174780;
    color: white;
    font-size: 12px;
    text-transform: uppercase;
    white-space: nowrap;
    padding: 12px;
}

.asesorias-page .tabla td {
    vertical-align: middle;
    font-size: 14px;
    padding: 13px 12px;
}

.asesorias-page .tabla tbody tr:hover {
    background: #edf5ff;
}

.asesorias-page .estado {
    display: inline-block;
    padding: 6px 11px;
    border-radius: 20px;
    background: #d9f5e5;
    color: #187447;
    font-size: 12px;
    font-weight: 700;
}

.asesorias-page .contador {
    background: #e4efff;
    color: #205da1;
    padding: 7px 12px;
    border-radius: 18px;
    font-size: 12px;
    font-weight: 700;
}

.asesorias-page .mensaje-vacio {
    color: #718198;
    font-size: 14px;
    padding: 12px 0;
}

.asesorias-page .mensaje-ayuda {
    font-size: 12px;
    color: #718198;
    margin-top: 5px;
}

@media (max-width: 700px) {
    .asesorias-page {
        padding: 10px 12px 25px;
    }

    .asesorias-page .encabezado,
    .asesorias-page .panel {
        padding: 18px;
    }

    .asesorias-page .resumen-linea {
        flex-direction: column;
        gap: 4px;
    }
}
</style>

<div class="asesorias-page">

    {{-- ENCABEZADO --}}
    <header class="encabezado">

        <div class="eyebrow">
            CONTROL DE TUTORÍAS ITP
        </div>

        <h1>Gestión de Asesores Académicos</h1>

        <p>
            Registro de docentes asesores y configuración
            de su disponibilidad semanal.
        </p>

    </header>

    {{-- FORMULARIO --}}
    <section class="panel">

        <h2>1. Datos del docente asesor</h2>

        <p class="subtitulo">
            Selecciona un docente y define el área en la que
            podrá brindar asesorías.
        </p>

        <form id="formAsesor">
    @csrf

<input type="hidden" id="asesorId" value="">

<div class="row g-3">

    {{-- NOMBRE DEL DOCENTE --}}
    <div class="col-12 col-md-6">

        <label for="nombreDocente" class="campo-label">
            Nombre del docente
        </label>

        <select id="nombreDocente"
                class="form-select"
                required>

            <option value="">
                Selecciona un docente
            </option>

            @foreach($asesores as $asesor)
                <option value="{{ $asesor->id }}">
                    {{ $asesor->nombre }}
                </option>
            @endforeach

            <option value="Otro">
                Otro docente
            </option>

        </select>

        {{-- NOMBRE MANUAL --}}
        <div id="campoNombreOtro"
             class="form-group campo-extra campo-oculto">

            <label for="nombreOtro" class="campo-label">
                Nombre del asesor
            </label>

            <input
                type="text"
                id="nombreOtro"
                name="nombreOtro"
                class="form-control"
                placeholder="Escribe el nombre del asesor"
            >

        </div>

    </div>

    {{-- CORREO INSTITUCIONAL --}}
    <div class="col-12 col-md-6">

        <label for="correoInstitucional" class="campo-label">
            Correo institucional
        </label>

        <input
            type="text"
            id="correoInstitucional"
            name="correoInstitucional"
            class="form-control"
            placeholder="Escribe el correo institucional"
            required
        >

    </div>

    {{-- ÁREA DE ASESORÍA --}}
    <div class="col-12 col-md-6">

        <label for="areaAsesoria" class="campo-label">
            Área de asesoría
        </label>

        <select id="areaAsesoria"
                class="form-select"
                required>

            <option value="">
                Selecciona un área
            </option>

            <option value="Programación">
                Programación
            </option>

            <option value="Bases de datos">
                Bases de datos
            </option>

            <option value="Redes">
                Redes
            </option>

            <option value="Ciberseguridad">
                Ciberseguridad
            </option>

            <option value="Otro">
                Otra área
            </option>

        </select>

        {{-- ÁREA MANUAL --}}
        <div id="campoAreaOtra"
             class="form-group campo-extra campo-oculto">

            <label for="areaOtra" class="campo-label">
                Registrar área de asesoría
            </label>

            <input
                type="text"
                id="areaOtra"
                class="form-control"
                placeholder="Escribe el área"
                maxlength="100"
            >

        </div>

    </div>

    {{-- MODALIDAD --}}
    <div class="col-12 col-md-6">

        <label for="modalidad" class="campo-label">
            Modalidad
        </label>

        <select id="modalidad"
                class="form-select"
                required>

            <option value="Presencial">
                Presencial
            </option>

            <option value="En línea">
                En línea
            </option>

            <option value="Ambas">
                Presencial y en línea
            </option>

        </select>

    </div>

</div>

<!-- LUGAR DE ASESORÍA -->
<div class="mt-4">

    <h2 class="h5 fw-bold">
        3. Lugar de asesoría
    </h2>

    <p class="text-muted">
        Selecciona el lugar donde se brindará la asesoría.
    </p>

    <div class="row g-3">

        <div class="col-12">

            <label class="form-label fw-bold">
                Tipo de lugar
            </label>

            <div class="d-flex flex-wrap gap-3">

                <label>
                    <input type="radio"
                           name="lugar_tipo"
                           value="Aula"
                           required>
                    Aula
                </label>

                <label>
                    <input type="radio"
                           name="lugar_tipo"
                           value="Cubículo">
                    Cubículo
                </label>

                <label>
                    <input type="radio"
                           name="lugar_tipo"
                           value="Laboratorio">
                    Laboratorio
                </label>

                <label>
                    <input type="radio"
                           name="lugar_tipo"
                           value="Otro">
                    Otro
                </label>

            </div>

        </div>

        <div class="col-12">

            <label for="lugar_detalle"
                   class="form-label fw-bold">
                Número o nombre del lugar
            </label>

            <input type="text"
                   name="lugar_detalle"
                   id="lugar_detalle"
                   class="form-control"
                   placeholder="Ejemplo: Aula 12, Cubículo 3 o Laboratorio de Sistemas"
                   maxlength="255"
                   required>

        </div>

    </div>

</div>
            {{-- DISPONIBILIDAD --}}
            <div class="mt-4">

                <h2>2. Disponibilidad por día</h2>

                <p class="subtitulo">

                    Activa cada día y configura su horario de manera
                    independiente. Cada día puede tener horas diferentes.

                </p>

                <div class="row g-3">

                    {{-- DÍAS --}}
                    <div class="col-12 col-lg-7">

                        @php
                            $dias = [
                                'Lunes' => ['09:00', '11:00'],
                                'Martes' => ['10:00', '12:00'],
                                'Miércoles' => ['15:00', '17:00'],
                                'Jueves' => ['10:00', '12:00'],
                                'Viernes' => ['08:00', '10:00'],
                                'Sábado' => ['09:00', '11:00'],
                            ];
                        @endphp

                        @foreach($dias as $dia => $horario)

                            <div class="dia-card">

                                <label class="d-flex align-items-center gap-3">

                                    <input type="checkbox"
                                           class="dia-check"
                                           data-dia="{{ $dia }}">

                                    <span class="dia-titulo">
                                        {{ $dia }}
                                    </span>

                                </label>

                                <div class="horas-dia">

                                    <div class="row g-3">

                                        <div class="col-6">

                                            <label class="campo-label">

                                                Hora de inicio

                                            </label>

                                            <input type="time"
                                                   class="form-control hora-inicio"
                                                   data-dia="{{ $dia }}"
                                                   value="{{ $horario[0] }}"
                                                   disabled>

                                        </div>

                                        <div class="col-6">

                                            <label class="campo-label">

                                                Hora de término

                                            </label>

                                            <input type="time"
                                                   class="form-control hora-fin"
                                                   data-dia="{{ $dia }}"
                                                   value="{{ $horario[1] }}"
                                                   disabled>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                    {{-- RESUMEN --}}
                    <div class="col-12 col-lg-5">

                        <div class="resumen">

                            <h5 class="mb-2">
                                Resumen semanal
                            </h5>

                            <p class="text-muted small">

                                Vista previa de los días y horarios seleccionados.

                            </p>

                            <div id="resumenHorarios">

                                <p class="mensaje-vacio mb-0">

                                    Selecciona al menos un día para ver
                                    la disponibilidad.

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- BOTONES --}}
           <div class="grupo-botones">

    <button
        type="submit"
        id="btnAgregar"
        class="btn btn-primary">
        + Agregar asesor
    </button>

    <button
        type="button"
        id="btnLimpiar"
        class="btn btn-secondary">
        Limpiar formulario
    </button>

    <button
        type="button"
        id="btnEliminar"
        class="btn btn-danger"
        disabled>
        Eliminar asesor
    </button>

    <button
        type="button"
        id="btnActualizar"
        class="btn btn-warning"
        disabled>
        Actualizar asesor
    </button>

</div>         
        
        </form>

    </section>

    {{-- CATÁLOGO --}}
    <section class="panel">

        <div class="d-flex flex-wrap justify-content-between
                    align-items-center gap-2 mb-3">

            <div>

                <h2>3. Catálogo de docentes asesores</h2>

                <p class="subtitulo mb-0">

                    Docentes registrados en esta vista.

                </p>

            </div>

            <span id="contadorAsesores">
                {{ $asesores->count() }}
                {{ $asesores->count() === 1 ? 'asesor' : 'asesores' }}
            </span>

        </div>

        <div class="table-responsive mt-3">

            <table class="table table-hover tabla">

                <thead>

                    <tr>

                        <th>Docente asesor</th>

                        <th>Correo institucional</th>

                        <th>Área</th>

                        <th>Días y horarios</th>

                        <th>Modalidad</th>

                        <th>Lugar de asesoría</th>

                        <th>Estado</th>

                    </tr>

                </thead>

                
                <tbody id="tablaAsesores">

                    @foreach($asesores as $asesor)

                        <tr data-id="{{ $asesor->id }}">

                            <td>
                                {{ $asesor->nombre }}
                            </td>

                            <td>
                                {{ $asesor->correo_institucional }}
                            </td>

                            <td>
                                {{ $asesor->area }}
                            </td>

                            <td>
                                @foreach($asesor->horarios ?? [] as $horario)

                                    {{ $horario['dia'] }}:
                                    {{ $horario['inicio'] }}–{{ $horario['fin'] }}

                                    @if(!$loop->last)
                                        ,
                                    @endif

                                @endforeach
                            </td>

                           {{-- MODALIDAD --}}
<td>
    {{ $asesor->modalidad }}
</td>

{{-- LUGAR DE ASESORÍA --}}
<td>
    <strong>{{ $asesor->lugar_tipo ?? 'Sin especificar' }}</strong>

    @if($asesor->lugar_detalle)
        <br>

        <small class="text-muted">
            {{ $asesor->lugar_detalle }}
        </small>
    @endif
</td>

{{-- ESTADO --}}
<td>
    <span class="estado">
        {{ $asesor->estado }}
    </span>
</td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </section>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const formulario = document.getElementById('formAsesor');
    const tabla = document.getElementById('tablaAsesores');
    const contador = document.getElementById('contadorAsesores');
    const resumen = document.getElementById('resumenHorarios');

    const nombreDocente = document.getElementById('nombreDocente');
    const nombreOtro = document.getElementById('nombreOtro');
    const campoNombreOtro = document.getElementById('campoNombreOtro');

    const correo = document.getElementById('correoInstitucional');

    const area = document.getElementById('areaAsesoria');
    const areaOtra = document.getElementById('areaOtra');
    const campoAreaOtra = document.getElementById('campoAreaOtra');

    const modalidad = document.getElementById('modalidad');
    const asesorId = document.getElementById('asesorId');
    // =====================================
// LUGAR DE ASESORÍA
// =====================================

const lugarDetalle = document.getElementById('lugar_detalle');

function obtenerLugarTipo() {
    const seleccionado = formulario.querySelector(
        'input[name="lugar_tipo"]:checked'
    );

    return seleccionado ? seleccionado.value : '';
}

function seleccionarLugarTipo(tipo) {
    const radios = formulario.querySelectorAll(
        'input[name="lugar_tipo"]'
    );

    radios.forEach(function (radio) {
        radio.checked = radio.value === tipo;
    });
}
    const token = formulario.querySelector('input[name="_token"]').value;

    const rutaBase = '/Jefe-Asesorias/asesores';

    const dias = [
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sábado',
        'Domingo'
    ];

        // =====================================
        // BOTONES DEL FORMULARIO
        // =====================================

        const botonGuardar = formulario.querySelector('button[type="submit"]');

        const botonAgregar = document.getElementById('btnAgregar');
        const botonLimpiar = document.getElementById('btnLimpiar');
        const botonEliminar = document.getElementById('btnEliminar');
        const botonActualizar = document.getElementById('btnActualizar');

        // Estado inicial de los botones
        botonEliminar.disabled = true;
        botonActualizar.disabled = true;
        // Eliminar asesor seleccionado
        botonEliminar.addEventListener('click', async function () {

            const id = asesorId.value;
        
            if (!id) {
                alert('Selecciona un asesor para eliminar.');
                return;
            }

            const confirmar = confirm(
                '¿Estás segura de que deseas eliminar este asesor?'
            );

            if (!confirmar) {
                return;
            }

            try {

                const respuesta = await fetch(rutaBase + '/' + id, {

                    method: 'DELETE',

                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    }

                });

                const resultado = await respuesta.json();

                if (!respuesta.ok) {

                    alert(resultado.message || 'No se pudo eliminar el asesor.');

                    return;

                }

                alert(resultado.message || 'Asesor eliminado correctamente.');

                window.location.reload();

            } catch (error) {

                console.error(error);

                alert('No fue posible conectar con Laravel.');

            }

        });
        // Actualizar asesor seleccionado
        botonActualizar.addEventListener('click', function () {

            if (!asesorId.value) {
                alert('Selecciona un asesor para actualizar.');
                return;
            }

            formulario.requestSubmit();

        });
    // =====================================
    // CONTADOR
    // =====================================

    function actualizarContador() {

        const total = tabla.querySelectorAll('tr[data-id]').length;

        contador.textContent =
            total + (total === 1 ? ' asesor' : ' asesores');

    }

    // =====================================
    // OBTENER CAMPOS DE HORARIOS
    // =====================================

    function obtenerHorarios() {

        const horarios = [];

        document.querySelectorAll('.dia-check:checked').forEach(function (check) {

            const dia = check.dataset.dia;

            const inicio = document.querySelector(
                '.hora-inicio[data-dia="' + dia + '"]'
            );

            const fin = document.querySelector(
                '.hora-fin[data-dia="' + dia + '"]'
            );

            if (inicio && fin) {

                horarios.push({
                    dia: dia,
                    inicio: inicio.value,
                    fin: fin.value
                });

            }

        });

        horarios.sort(function (a, b) {
            return dias.indexOf(a.dia) - dias.indexOf(b.dia);
        });

        return horarios;

    }

    // =====================================
    // RESUMEN
    // =====================================

    function actualizarResumen() {

        resumen.replaceChildren();

        const horarios = obtenerHorarios();

        if (!horarios.length) {

            const mensaje = document.createElement('p');

            mensaje.textContent =
                'Selecciona al menos un día para ver la disponibilidad.';

            mensaje.className = 'mensaje-vacio mb-0';

            resumen.appendChild(mensaje);

            return;
        }

        horarios.forEach(function (horario) {

            const linea = document.createElement('div');

            linea.className = 'resumen-linea';

            const dia = document.createElement('strong');

            dia.textContent = horario.dia;

            const hora = document.createElement('span');

            hora.textContent =
                horario.inicio + ' – ' + horario.fin;

            linea.appendChild(dia);

            linea.appendChild(hora);

            resumen.appendChild(linea);

        });

    }

    // =====================================
    // ACTIVAR HORARIOS
    // =====================================

    document.querySelectorAll('.dia-check').forEach(function (check) {

        check.addEventListener('change', function () {

            const tarjeta = check.closest('.dia-card');

            tarjeta.classList.toggle('seleccionado', check.checked);

            tarjeta.querySelectorAll('input[type="time"]').forEach(function (input) {

                input.disabled = !check.checked;

                input.required = check.checked;

            });

            actualizarResumen();

        });

    });

    document.querySelectorAll('.hora-inicio, .hora-fin').forEach(function (input) {

        input.addEventListener('input', actualizarResumen);

        input.addEventListener('change', actualizarResumen);

    });

    // =====================================
    // CAMPOS OTRO
    // =====================================

    nombreDocente.addEventListener('change', function () {

        const otro = nombreDocente.value === 'otro';

        campoNombreOtro.style.display = otro ? 'block' : 'none';

        nombreOtro.required = otro;

        if (!otro) {
            nombreOtro.value = '';
        }

    });
// =====================================
// CAMPO PARA OTRA ÁREA
// =====================================

area.addEventListener('change', function () {

    if (area.value === 'Otro') {

        campoAreaOtra.style.display = 'block';

        areaOtra.required = true;
        areaOtra.disabled = false;

    } else {

        campoAreaOtra.style.display = 'none';

        areaOtra.required = false;
        areaOtra.disabled = true;

        areaOtra.value = '';

    }

});
        

    // =====================================
    // PREPARAR FORMULARIO
    // =====================================

    function prepararNuevo() {

        asesorId.value = '';

        // Deshabilitar botones de edición
        botonEliminar.disabled = true;
        botonActualizar.disabled = true;

        // Habilitar botón agregar
        botonAgregar.disabled = false;

        formulario.reset();
        // Limpiar lugar de asesoría
        seleccionarLugarTipo('');

        lugarDetalle.value = '';
        asesorId.value = '';

        // Restablecer texto del botón Agregar
        botonAgregar.textContent = '+ Agregar asesor';
        botonGuardar.textContent = '+ Agregar asesor';
        
        nombreDocente.disabled = false;

        document.querySelectorAll('.dia-card').forEach(function (tarjeta) {

            tarjeta.classList.remove('seleccionado');

        });

        document.querySelectorAll('.dia-check').forEach(function (check) {

            check.checked = false;

        });

        document.querySelectorAll('input[type="time"]').forEach(function (input) {

            input.disabled = true;

            input.required = false;

        });

        campoNombreOtro.style.display = 'none';

        campoAreaOtra.style.display = 'none';

        nombreOtro.required = false;

        areaOtra.required = false;

        actualizarResumen();

    }

    // =====================================
// PRECARGAR ASESOR
// =====================================

async function cargarAsesor(id) {

    try {

        const respuesta = await fetch(rutaBase + '/' + id, {

            headers: {
                'Accept': 'application/json'
            }

        });

        const asesor = await respuesta.json();

        if (!respuesta.ok) {

            alert('No se pudo recuperar el asesor.');

            return;

        }

        // =====================================
        // IDENTIFICAR ASESOR SELECCIONADO
        // =====================================

        asesorId.value = asesor.id;

        // Activar botones para asesor seleccionado
        botonAgregar.disabled = true;
        botonActualizar.disabled = false;
        botonEliminar.disabled = false;

        // Restablecer texto de botones
        botonAgregar.textContent = '+ Agregar asesor';
        botonGuardar.textContent = 'Actualizar asesor';

        // =====================================
        // CARGAR DOCENTE
        // =====================================

        nombreDocente.disabled = false;

        nombreDocente.value = String(asesor.id);

        campoNombreOtro.style.display = 'none';

        nombreOtro.required = false;

        nombreOtro.value = '';

        // =====================================
        // CARGAR CORREO
        // =====================================

        correo.value = asesor.correo_institucional || '';

        // =====================================
        // CARGAR ÁREA
        // =====================================

        const opcionesArea = Array.from(area.options);

        const areaExiste = opcionesArea.some(function (opcion) {

            return opcion.value === asesor.area;

        });

        if (areaExiste) {

            area.value = asesor.area;

            campoAreaOtra.style.display = 'none';

            areaOtra.value = '';

            areaOtra.required = false;

        } else {

            area.value = 'otro';

            campoAreaOtra.style.display = 'block';

            areaOtra.value = asesor.area || '';

            areaOtra.required = true;

        }

        // =====================================
        // CARGAR MODALIDAD
        // =====================================

        modalidad.value = asesor.modalidad || '';

        // =====================================
        // CARGAR LUGAR DE ASESORÍA
        // =====================================

        seleccionarLugarTipo(asesor.lugar_tipo || '');

        lugarDetalle.value = asesor.lugar_detalle || '';

        // =====================================
        // LIMPIAR HORARIOS ANTERIORES
        // =====================================

        document.querySelectorAll('.dia-check').forEach(function (check) {

            check.checked = false;

            const tarjeta = check.closest('.dia-card');

            tarjeta.classList.remove('seleccionado');

            tarjeta.querySelectorAll('input[type="time"]').forEach(function (input) {

                input.disabled = true;

                input.required = false;

                input.value = '';

            });

        });

        // =====================================
        // CARGAR HORARIOS GUARDADOS
        // =====================================

        (asesor.horarios || []).forEach(function (horario) {

            const check = document.querySelector(
                '.dia-check[data-dia="' + horario.dia + '"]'
            );

            const inicio = document.querySelector(
                '.hora-inicio[data-dia="' + horario.dia + '"]'
            );

            if (check && inicio) {

                // Seleccionar día
                check.checked = true;

                const tarjeta = check.closest('.dia-card');

                tarjeta.classList.add('seleccionado');

                // Activar hora de inicio
                inicio.disabled = false;

                inicio.required = true;

                inicio.value = horario.inicio || '';

                // Activar hora de fin
                const campoFin = tarjeta.querySelector('.hora-fin');

                if (campoFin) {

                    campoFin.disabled = false;

                    campoFin.required = true;

                    campoFin.value = horario.fin || '';

                }

            }

        });

        // =====================================
        // ACTUALIZAR RESUMEN
        // =====================================

        actualizarResumen();

        // =====================================
        // DESPLAZAR AL FORMULARIO
        // =====================================

        formulario.scrollIntoView({

            behavior: 'smooth',

            block: 'start'

        });

    } catch (error) {

        console.error(error);

        alert('Error al cargar los datos del asesor.');

    }

}
 
        // =====================================
        // SELECCIONAR DOCENTE EN COMBOBOX
        // =====================================

        nombreDocente.addEventListener('change', function () {

            // Si selecciona "Otro"
            if (nombreDocente.value === 'otro') {

                asesorId.value = '';

                // Habilitar Agregar
                botonAgregar.disabled = false;

                // Deshabilitar Actualizar y Eliminar
                botonActualizar.disabled = true;
                botonEliminar.disabled = true;

                botonAgregar.textContent = '+ Agregar asesor';
                botonGuardar.textContent = '+ Agregar asesor';

                campoNombreOtro.style.display = 'block';
                nombreOtro.required = true;

                correo.value = '';

                return;
            }

            // Si no selecciona ningún docente
            if (!nombreDocente.value) {

                prepararNuevo();

                return;
            }

            // Si selecciona un docente existente
            cargarAsesor(nombreDocente.value);

        });
    // =====================================
    // GUARDAR / ACTUALIZAR
    // =====================================

    formulario.addEventListener('submit', async function (evento) {

        evento.preventDefault();

        const horarios = obtenerHorarios();

        if (!horarios.length) {

            alert('Selecciona al menos un día de disponibilidad.');

            return;

        }

        for (const horario of horarios) {

            if (!horario.inicio || !horario.fin) {

                alert('Completa las horas de ' + horario.dia);

                return;

            }

            if (horario.inicio >= horario.fin) {

                alert('La hora de fin debe ser posterior a la de inicio.');

                return;

            }

        }

        const nombre = nombreDocente.value === 'otro'
            ? nombreOtro.value.trim()
            : nombreDocente.options[nombreDocente.selectedIndex].textContent.trim();

        const areaFinal = area.value === 'Otro'
            ? areaOtra.value.trim()
            : area.value.trim();

        if (!nombre || !correo.value.trim() || !areaFinal) {

            alert('Completa todos los campos.');

            return;

        }

        const datos = {

            nombre: nombre,

            correo_institucional: correo.value.trim().toLowerCase(),

            area: areaFinal,

            horarios: horarios,

            modalidad: modalidad.value,

            lugar_tipo: obtenerLugarTipo(),

            lugar_detalle: lugarDetalle.value.trim()

        };

        const id = asesorId.value;

        const url = id ? rutaBase + '/' + id : rutaBase;

        const metodo = id ? 'PUT' : 'POST';

        try {

            const respuesta = await fetch(url, {

                method: metodo,

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },

                body: JSON.stringify(datos)

            });

            const resultado = await respuesta.json();

            if (!respuesta.ok) {

                const errores = resultado.errors
                    ? Object.values(resultado.errors).flat().join('\n')
                    : resultado.message;

                alert(errores || 'Ocurrió un error.');

                return;

            }

            alert(resultado.message);

            window.location.reload();

        } catch (error) {

            console.error(error);

            alert('No fue posible conectar con Laravel.');

        }

    });

    // =====================================
    // LIMPIAR
    // =====================================

    formulario.addEventListener('reset', function () {

        setTimeout(function () {

            asesorId.value = '';
            
            // Restablecer botones
            botonAgregar.disabled = false;
            botonEliminar.disabled = true;
            botonActualizar.disabled = true;

            // Restablecer texto del botón
            botonAgregar.textContent = '+ Agregar asesor';

            botonGuardar.textContent = '+ Agregar asesor';

            nombreDocente.disabled = false;

            campoNombreOtro.style.display = 'none';

            campoAreaOtra.style.display = 'none';

            nombreOtro.required = false;

            areaOtra.required = false;

            document.querySelectorAll('.dia-card').forEach(function (tarjeta) {

                tarjeta.classList.remove('seleccionado');

            });

            document.querySelectorAll('.dia-check').forEach(function (check) {

                check.checked = false;

            });

            document.querySelectorAll('input[type="time"]').forEach(function (input) {

                input.disabled = true;

                input.required = false;

            });

            actualizarResumen();

        }, 0);

    });
    
    // Limpiar formulario
    botonLimpiar.addEventListener('click', function () {
    prepararNuevo();
    });

    actualizarContador();

    actualizarResumen();

});
</script>

@endsection