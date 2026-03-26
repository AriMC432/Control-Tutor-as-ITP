<?php $__env->startSection('title','Alta de Alumnos'); ?>

<?php echo $__env->make('jefe._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-3">
  <div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-2">Alta de Alumnos</h4>
        <div class="text-muted mb-3">Registra nuevos alumnos y asígnalos a un grupo</div>
    </div>
  </div>
  <hr>

  
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('warning')): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo e(session('warning')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

  
  <form action="<?php echo e(route('jefe.guardar_alumno')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="row g-2">
      <div class="col-md-6">
        <label class="form-label">Nombre(s)</label>
        <input class="form-control" name="nombre" value="<?php echo e(old('nombre')); ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Apellido paterno</label>
        <input class="form-control" name="paterno" value="<?php echo e(old('paterno')); ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Apellido materno</label>
        <input class="form-control" name="materno" value="<?php echo e(old('materno')); ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">No. control</label>
        <input class="form-control" name="num_control" value="<?php echo e(old('num_control')); ?>" required>
      </div>
      <div class="col-md-8">
        <label class="form-label">Correo</label>
        <input type="email" class="form-control" name="correo" value="<?php echo e(old('correo')); ?>" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Contraseña</label>
        <input type="password" class="form-control" name="contrasena" required>
      </div>
      
      <div class="col-md-6">
        <label class="form-label">Carrera</label>
        <select class="form-select" name="id_carrera_filtro" id="filtro_carrera">
          <option value="">Selecciona…</option>
          <?php $__currentLoopData = $carreras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
            <option value="<?php echo e($c->id_carrera); ?>"><?php echo e($c->nombre); ?></option> 
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      
      <div class="col-md-6">
        <label class="form-label">Generación</label>
        <select class="form-select" name="id_generacion_filtro" id="filtro_generacion">
          <option value="">Selecciona…</option>
          <?php $__currentLoopData = $generaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
            <option value="<?php echo e($g->id_generacion); ?>"><?php echo e($g->ano_inicio); ?> - <?php echo e($g->ano_fin); ?></option> 
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>

      <div class="col-12">
        <label class="form-label">Grupo (Asignación final)</label>
        <select class="form-select" name="id_grupo" id="select_grupo" required>
          <option value="">Selecciona el grupo correcto…</option>
          <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
             
            <option value="<?php echo e($grupo->id_grupo); ?>"
                    data-carrera="<?php echo e($grupo->id_carrera); ?>"
                    data-generacion="<?php echo e($grupo->id_generacion); ?>">
                <?php echo e($grupo->nombre); ?> (Sem: <?php echo e($grupo->semestre); ?> - <?php echo e($grupo->carrera->nombre ?? 'Sin carrera'); ?>)
            </option> 
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
  

  <hr>

  
  <form action="<?php echo e(route('jefe.importar_alumnos')); ?>" method="POST" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
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
  

</div>


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
            setTimeout(filtrarGrupos, 100); 
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/jefe/alumnos.blade.php ENDPATH**/ ?>