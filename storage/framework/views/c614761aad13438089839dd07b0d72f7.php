<?php $__env->startSection('title', 'Mi Perfil'); ?>


<?php echo $__env->make('jefe._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">

            
            <div class="card p-4 text-start shadow-sm border-0">
                
                <div class="foto-container">
                    <img src="<?php echo e($usuario->foto_url); ?>"
                        alt="foto-perfil"
                        class="profile-img"
                        onerror="this.onerror=null; this.src='/Proyecto_Tec/proyectoAsesorias/public/images/default-avatar.png';">

                    
                    <a href="<?php echo e(route('jefe.perfil.editar-foto')); ?>"
                        class="btn-edit-foto"
                        title="Editar foto">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                </div>
                <h5 class="fw-semibold mb-2">Mi Perfil</h5>
                <p class="text-muted">Consulta tus datos registrados y actualiza tu contraseña.</p>
                <hr>

                
                <?php if(session('success')): ?>
                <div class="alert alert-success d-flex align-items-center shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2 lead"></i>
                    <div><?php echo e(session('success')); ?></div>
                </div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>

                
                <h6 class="text-uppercase text-primary fw-bold mt-3 mb-3">Datos del Usuario</h6>
                <div class="row g-3 mb-5">

                    
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Nombre Completo</label>
                        <input type="text" class="form-control"
                            value="<?php echo e($usuario->nombre); ?> <?php echo e($usuario->paterno); ?> <?php echo e($usuario->materno); ?>" readonly>
                    </div>

                    
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Número de Control/Empleado</label>
                        <input type="text" class="form-control" value="<?php echo e($usuario->num_control); ?>" readonly>
                    </div>

                    
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Correo</label>
                        <input type="email" class="form-control" value="<?php echo e($usuario->correo); ?>" readonly>
                    </div>

                    
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Rol en el Sistema</label>
                        <input type="text" class="form-control" value="<?php echo e($usuario->rol->nombre ?? 'N/A'); ?>" readonly>
                    </div>
                </div>

                <hr>

                
                <h6 class="text-uppercase text-secondary fw-bold mt-4 mb-3">Seguridad y Acceso</h6>

                <form action="<?php echo e(route('jefe.perfil.update_password')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="row g-3">
                        
                        <div class="col-12 mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual <span class="text-danger">*</span></label>
                            <input type="password" class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="current_password" name="current_password" required>
                            <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
<div class="col-md-6">
    <label for="password" class="form-label">Nueva Contraseña <span class="text-danger">*</span></label>
    <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" required>
    
    
    <div class="card mt-2 border-0 shadow-sm" style="background-color: #f8f9fa;">
        <div class="card-body p-2 px-3">
            <p class="small fw-bold mb-1 text-secondary" style="font-size: 0.75rem;">REQUISITOS DE SEGURIDAD:</p>
            <ul class="mb-0 ps-3 text-muted" style="font-size: 0.7rem; list-style-type: disc;">
                <li>Mínimo 8 caracteres.</li>
                <li>Al menos una mayúscula y una minúscula.</li>
                <li>Al menos una letra y un número.</li>
                <li>Al menos un símbolo (ej. !@#$%*).</li>
            </ul>
        </div>
    </div>

    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="col-md-6">
    <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña <span class="text-danger">*</span></label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
    
    
    <div class="mt-2 d-none d-md-block" style="height: 85px;"></div>
</div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-5 fw-semibold">
                            <i class="bi bi-key-fill me-2"></i> Actualizar Contraseña
                        </button>
                    </div>
                </form>

            </div> 
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/jefe/perfil.blade.php ENDPATH**/ ?>