<?php $__env->startSection('subnav'); ?>
    
    
    <li class="nav-item">
        <a href="<?php echo e(route('alumno.index')); ?>" class="nav-link <?php echo e(request()->routeIs('alumno.index') ? 'active' : ''); ?>">
            Inicio
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo e(route('alumno.tutorias')); ?>" class="nav-link <?php echo e(request()->routeIs('alumno.tutorias') ? 'active' : ''); ?>">
            Mis tutorías
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo e(route('alumno.canalizaciones')); ?>" class="nav-link <?php echo e(request()->routeIs('alumno.canalizaciones') ? 'active' : ''); ?>">
            Canalizaciones
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo e(route('alumno.perfil')); ?>" class="nav-link <?php echo e(request()->routeIs('alumno.perfil') ? 'active' : ''); ?>">
            Perfil
        </a>
    </li>

    
    <li class="nav-item ms-auto d-flex align-items-center gap-3" id="li-logout">
        
        
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
            var logoutItem = document.getElementById('li-logout');
            if (logoutItem) {
                var parentUl = logoutItem.closest('ul');
                if (parentUl) {
                    parentUl.style.width = '100%';
                }
            }
        });
    </script>

<?php $__env->stopSection(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/alumno/_subnav.blade.php ENDPATH**/ ?>