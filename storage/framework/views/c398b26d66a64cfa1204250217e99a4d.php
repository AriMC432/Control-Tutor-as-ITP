<?php $__env->startSection('subnav'); ?>

    
    <li class="nav-item">
        <a href="<?php echo e(route('jefe.index')); ?>" class="nav-link <?php echo e(request()->routeIs('jefe.index') ? 'active' : ''); ?>">
            Inicio
        </a>
    </li>

    
    <li class="nav-item">
        <a href="<?php echo e(route('jefe.alumnos')); ?>" class="nav-link <?php echo e(request()->routeIs('jefe.alumnos') ? 'active' : ''); ?>">
            Alta de Alumnos
        </a>
    </li>

    
    <li class="nav-item">
        <a href="<?php echo e(route('jefe.usuarios')); ?>" class="nav-link <?php echo e(request()->routeIs('jefe.usuarios') ? 'active' : ''); ?>">
            Alta de Usuarios
        </a>
    </li>

    
    <li class="nav-item">
        <a href="<?php echo e(route('jefe.grupos.crear')); ?>" class="nav-link <?php echo e(request()->routeIs('jefe.grupos.crear') ? 'active' : ''); ?>">
            Alta de Grupos
        </a>
    </li>

    
    <li class="nav-item">
        <a href="<?php echo e(route('jefe.grupos.asignar')); ?>" class="nav-link <?php echo e(request()->routeIs('jefe.grupos.asignar') ? 'active' : ''); ?>">
            Asignar Grupos
        </a>
    </li>

    
    <li class="nav-item">
        <a href="<?php echo e(route('jefe.periodos')); ?>" class="nav-link <?php echo e(request()->routeIs('jefe.periodos') ? 'active' : ''); ?>">
            Periodos
        </a>
    </li>

    
    <li class="nav-item">
        <a href="<?php echo e(route('jefe.perfil.view')); ?>" class="nav-link <?php echo e(request()->routeIs('jefe.perfil.view') ? 'active' : ''); ?>">
            <i class="bi bi-person-circle me-1"></i> Mi Perfil
        </a>
    </li>

    
    <li class="nav-item ms-auto d-flex align-items-center gap-3" id="li-logout-jefe">
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
            var logoutItem = document.getElementById('li-logout-jefe');
            if (logoutItem) {
                var parentUl = logoutItem.closest('ul');
                if (parentUl) { parentUl.style.width = '100%'; }
            }
        });
    </script>

<?php $__env->stopSection(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/jefe/_subnav.blade.php ENDPATH**/ ?>