<?php $__env->startSection('title', 'Crear Nuevo Grupo'); ?>

<?php $__env->startSection('content'); ?>

    
    <?php echo $__env->make('jefe._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">

                
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h2 class="fw-bold text-dark mb-0">Gestión de Grupos</h2>
                    <span class="text-muted">Registro de Nuevos Grupos</span>
                </div>

                
                <?php if(session('success')): ?>
                    <div class="alert alert-success d-flex align-items-center shadow-sm border-0" role="alert">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div><?php echo e(session('success')); ?></div>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger d-flex align-items-center shadow-sm border-0" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div><?php echo e(session('error')); ?></div>
                    </div>
                <?php endif; ?>

                
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-semibold text-primary">
                            <i class="bi bi-plus-square-fill me-2"></i> Crear Nuevo Grupo
                        </h5>
                    </div>
                    
                    <div class="card-body p-4">
                        
                        
                        <div class="alert alert-light border mb-4 d-flex align-items-center">
                            <i class="bi bi-calendar-event text-primary me-2"></i>
                            <div>
                                El grupo se creará automáticamente en el periodo: 
                                <strong>
                                    <?php if(isset($periodoActual)): ?>
                                        <span class="text-success"><?php echo e($periodoActual->nombre); ?></span>
                                    <?php else: ?>
                                        <span class="text-danger">No configurado</span>
                                    <?php endif; ?>
                                </strong>
                            </div>
                        </div>

                        <form action="<?php echo e(route('jefe.guardar_grupo')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            
                            <div class="row g-3">
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Nombre del Grupo <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre" class="form-control" placeholder="Ej. ISC-1A" required>
                                    <div class="form-text small">Identificador único (Ej: ISC-1A, MEC-3B).</div>
                                </div>

                                
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Semestre <span class="text-danger">*</span></label>
                                    <input type="number" name="semestre" class="form-control" min="1" max="14" placeholder="Ej. 1" required>
                                </div>

                                
                                <div class="col-12">
                                    <hr class="text-muted opacity-25 my-2">
                                </div>

                                
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Carrera <span class="text-danger">*</span></label>
                                    <select name="id_carrera" class="form-select" required>
                                        <option value="" selected disabled>-- Seleccione Carrera --</option>
                                        <?php $__currentLoopData = $carreras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carrera): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($carrera->id_carrera); ?>"><?php echo e($carrera->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Generación <span class="text-danger">*</span></label>
                                    <select name="id_generacion" class="form-select" required>
                                        <option value="" selected disabled>-- Seleccione Generación --</option>
                                        <?php $__currentLoopData = $generaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($gen->id_generacion); ?>">
                                                <?php echo e($gen->ano_inicio); ?> - <?php echo e($gen->ano_fin); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="<?php echo e(route('jefe.grupos.asignar')); ?>" class="btn btn-outline-secondary">
                                    Ir a Asignar Tutores
                                </a>
                                <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                    <i class="bi bi-save me-2"></i> Guardar Grupo
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/jefe/alta_grupos.blade.php ENDPATH**/ ?>