<?php $__env->startSection('title', 'Reportes y métricas'); ?>

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
        <h5 class="mb-1">Reportes del periodo</h5>
        <div class="text-muted">Exporta métricas por carrera, grupo o tutor</div>
      </div>
      <form action="#" method="GET" class="d-flex gap-2">
        <select class="form-select form-select-sm" name="periodo">
          <option value="">Mes actual</option>
        </select>
        <select class="form-select form-select-sm" name="carrera">
          <option value="">Todas las carreras</option>
        </select>
        <button class="btn btn-success btn-sm">Aplicar</button>
      </form>
    </div>
    <hr>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Carrera</th>
            <th>Grupos</th>
            <th>Estudiantes</th>
            <th>Tutores</th>
            <th>Tutorías (mes)</th>
            <th>Asistencia prom.</th>
          </tr>
        </thead>
        <tbody>
          
          <tr>
            <td>—</td>
            <td>—</td>
            <td>—</td>
            <td>—</td>
            <td>0</td>
            <td>0%</td>
          </tr>
          
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-end gap-2">
      <a href="#" class="btn btn-outline">Exportar CSV</a>
      <a href="#" class="btn btn-outline">Exportar XLSX</a>
      <a href="#" class="btn btn-success">Exportar PDF</a>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/coordinador/reportes.blade.php ENDPATH**/ ?>