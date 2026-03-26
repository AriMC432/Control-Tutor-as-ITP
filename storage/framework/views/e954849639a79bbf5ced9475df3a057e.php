<?php $__env->startSection('title', 'Mis Canalizaciones'); ?>

<?php echo $__env->make('alumno._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            
            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                <div>
                    <h2 class="fw-bold text-dark mb-0">Mis Canalizaciones</h2>
                    <span class="text-muted">
                        Periodo: 
                        <?php if(isset($periodoActual)): ?>
                            <span class="badge bg-success"><?php echo e($periodoActual->nombre); ?></span>
                        <?php else: ?>
                            <span class="badge bg-danger">No configurado</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-folder2-open me-2"></i>Historial de Reportes
                    </h5>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Fecha</th>
                                    <th>Área de Atención</th>
                                    <th>Observaciones</th>
                                    <th class="text-center">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $canalizaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $canalizacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="ps-4 text-nowrap fw-medium">
                                            <?php echo e(\Carbon\Carbon::parse($canalizacion['fecha'])->format('d/m/Y')); ?>

                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                <?php echo e($canalizacion['area'] ?? 'General'); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-muted small" style="max-width: 350px; line-height: 1.4;">
                                                <?php echo e($canalizacion['observaciones']); ?>

                                            </div>
                                        </td>
                                        <td class="text-center">
                                            
                                            <span class="badge bg-<?php echo e($canalizacion['clase_estatus']); ?> rounded-pill px-3 py-2">
                                                <?php echo e($canalizacion['estatus']); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <div class="mb-2">
                                                <i class="bi bi-check-circle fs-1 text-success opacity-50"></i>
                                            </div>
                                            <h6 class="fw-bold">¡Todo en orden!</h6>
                                            <p class="mb-0 small">No tienes canalizaciones registradas en este periodo.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/alumno/canalizaciones.blade.php ENDPATH**/ ?>