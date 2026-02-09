@extends('layouts.app')

@section('title','Alta de Alumnos')

{{-- CORRECCIÓN: Incluimos el subnav de Soporte --}}
@include('soporte._subnav')

@section('content')
<div class="card p-3">
	<div class="d-flex justify-content-between align-items-center">
		<div>
			<h4 class="mb-2">Alta de Alumnos</h4>
			<div class="text-muted mb-3">Registra nuevos alumnos y asígnalos a un grupo</div>
		</div>
	</div>
	<hr>

	{{-- Mensajes de feedback del sistema --}}
	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	@if(session('warning'))
		<div class="alert alert-warning alert-dismissible fade show" role="alert">
			{{ session('warning') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	@if(session('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session('error') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	@if($errors->any())
		<div class="alert alert-danger">
			<ul class="mb-0">
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	{{-- FORMULARIO 1: REGISTRO MANUAL --}}
	{{-- CORRECCIÓN: Apuntamos a la ruta de Soporte --}}
	<form action="{{ route('soporte.guardar_alumno') }}" method="POST">
		@csrf
		<div class="row g-2">
			<div class="col-md-6">
				<label class="form-label">Nombre(s)</label>
				<input class="form-control" name="nombre" value="{{ old('nombre') }}" required>
			</div>
			<div class="col-md-6">
				<label class="form-label">Apellido paterno</label>
				<input class="form-control" name="paterno" value="{{ old('paterno') }}" required>
			</div>
			<div class="col-md-6">
				<label class="form-label">Apellido materno</label>
				<input class="form-control" name="materno" value="{{ old('materno') }}">
			</div>
			<div class="col-md-6">
				<label class="form-label">No. control</label>
				<input class="form-control" name="num_control" value="{{ old('num_control') }}" required>
			</div>
			<div class="col-md-8">
				<label class="form-label">Correo</label>
				<input type="email" class="form-control" name="correo" value="{{ old('correo') }}" required>
			</div>
			<div class="col-md-4">
				<label class="form-label">Contraseña</label>
				<input type="password" class="form-control" name="contrasena" required>
			</div>
			
			<div class="col-md-6">
				<label class="form-label">Carrera</label>
				<select class="form-select" name="id_carrera_filtro" id="filtro_carrera">
					<option value="">Selecciona…</option>
					@foreach($carreras as $c) 
						<option value="{{ $c->id_carrera }}">{{ $c->nombre }}</option> 
					@endforeach
				</select>
			</div>
			
			<div class="col-md-6">
				<label class="form-label">Generación</label>
				<select class="form-select" name="id_generacion_filtro" id="filtro_generacion">
					<option value="">Selecciona…</option>
					@foreach($generaciones as $g) 
						<option value="{{ $g->id_generacion }}">{{ $g->ano_inicio }} - {{ $g->ano_fin }}</option> 
					@endforeach
				</select>
			</div>

			<div class="col-12">
				<label class="form-label">Grupo (Asignación final)</label>
				<select class="form-select" name="id_grupo" id="select_grupo" required>
					<option value="">Selecciona el grupo correcto…</option>
					@foreach($grupos as $grupo) 
						{{-- Mostramos info completa del grupo para evitar confusiones --}}
						<option value="{{ $grupo->id_grupo }}"
								data-carrera="{{ $grupo->id_carrera }}"
								data-generacion="{{ $grupo->id_generacion }}">
							{{ $grupo->nombre }} (Sem: {{ $grupo->semestre }} - {{ $grupo->carrera->nombre ?? 'Sin carrera' }})
						</option> 
					@endforeach
				</select>
				<div class="form-text">Asegúrate de que el grupo coincida con la carrera seleccionada arriba.</div>
				<div id="no-groups-msg" class="text-danger mt-1 small d-none">No se encontraron grupos con estos filtros.</div>
			</div>

			<div class="col-12 d-flex gap-2 mt-2 mb-4">
				<button class="btn btn-success" type="submit">Registrar alumno</button>
				<button class="btn btn-outline-secondary" type="reset" id="btn-reset">Limpiar</button>
			</div>
		</div>
	</form> 
	{{-- FIN DEL FORMULARIO 1 --}}

	<hr>

	{{-- FORMULARIO 2: CARGA MASIVA (Independiente) --}}
	{{-- CORRECCIÓN: Apuntamos a la ruta de Soporte --}}
	<form action="{{ route('soporte.importar_alumnos') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<p class="small text-muted text-center mt-3">
				Importa múltiples alumnos desde un archivo CSV.
			</p>
			
			<div class="alert alert-light border small">
				<strong>Columnas requeridas (en orden):</strong>
				<ol class="ps-3 mb-0">
					<li>Nombre</li>
					<li>Apellido Paterno</li>
					<li>Apellido Materno</li>
					<li>No. Control</li>
					<li>Correo</li>
					<li>Contraseña</li>
					<li>Nombre del Grupo (ej. "ISC-7A")</li>
					<li>Nombre Carrera (ej. "Ingeniería en Sistemas")</li>
					<li>Generación (ej. "2024-2028")</li>
				</ol>
			</div>

			<div class="mb-3">
				<label class="form-label small fw-bold">Archivo .csv</label>
				<input type="file" class="form-control" name="archivo_csv" accept=".csv, .txt" required>
			</div>
			<div class="d-grid">
				<button class="btn btn-info text-white" type="submit">
					<i class="bi bi-upload"></i> Importar Alumnos
				</button>
			</div>
	</form>
	{{-- FIN DEL FORMULARIO 2 --}}

</div>

{{-- SCRIPT PARA FILTRADO DINÁMICO --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
	const filtroCarrera = document.getElementById('filtro_carrera');
	const filtroGeneracion = document.getElementById('filtro_generacion');
	const selectGrupo = document.getElementById('select_grupo');
	const msgNoGroups = document.getElementById('no-groups-msg');
	
	// Guardamos una copia de todas las opciones originales
	const todasLasOpciones = Array.from(selectGrupo.options).slice(1); 

	function filtrarGrupos() {
		const carreraId = filtroCarrera.value;
		const generacionId = filtroGeneracion.value;
		
		// Limpiamos
		selectGrupo.innerHTML = '<option value="">Selecciona el grupo...</option>';
		
		let contadorVisible = 0;

		todasLasOpciones.forEach(option => {
			const grupoCarrera = option.getAttribute('data-carrera');
			const grupoGen = option.getAttribute('data-generacion');

			let mostrar = true;

			if (carreraId && grupoCarrera !== carreraId) mostrar = false;
			if (generacionId && grupoGen !== generacionId) mostrar = false;

			if (mostrar) {
				selectGrupo.appendChild(option.cloneNode(true));
				contadorVisible++;
			}
		});

		if (contadorVisible === 0) {
			msgNoGroups.classList.remove('d-none');
		} else {
			msgNoGroups.classList.add('d-none');
		}
	}

	if(filtroCarrera) filtroCarrera.addEventListener('change', filtrarGrupos);
	if(filtroGeneracion) filtroGeneracion.addEventListener('change', filtrarGrupos);
	
	const btnReset = document.getElementById('btn-reset');
	if(btnReset) {
		btnReset.addEventListener('click', function() {
			// Usamos setTimeout para que el reset del form se ejecute antes del filtro
			setTimeout(filtrarGrupos, 100); 
		});
	}
});
</script>
@endsection