<?php $__env->startSection('title', 'Gestión de Canalizaciones'); ?>
<?php echo $__env->make('docente._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <div class="row justify-content-center">
            <?php if($periodoActual): ?>
                <span class="badge bg-info fs-5 p-2 shadow-sm">
                    <i class="bi bi-calendar-check me-1"></i> Periodo activo: <?php echo e($periodoActual->nombre); ?>

                </span>
            <?php endif; ?>
            
            
            
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px; z-index: 1;">
                    <div class="card-header bg-danger text-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>Nueva Canalización
                        </h5>
                    </div>
                    <div class="card-body p-4">

                        
                        <?php if(session('success')): ?>
                            <div class="alert alert-success d-flex align-items-center small py-2 mb-3">
                                <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger small py-2 mb-3">
                                <ul class="mb-0 ps-3">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('docente.store_canalizacion')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-secondary">1. Tutoría de Origen</label>
                                <select name="id_tutoria" class="form-select" required>
                                    <option value="" selected disabled>-- Seleccionar Sesión --</option>
                                    <?php $__currentLoopData = $listaTutorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lt->id); ?>"><?php echo e($lt->descripcion); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="form-text text-muted" style="font-size: 0.8rem;">
                                    Solo aparecen tutorías individuales registradas en este periodo.
                                </div>
                            </div>

                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-secondary">2. Área de Atención</label>
                                <select name="area_id" class="form-select" required>
                                    <option value="" selected disabled>-- Seleccionar Área --</option>
                                    <?php $__currentLoopData = $areasCanalizacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($area->id_area); ?>"><?php echo e($area->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-secondary">3. Motivo / Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="5"
                                    placeholder="Describe detalladamente el motivo de la canalización para el área correspondiente..."
                                    required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger fw-bold shadow-sm">
                                    <i class="bi bi-send-fill me-2"></i> Enviar Reporte
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            
            
            
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-secondary">
                            <i class="bi bi-clock-history me-2"></i>Historial de Canalizaciones
                        </h5>
                        <?php if(isset($historialCanalizaciones)): ?>
                            <span class="badge bg-light text-dark border"><?php echo e(count($historialCanalizaciones)); ?> registros</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Fecha</th>
                                        <th>Alumno</th>
                                        <th>Área</th>
                                        <th>Estatus</th>
                                        <th class="text-end pe-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $historialCanalizaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $canalizacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td class="ps-4 text-nowrap">
                                                <?php echo e(\Carbon\Carbon::parse($canalizacion->fecha)->format('d/m/Y')); ?>

                                            </td>
                                            <td>
                                                <?php if($canalizacion->tutoria && $canalizacion->tutoria->estudiante): ?>
                                                    <div class="fw-bold text-dark">
                                                        <?php echo e($canalizacion->tutoria->estudiante->nombre); ?>

                                                        <?php echo e($canalizacion->tutoria->estudiante->paterno); ?>

                                                    </div>
                                                    <small class="text-muted" style="font-size: 0.85em;">
                                                        <?php echo e($canalizacion->tutoria->estudiante->num_control); ?>

                                                    </small>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Estudiante no encontrado</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border fw-normal">
                                                    <?php echo e($canalizacion->area->nombre ?? 'N/A'); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <?php if($canalizacion->estatus == 'Pendiente'): ?>
                                                    <span class="badge bg-warning text-dark border border-warning">Pendiente</span>
                                                <?php elseif($canalizacion->estatus == 'Atendido'): ?>
                                                    <span class="badge bg-success border border-success">Atendido</span>
                                                <?php elseif($canalizacion->estatus == 'En Proceso'): ?>
                                                    <span class="badge bg-primary border border-primary">En Proceso</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?php echo e($canalizacion->estatus); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end pe-4">
                                                
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditCanalizacion<?php echo e($canalizacion->id_canalizacion); ?>"
                                                    title="Editar Canalización">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bi bi-folder2-open fs-1 d-block mb-2 opacity-25"></i>
                                                No hay canalizaciones registradas en este periodo escolar.
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

    
    
    
    <?php $__currentLoopData = $historialCanalizaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $canalizacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="modalEditCanalizacion<?php echo e($canalizacion->id_canalizacion); ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold text-dark">Editar Canalización</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    
                    <form action="<?php echo e(route('docente.update_canalizacion', $canalizacion->id_canalizacion)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>   <input type="hidden" name="id_canalizacion" value="<?php echo e($canalizacion->id_canalizacion); ?>">

                            <div class="modal-body p-4">
                                
                                <div class="alert alert-primary bg-opacity-10 border-primary mb-3">
                                    <small class="d-block text-primary fw-bold text-uppercase"
                                        style="font-size: 0.7rem;">Estudiante</small>
                                    <strong class="text-dark">
                                        <?php echo e($canalizacion->tutoria->estudiante->nombre ?? 'N/A'); ?>

                                        <?php echo e($canalizacion->tutoria->estudiante->paterno ?? ''); ?>

                                    </strong>
                                    <br>
                                    <small class="text-muted">Fecha reporte:
                                        <?php echo e(\Carbon\Carbon::parse($canalizacion->fecha)->format('d/m/Y')); ?></small>
                                </div>

                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Área de Atención</label>
                                    <select name="area_id" class="form-select" required>
                                        <?php $__currentLoopData = $areasCanalizacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($area->id_area); ?>" <?php echo e($canalizacion->id_area == $area->id_area ? 'selected' : ''); ?>>
                                                <?php echo e($area->nombre); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Observaciones</label>
                                    <textarea name="observaciones" class="form-control" rows="4"
                                        required><?php echo e($canalizacion->observaciones); ?></textarea>
                                </div>

                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-primary">Estatus Actual</label>
                                    <select name="estatus" class="form-select border-primary">
                                        <option value="Pendiente" <?php echo e($canalizacion->estatus == 'Pendiente' ? 'selected' : ''); ?>>🟡
                                            Pendiente</option>
                                        <option value="En Proceso" <?php echo e($canalizacion->estatus == 'En Proceso' ? 'selected' : ''); ?>>
                                            🔵 En Proceso</option>
                                        <option value="Atendido" <?php echo e($canalizacion->estatus == 'Atendido' ? 'selected' : ''); ?>>🟢
                                            Atendido</option>
                                        <option value="Cancelado" <?php echo e($canalizacion->estatus == 'Cancelado' ? 'selected' : ''); ?>>🔴
                                            Cancelado</option>
                                    </select>
                                    <div class="form-text">Actualiza el progreso de este caso.</div>
                                </div>
                            </div>

                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary fw-bold px-4">Guardar Cambios</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/docente/canalizaciones.blade.php ENDPATH**/ ?>