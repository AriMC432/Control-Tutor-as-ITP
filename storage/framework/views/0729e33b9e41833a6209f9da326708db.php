<?php $__env->startSection('title', 'Informes de tutores'); ?>

<?php echo $__env->renderWhen(true, 'coordinador._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>

<?php $__env->startSection('content'); ?>
  <div class="row g-3">
    <?php if($periodoActual): ?>
      <span class="badge bg-info fs-5 p-2 shadow-sm">
        <i class="bi bi-calendar-check me-1"></i> Periodo activo: <?php echo e($periodoActual->nombre); ?>

      </span>
    <?php endif; ?>
    <div class="col-12 col-lg-5">
      <div class="card p-3 h-100">
        <h5 class="mb-2">Cargar informe</h5>
        <div class="text-muted">Recibe informes individuales (PDF/Excel) por tutor o grupo</div>
        <hr>
        <form action="#" method="POST" enctype="multipart/form-data" class="d-grid gap-3">
          <?php echo csrf_field(); ?>
          <div>
            <label class="form-label">Tutor</label>
            <select class="form-select" name="id_docente" required>
              <option value="">Selecciona…</option>
              
            </select>
          </div>
          <div>
            <label class="form-label">Mes / Periodo</label>
            <input type="month" class="form-control" name="periodo" required>
          </div>
          <div>
            <label class="form-label">Archivo</label>
            <input type="file" class="form-control" name="informe" accept=".pdf,.xlsx,.xls" required>
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-success">Subir</button>
            <button class="btn btn-outline" type="reset">Limpiar</button>
          </div>
        </form>
      </div>
    </div>

    <div class="col-12 col-lg-7">
      <div class="card p-3 h-100">
        <h5 class="mb-2">Informes recibidos</h5>
        <div class="text-muted">Valida y marca como aceptado/rechazado</div>
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
              
              <tr>
                <td>—</td>
                <td>—</td>
                <td>—</td>
                <td><a href="#" class="btn btn-outline btn-sm">Descargar</a></td>
                <td><span class="badge bg-warning text-dark">En revisión</span></td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="#" class="btn btn-success">Aceptar</a>
                    <a href="#" class="btn btn-outline">Rechazar</a>
                  </div>
                </td>
              </tr>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h5 class="mb-1">Consolidado del área</h5>
            <div class="text-muted">Genera y descarga el informe global del periodo</div>
          </div>
          <div class="btn-group">
            <a href="#" class="btn btn-outline">Generar</a>
            <a href="#" class="btn btn-success">Descargar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/coordinador/informes.blade.php ENDPATH**/ ?>