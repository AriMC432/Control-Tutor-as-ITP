<?php $__env->startSection('title', 'Lista de Canalizaciones'); ?>

<?php echo $__env->renderWhen(true, 'coordinador_institucional._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-3">
            <?php if($periodoActivo): ?>
                            <span class="badge bg-info fs-5 p-2 shadow-sm">
                                <i class="bi bi-calendar-check me-1"></i> Periodo activo: <?php echo e($periodoActivo->nombre); ?>

                            </span>
                        <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">Lista de Canalizaciones</h5>
            <div class="text-muted">Todas las canalizaciones realizadas a estudiantes</div>
        </div>
    </div>
    <hr>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Estudiante</th>
                    <th>Área</th>
                    <th>Estatus</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $canalizaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($c->fecha); ?></td>
                    <td><?php echo e($c->tutoria->estudiante->nombre ?? 'N/A'); ?> <?php echo e($c->tutoria->estudiante->paterno ?? ''); ?></td>
                    <td><?php echo e($c->area->nombre ?? 'N/A'); ?></td>
                    <td>
                        <span class="badge 
                            <?php if($c->estatus == 'Atendido'): ?> bg-success
                            <?php elseif($c->estatus == 'En Proceso'): ?> bg-warning
                            <?php else: ?> bg-secondary
                            <?php endif; ?>">
                            <?php echo e($c->estatus ?? 'Pendiente'); ?>

                        </span>
                    </td>
                    <td><?php echo e($c->observaciones ?? 'N/A'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center">No hay canalizaciones registradas.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/coordinador_institucional/canalizaciones.blade.php ENDPATH**/ ?>