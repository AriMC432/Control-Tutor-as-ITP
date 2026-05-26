<?php $__env->startSection('title', 'Lista de Estudiantes'); ?>

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
            <h5 class="mb-1">Lista de Estudiantes</h5>
            <div class="text-muted">Todos los estudiantes registrados en el instituto</div>
        </div>

    </div>
    <hr>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. Control</th>
                    <th>Nombre completo</th>
                    <th>Grupo</th>
                    <th>Carrera</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $estudiantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($e->num_control); ?></td>
                    <td><?php echo e($e->nombre); ?> <?php echo e($e->paterno); ?> <?php echo e($e->materno); ?></td>
                    <td><?php echo e($e->grupo->nombre ?? 'N/A'); ?></td>
                    <td><?php echo e($e->grupo->carrera->nombre ?? 'N/A'); ?></td>
                    <td><?php echo e($e->correo); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center">No hay estudiantes registrados.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/coordinador_institucional/estudiantes.blade.php ENDPATH**/ ?>