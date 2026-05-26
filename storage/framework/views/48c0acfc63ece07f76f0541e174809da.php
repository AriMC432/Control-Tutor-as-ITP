<?php $__env->startSection('title', 'Asignar Grupos'); ?>

<?php echo $__env->make('jefe._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>
  <div class="card p-3">
    <h4 class="mb-2">Asignar Grupos a Tutores</h4>
    <div class="text-muted mb-3">Asocia grupos de estudiantes con docentes tutores</div>
    <?php if($periodoActual): ?>
      <span class="badge bg-info fs-5 p-2 shadow-sm">
        <i class="bi bi-calendar-check me-1"></i> Periodo activo: <?php echo e($periodoActual->nombre); ?>

      </span>
    <?php endif; ?>
    <hr>

    
    <?php if(session('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

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

    <form action="<?php echo e(route('jefe.asignar_grupo')); ?>" method="POST" class="row g-2">
      <?php echo csrf_field(); ?>
      <div class="col-md-5">
        <label class="form-label">Docente</label>
        <select class="form-select" name="id_docente" required>
          <option value="">Selecciona un docente…</option>
          <?php $__currentLoopData = $docentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($d->id_docente); ?>"><?php echo e($d->nombre); ?> <?php echo e($d->paterno); ?> <?php echo e($d->materno); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="col-md-5">
        <label class="form-label">Grupo</label>
        <select class="form-select" name="id_grupo" required>
          <option value="">Selecciona un grupo…</option>
          <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($g->id_grupo); ?>">
              <?php echo e($g->nombre); ?> · Sem <?php echo e($g->semestre); ?> (<?php echo e($g->carrera->nombre ?? 'N/A'); ?>)
            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-success w-100" type="submit">Asignar</button>
      </div>
    </form>

    <hr class="my-4">

    <h6>Asignaciones existentes</h6>
    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light">
          <tr>
            <th>Grupo</th>
            <th>Docente Tutor</th>
            <th>Carrera</th>
            <th>Generación</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $asignaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td class="fw-bold"><?php echo e($a->nombre); ?> <span class="badge bg-secondary text-white"><?php echo e($a->semestre); ?>°
                  Sem</span></td>
              <td class="text-primary">
                <?php echo e($a->tutor->nombre); ?> <?php echo e($a->tutor->paterno); ?>

              </td>
              <td><?php echo e($a->carrera->nombre ?? 'Sin Carrera'); ?></td>
              <td>
                <?php if($a->generacion): ?>
                  <?php echo e($a->generacion->ano_inicio); ?>-<?php echo e($a->generacion->ano_fin); ?>

                <?php else: ?>
                  —
                <?php endif; ?>
              </td>
              <td class="text-end">
                
                <a href="<?php echo e(route('jefe.liberar_grupo', $a->id_grupo)); ?>" class="btn btn-outline-danger btn-sm"
                  onclick="return confirm('¿Seguro que deseas quitar al tutor de este grupo?')">
                  Quitar
                </a>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="5" class="text-center text-muted py-3">No hay grupos con tutor asignado aún.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/jefe/grupos.blade.php ENDPATH**/ ?>