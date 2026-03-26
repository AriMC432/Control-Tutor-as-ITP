<?php $__env->startSection('subnav'); ?>

    
    <li class="nav-item">
        <a href="<?php echo e(route('soporte.index')); ?>" class="nav-link <?php echo e(request()->routeIs('soporte.index') ? 'active' : ''); ?>">
            Inicio
        </a>
    </li>

    
    <li class="nav-item">
        
        <a href="<?php echo e(route('soporte.alumnos')); ?>" class="nav-link <?php echo e(request()->routeIs('soporte.alumnos') ? 'active' : ''); ?>">
            Alta de Alumnos
        </a>
    </li>

    
    <li class="nav-item">
        <a href="<?php echo e(route('soporte.grupos.crear')); ?>" class="nav-link <?php echo e(request()->routeIs('soporte.grupos.crear') ? 'active' : ''); ?>">
            Alta de Grupos
        </a>
    </li>

    
    <li class="nav-item">
        <a href="<?php echo e(route('soporte.grupos.asignar')); ?>" class="nav-link <?php echo e(request()->routeIs('soporte.grupos.asignar') ? 'active' : ''); ?>">
            Asignar Grupos
        </a>
    </li>

    
    <li class="nav-item">
        <a href="<?php echo e(route('soporte.periodos')); ?>" class="nav-link <?php echo e(request()->routeIs('soporte.periodos') ? 'active' : ''); ?>">
            Periodos
        </a>
    </li>

    
    <li class="nav-item ms-auto d-flex align-items-center gap-3" id="li-logout-soporte">
        
        
        <?php if(session('user_name')): ?>
            <span class="text-white fw-semibold d-none d-md-block">
                <?php echo e(session('user_name')); ?>

            </span>
        <?php endif; ?>

        
        <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-danger btn-sm fw-bold text-white px-5 rounded-pill shadow-sm" style="border: none;">
                <i class="bi bi-box-arrow-right me-1"></i> Salir
            </button>
        </form>
    </li>

    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var logoutItem = document.getElementById('li-logout-soporte');
            if (logoutItem) {
                var parentUl = logoutItem.closest('ul');
                if (parentUl) {
                    parentUl.style.width = '100%';
                }
            }
        });
    </script>

<?php $__env->stopSection(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/soporte/_subnav.blade.php ENDPATH**/ ?>