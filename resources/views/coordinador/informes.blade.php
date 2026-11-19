@extends('layouts.app')

@section('title', 'Informes de tutores')

@section('content')

    @includeWhen(true, 'coordinador._subnav')
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

    <div class="row g-3">

        <div class="col-12 col-lg-5">
            <div class="card p-3 h-100">

                <h5 class="mb-2">Cargar informe</h5>

                <div class="text-muted">
                    Recibe informes individuales (PDF/Excel) por tutor o grupo
                </div>

                <hr>

                <form
                    action="{{ route('coord.informes.subir') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="d-grid gap-3"
                >

                    @csrf

                    <div>
                        <label class="form-label">Tutor</label>

                        <select
                            class="form-select"
                            name="id_docente"
                            required
                        >
                            <option value="">Selecciona…</option>

                            
                        @foreach($tutores as $t)
                            <option value="{{ $t->id_docente }}">
                                {{ $t->nombre }} {{ $t->paterno }}
                            </option>
                        @endforeach


                        </select>
                    </div>

                    <div>
                        <label class="form-label">
                            Mes / Periodo
                        </label>

                        <input
                            type="month"
                            class="form-control"
                            name="periodo"
                            required
                        >
                    </div>

                    
<div>
    <label class="form-label">
        Archivo del informe
    </label>

    <input
        type="file"
        class="form-control"
        name="informe"
        accept=".pdf,.xlsx,.xls"
        required
    >

    <div class="mt-2 p-3 rounded border bg-light">
        <div class="d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-info-circle-fill text-primary"></i>
            <strong>Formatos de archivo permitidos</strong>
        </div>

        <div class="d-flex flex-wrap gap-2 mb-2">
            <span class="badge bg-danger">PDF</span>
            <span class="badge bg-success">Excel XLSX</span>
            <span class="badge bg-success">Excel XLS</span>
        </div>

        <small class="text-muted d-block">
            Puedes subir documentos PDF o archivos de Excel.
            El tamaño máximo permitido es de 10 MB.
        </small>
    </div>
</div>


                    <div class="d-flex gap-2">

                        <button class="btn btn-success">
                            Subir
                        </button>

                        <button
                            class="btn btn-outline"
                            type="reset"
                        >
                            Limpiar
                        </button>

                    </div>

                </form>

            </div>
        </div>


        <div class="col-12 col-lg-7">

            <div class="card p-3 h-100">

                <h5 class="mb-2">
                    Informes recibidos
                </h5>

                <div class="text-muted">
                    Valida y marca como aceptado/rechazado
                </div>

                <hr>

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tutor</th>
                                <th>Periodo</th>
                                <th>Archivo</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                    
<tbody>

    @forelse($informes as $inf)

        <tr>
            {{-- Fecha de recepción --}}
            <td>
                {{ $inf->created_at
                    ? \Carbon\Carbon::parse($inf->created_at)->format('d/m/Y')
                    : '—' }}
            </td>

            {{-- Nombre del tutor --}}
            <td>
                {{ $inf->nombre }} {{ $inf->paterno }}
            </td>

            {{-- Periodo del informe --}}
            <td>
                {{ $inf->periodo }}
            </td>

            {{-- Archivo --}}
            <td>
                <a
                    href="{{ asset('storage/' . $inf->archivo) }}"
                    target="_blank"
                    class="btn btn-outline btn-sm"
                >
                    <i class="bi bi-download"></i>
                    Descargar
                </a>
            </td>

            {{-- Estatus --}}
            <td>
                @if($inf->estatus == 'Aceptado')
                    <span class="badge bg-success">Aceptado</span>
                @elseif($inf->estatus == 'Rechazado')
                    <span class="badge bg-danger">Rechazado</span>
                @else
                    <span class="badge bg-warning text-dark">
                        En revisión
                    </span>
                @endif
            </td>

          
{{-- Acciones --}}
<td>
    @if($inf->estatus == 'En revisión')

        <div class="d-flex gap-2">

            {{-- Aceptar informe --}}
            <form
                action="{{ route('coord.informes.estatus', $inf->id_informe) }}"
                method="POST"
                onsubmit="return confirm('¿Estás seguro de aceptar este informe?');"
            >
                @csrf
                @method('PATCH')

                <input
                    type="hidden"
                    name="estatus"
                    value="Aceptado"
                >

                <button type="submit" class="btn btn-success btn-sm">
                    <i class="bi bi-check-circle"></i>
                    Aceptar
                </button>
            </form>

            {{-- Rechazar informe --}}
            <form
                action="{{ route('coord.informes.estatus', $inf->id_informe) }}"
                method="POST"
                onsubmit="return confirm('¿Estás seguro de rechazar este informe?');"
            >
                @csrf
                @method('PATCH')

                <input
                    type="hidden"
                    name="estatus"
                    value="Rechazado"
                >

                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-x-circle"></i>
                    Rechazar
                </button>
            </form>

        </div>

    @else

        <span class="text-muted">
            Sin acciones
        </span>

    @endif
</td>

        </tr>

    @empty

        <tr>
            <td colspan="6" class="text-center text-muted py-4">
                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                Todavía no hay informes registrados.
            </td>
        </tr>

    @endforelse

</tbody>

                    </table>

                </div>

            </div>

        </div>


        <div class="col-12">

            <div class="card p-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="mb-1">
                            Consolidado del área
                        </h5>

                        <div class="text-muted">
                            Genera y descarga el informe global del periodo
                        </div>

                    </div>
<form
    action="{{ route('coord.informes.consolidado') }}"
    method="GET"
    onsubmit="return confirm('¿Deseas generar y descargar el consolidado de informes en PDF del periodo activo?');"
>
    <button type="submit" class="btn btn-success">
        <i class="bi bi-file-earmark-pdf"></i>
        Generar y descargar PDF
    </button>
</form>

                </div>

            </div>

        </div>

    </div>

@endsection