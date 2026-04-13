<?php $__env->startSection('title', 'Editar Foto de Perfil'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card p-4 shadow-sm border-0">
                <h4 class="text-center mb-4">Editar foto de perfil</h4>
                
                <div class="text-center mb-4">
                    <div class="foto-container" style="margin: 0 auto;">
                        <img src="<?php echo e($usuario->foto_url ?? asset('images/default-avatar.png')); ?>" 
                             alt="Foto actual" 
                             class="profile-img"
                             onerror="handleImageError(this)"
                             style="width: 200px; height: 200px;">
                    </div>
                    <p class="text-muted mt-3">Foto actual</p>
                </div>
                
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form action="<?php echo e(route('coordinst.actualizar-foto')); ?>" 
                      method="POST" 
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label for="foto" class="form-label">Seleccionar nueva foto</label>
                        <input type="file" 
                               class="form-control <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="foto" 
                               name="foto" 
                               accept="image/*"
                               required>
                        <small class="text-muted">Formatos: JPG, PNG, GIF. Máx 2MB</small>
                        <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?php echo e(route('coordinst.perfil.view')); ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-2"></i>Subir Foto
                        </button>
                    </div>
                </form>
                
                <?php if($usuario->foto): ?>
                <hr class="my-4">
                <form action="<?php echo e(route('coordinst.eliminar-foto')); ?>" 
                      method="POST" 
                      onsubmit="return confirm('¿Eliminar foto?');">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-2"></i>Eliminar foto
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/coordinador_institucional/editar-foto.blade.php ENDPATH**/ ?>