<?php $__env->startSection('title', 'Seguimiento a tutores'); ?>

<?php echo $__env->renderWhen(true, 'coordinador._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>

<?php $__env->startSection('content'); ?>
  <div class="card p-3">
      <?php if($periodoActual): ?>
        <span class="badge bg-info fs-5 p-2 shadow-sm">
          <i class="bi bi-calendar-check me-1"></i> Periodo activo: <?php echo e($periodoActual->nombre); ?>

        </span>
      <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h5 class="mb-1">Seguimiento a tutores</h5>
        <div class="text-muted">Progreso por tutor y grupo en el periodo seleccionado</div>
      </div>
      <form action="#" method="GET" class="d-flex gap-2">
        <select name="mes" class="form-select form-select-sm">
          <option value="">Mes actual</option>
          
        </select>
        <select name="carrera" class="form-select form-select-sm">
          <option value="">Todas las carreras</option>
          
        </select>
        <button class="btn btn-success btn-sm">Filtrar</button>
      </form>
    </div>
    <hr>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Tutor</th>
            <th>Grupo</th>
            <th>Tutorías (mes)</th>
            <th>Asistencia prom.</th>
            <th>Última sesión</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          
          <tr>
            <td>—</td>
            <td>—</td>
            <td>0</td>
            <td>0%</td>
            <td>—</td>
            <td><span class="badge bg-secondary">Pendiente</span></td>
            <td>
              <div class="btn-group btn-group-sm">
                <a href="#" class="btn btn-outline">Detalle</a>
                <a href="#" class="btn btn-success">Solicitar informe</a>
              </div>
            </td>
          </tr>
          
        </tbody>
      </table>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/coordinador/seguimiento.blade.php ENDPATH**/ ?>