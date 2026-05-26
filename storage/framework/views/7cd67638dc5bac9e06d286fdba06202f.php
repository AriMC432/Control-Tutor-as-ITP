<?php $__env->startSection('title', 'Alta de Usuarios'); ?>

<?php echo $__env->make('jefe._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>
  <div class="card p-3">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h4 class="mb-2">Alta de Usuarios</h4>
        <div class="text-muted mb-3">Registra usuarios nuevos</div>
        <?php if($periodoActual): ?>
          <span class="badge bg-info fs-5 p-2 shadow-sm">
            <i class="bi bi-calendar-check me-1"></i> Periodo activo: <?php echo e($periodoActual->nombre); ?>

          </span>
        <?php endif; ?>
      </div>
    </div>
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

    <form action="<?php echo e(route('jefe.docentes.store')); ?>" method="POST">
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
        <div class="col-12">
          <label class="form-label">Rol</label>
          <select class="form-select" name="id_rol" required>
            <option value="">Selecciona…</option>
            
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($rol->id_rol); ?>" <?php echo e(old('id_rol') == $rol->id_rol ? 'selected' : ''); ?>>
                <?php echo e($rol->nombre); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="col-12 d-flex gap-2 mt-2">
          <button class="btn btn-success" type="submit">Registrar usuario</button>
          <button class="btn btn-outline-secondary" type="reset">Limpiar</button>
        </div>
      </div>
    </form>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/jefe/docente.blade.php ENDPATH**/ ?>