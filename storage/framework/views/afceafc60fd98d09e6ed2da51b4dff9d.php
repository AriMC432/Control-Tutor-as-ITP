<?php $__env->startSection('title', 'Periodos Escolares'); ?>

<?php $__env->startSection('content'); ?>

    
    <?php echo $__env->make('soporte._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">

                
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h2 class="fw-bold text-dark mb-0">Ciclos Escolares</h2>
                    <span class="text-muted">Configuración del Semestre Actual</span>
                </div>

                
                <?php if(session('success')): ?>
                    <div class="alert alert-success d-flex align-items-center shadow-sm border-0" role="alert">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div><?php echo e(session('success')); ?></div>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger shadow-sm border-0">
                        <ul class="mb-0 ps-3">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="row">
                    
                    
                    <div class="col-md-5 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-primary text-white py-3">
                                <h5 class="mb-0 fw-bold"><i class="bi bi-calendar-range me-2"></i> Nuevo Ciclo</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="alert alert-warning border small">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                    <strong>Atención:</strong> Al crear un nuevo periodo, este se convertirá en el <strong>ACTIVO</strong> y todos los anteriores se cerrarán automáticamente.
                                </div>

                                <form action="<?php echo e(route('jefe.guardar_periodo')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Nombre del Periodo</label>
                                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Enero-Junio 2026" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Fecha de Inicio</label>
                                        <input type="date" name="fecha_inicio" class="form-control" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-medium">Fecha de Fin</label>
                                        <input type="date" name="fecha_fin" class="form-control" required>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary fw-bold" onclick="return confirm('¿Estás seguro de iniciar un nuevo ciclo escolar? Esto ocultará los grupos actuales para crear nuevos.')">
                                            <i class="bi bi-power me-2"></i> Activar Nuevo Ciclo
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-md-7 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-bold text-secondary"><i class="bi bi-clock-history me-2"></i> Historial</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Periodo</th>
                                            <th>Fechas</th>
                                            <th class="text-end pe-4">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $periodos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periodo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr class="<?php echo e($periodo->activo ? 'table-success' : ''); ?>">
                                                <td class="ps-4 fw-medium"><?php echo e($periodo->nombre); ?></td>
                                                <td class="small text-muted">
                                                    <?php echo e(\Carbon\Carbon::parse($periodo->fecha_inicio)->format('d/m/Y')); ?> <br> 
                                                    <?php echo e(\Carbon\Carbon::parse($periodo->fecha_fin)->format('d/m/Y')); ?>

                                                </td>
                                                <td class="text-end pe-4">
                                                    <?php if($periodo->activo): ?>
                                                        <span class="badge bg-success rounded-pill px-3">ACTIVO</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary rounded-pill px-3">Cerrado</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-muted">No hay periodos registrados.</td>
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
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/soporte/periodos.blade.php ENDPATH**/ ?>