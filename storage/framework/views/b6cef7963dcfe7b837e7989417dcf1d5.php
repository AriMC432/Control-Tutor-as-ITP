<?php $__env->startSection('title', 'Inicio'); ?>

<?php $__env->startSection('content'); ?>
  <div class="text-center mb-4">
    <h1>Bienvenido a la Nueva Página del Tecnologico de Pachuca</h1>
    <br></br>
    <br></br>
  </div>

  
  <div id="carouselExampleIndicators" class="carousel slide mx-auto mb-4" data-bs-ride="carousel" style="max-width: 800px;">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Imagen 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Imagen 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Imagen 3"></button>
    </div>

    <div class="carousel-inner rounded shadow">
      <div class="carousel-item active">
        <img src="<?php echo e(asset('images/slide1.jpg')); ?>" class="d-block w-100" alt="Imagen 1" style="height: 400px; object-fit: cover;">
      </div>
      <div class="carousel-item">
        <img src="<?php echo e(asset('images/slide2.jpg')); ?>" class="d-block w-100" alt="Imagen 2" style="height: 400px; object-fit: cover;">
      </div>
      <div class="carousel-item">
        <img src="<?php echo e(asset('images/slide3.jpg')); ?>" class="d-block w-100" alt="Imagen 3" style="height: 400px; object-fit: cover;">
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/pagina.blade.php ENDPATH**/ ?>