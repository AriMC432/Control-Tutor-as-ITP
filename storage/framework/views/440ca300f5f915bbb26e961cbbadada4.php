<?php $__env->startSection('title', 'Panel del Estudiante'); ?>


<?php echo $__env->make('alumno._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background-color: #e8f0fe !important;">
            <div class="card-body py-4">
                <h5 class="text-secondary mb-1" style="font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    <i class="bi bi-calendar3 me-2"></i> Ciclo Escolar Actual
                </h5>
                <h2 class="fw-bold mb-0" style="color: #174c9b !important;">
<?php echo e($periodoActivo ? $periodoActivo->nombre : 'Sin periodo activo'); ?>                </h2>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">

    
    <div class="card p-4 text-start mb-4 border-0 shadow-sm">
        <h4 class="fw-bold text-primary mb-2">Bienvenido(a), <?php echo e($nombre ?? 'Estudiante'); ?></h4>
        <p class="text-muted mb-0">
            Desde este panel puedes consultar tus tutorías grupales e individuales, revisar observaciones
            y las canalizaciones emitidas por tu tutor.
        </p>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card p-3 border-0 shadow-sm h-100">
                <h6 class="text-primary fw-semibold text-uppercase small">Tutorías asistidas</h6>
                <h2 class="fw-bold display-6 mb-0"><?php echo e($totalTutorias ?? 0); ?></h2>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-3 border-0 shadow-sm h-100">
                <h6 class="text-success fw-semibold text-uppercase small">Asistencia general</h6>
                <h2 class="fw-bold display-6 mb-0"><?php echo e($asistencia ?? '0%'); ?></h2>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-3 border-0 shadow-sm h-100">
                <h6 class="text-danger fw-semibold text-uppercase small">Canalizaciones</h6>
                <h2 class="fw-bold display-6 mb-0"><?php echo e($totalCanalizaciones ?? 0); ?></h2>
            </div>
        </div>
    </div>

    
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-secondary">
                <i class="bi bi-clock-history me-2"></i>Actividad Reciente
            </h5>
            <span class="badge bg-light text-secondary border">Últimos movimientos</span>
        </div>
        
        <div class="card-body p-0">
            <?php if(isset($tutorias) && count($tutorias) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Fecha</th>
                                <th>Tipo</th>
                                <th>Tema / Motivo</th>
                                <th>Tutor</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tutorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4 fw-semibold text-secondary text-nowrap">
                                        <?php echo e(\Illuminate\Support\Carbon::parse($t->fecha)->format('d/m/Y')); ?>

                                    </td>
                                    <td>
                                        <?php if($t->tipo == 'Grupal'): ?>
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Grupal</span>
                                        <?php else: ?>
                                            <span class="badge bg-info bg-opacity-10 text-info text-dark rounded-pill px-3">Individual</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-truncate fw-medium" style="max-width: 250px;" title="<?php echo e($t->tema); ?>">
                                        <?php echo e($t->tema); ?>

                                    </td>
                                    <td class="small text-muted"><?php echo e($t->tutor); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($t->estado_clase); ?>"><?php echo e($t->estado_texto); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="card-footer bg-white text-center border-0 py-3">
                    <a href="<?php echo e(route('alumno.tutorias')); ?>" class="text-decoration-none fw-bold small text-primary">
                        Ver historial completo <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-calendar-x fs-1 mb-3 d-block opacity-50"></i>
                    <h6 class="fw-bold">Sin actividad reciente</h6>
                    <p class="small mb-0">No tienes tutorías registradas próximamente.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/alumno/index.blade.php ENDPATH**/ ?>