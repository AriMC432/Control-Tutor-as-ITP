<?php $__env->startSection('title', 'Lista de Tutorías'); ?>

<?php echo $__env->renderWhen(true, 'coordinador_institucional._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">Lista de Tutorías</h5>
            <div class="text-muted">Todas las tutorías individuales y grupales</div>
        </div>
        <?php if($periodoActivo): ?>
            <span class="badge bg-info">Periodo activo: <?php echo e($periodoActivo->nombre); ?></span>
        <?php endif; ?>
    </div>
    <hr>

    <h6 class="mt-3">Tutorías Individuales</h6>
    <div class="table-responsive mb-4">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estudiante</th>
                    <th>Docente</th>
                    <th>Motivo</th>
                    <th>Asistencia</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $tutoriasIndividuales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($t->fecha); ?></td>
                    <td><?php echo e($t->hora ?? 'N/A'); ?></td>
                    <td><?php echo e($t->estudiante->nombre ?? 'N/A'); ?> <?php echo e($t->estudiante->paterno ?? ''); ?></td>
                    <td><?php echo e($t->docente->nombre ?? 'N/A'); ?> <?php echo e($t->docente->paterno ?? ''); ?></td>
                    <td><?php echo e($t->motivo ?? 'N/A'); ?></td>
                    <td>
                        <span class="badge <?php echo e($t->asistencia ? 'bg-success' : 'bg-danger'); ?>">
                            <?php echo e($t->asistencia ? 'Asistió' : ($t->asistencia === false ? 'No asistió' : 'Pendiente')); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center">No hay tutorías individuales registradas.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <h6>Tutorías Grupales</h6>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Grupo</th>
                    <th>Docente</th>
                    <th>Tema</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $tutoriasGrupales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($t->fecha); ?></td>
                    <td><?php echo e($t->hora ?? 'N/A'); ?></td>
                    <td><?php echo e($t->grupo->nombre ?? 'N/A'); ?></td>
                    <td><?php echo e($t->docente->nombre ?? 'N/A'); ?> <?php echo e($t->docente->paterno ?? ''); ?></td>
                    <td><?php echo e($t->tema ?? 'N/A'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center">No hay tutorías grupales registradas.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/coordinador_institucional/tutorias.blade.php ENDPATH**/ ?>