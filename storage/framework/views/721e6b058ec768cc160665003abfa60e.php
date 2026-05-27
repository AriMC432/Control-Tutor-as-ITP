<?php $__env->startSection('title', 'Mis Tutorías'); ?>


<?php echo $__env->make('alumno._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card p-4 border-0 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold text-primary mb-1">Mis Tutorías Registradas</h4>
                    <?php if($periodoActual): ?>
                        <span class="badge bg-info fs-5 p-2 shadow-sm">
                            <i class="bi bi-calendar-check me-1"></i> Periodo activo: <?php echo e($periodoActual->nombre); ?>

                        </span>
                    <?php endif; ?>
                    <p class="text-muted mb-0">Consulta el historial de sesiones grupales e individuales.</p>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                    
                    Total: <?php echo e(count($tutorias ?? [])); ?>

                </span>
            </div>

            <hr class="opacity-10 my-4">

            
            <?php if(!isset($tutorias) || $tutorias->isEmpty()): ?>
                <div class="alert alert-info text-center py-4" role="alert">
                    <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                    No se han registrado tutorías para ti todavía.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Tipo</th>
                                <th>Tema / Motivo</th>
                                <th>Fecha</th>
                                <th>Tutor</th>
                                <th class="text-center">Asistencia</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tutorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4">
                                        <?php if($t['tipo'] == 'Grupal'): ?>
                                            
                                            <span
                                                class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10">Grupal</span>
                                        <?php else: ?>
                                            <span
                                                class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25">Individual</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-medium text-dark"><?php echo e($t['tema']); ?></td>
                                    <td class="text-secondary">
                                        
                                        <?php echo e(\Carbon\Carbon::parse($t['fecha'])->locale('es')->isoFormat('D MMM YYYY')); ?>

                                    </td>
                                    <td class="small"><?php echo e($t['tutor']); ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-<?php echo e($t['clase_asistencia']); ?> rounded-pill px-3">
                                            <?php echo e($t['asistencia']); ?>

                                        </span>
                                    </td>
                                    <td class="text-muted small text-truncate" style="max-width: 200px;"
                                        title="<?php echo e($t['observaciones']); ?>">
                                        <?php echo e($t['observaciones']); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/alumno/tutorias.blade.php ENDPATH**/ ?>