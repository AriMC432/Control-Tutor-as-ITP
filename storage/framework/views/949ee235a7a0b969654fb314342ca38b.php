<?php $__env->startSection('subnav'); ?>

    
    <li class="nav-item">
        <a href="<?php echo e(route('coord.index')); ?>" class="nav-link <?php echo e(request()->routeIs('coord.index') ? 'active' : ''); ?>">
            Inicio
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo e(route('coord.seguimiento')); ?>" class="nav-link <?php echo e(request()->routeIs('coord.seguimiento') ? 'active' : ''); ?>">
            Seguimiento a tutores
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo e(route('coord.informes')); ?>" class="nav-link <?php echo e(request()->routeIs('coord.informes') ? 'active' : ''); ?>">
            Informes
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo e(route('coord.reportes')); ?>" class="nav-link <?php echo e(request()->routeIs('coord.reportes') ? 'active' : ''); ?>">
            Reportes
        </a>
    </li>

    
    <li class="nav-item">
        <a href="<?php echo e(route('coordinador.perfil.view')); ?>" class="nav-link <?php echo e(request()->routeIs('coordinador.perfil.view') ? 'active' : ''); ?>">
            <i class="bi bi-person-circle me-1"></i> Mi Perfil
        </a>
    </li>

    
    
    <li class="nav-item ms-auto d-flex align-items-center gap-3" id="li-logout-coord">
        
        
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
            // Usamos un ID específico para el coordinador por si acaso
            var logoutItem = document.getElementById('li-logout-coord');
            if (logoutItem) {
                var parentUl = logoutItem.closest('ul');
                if (parentUl) {
                    parentUl.style.width = '100%';
                }
            }
        });
    </script>

<?php $__env->stopSection(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/coordinador/_subnav.blade.php ENDPATH**/ ?>