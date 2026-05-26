<?php $__env->startSection('title', 'Gestionar Tutorías'); ?>
<?php echo $__env->make('docente._subnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <div class="row justify-content-center">
            <?php if($periodoActual): ?>
                <span class="badge bg-info fs-5 p-2 shadow-sm">
                    <i class="bi bi-calendar-check me-1"></i> Periodo activo: <?php echo e($periodoActual->nombre); ?>

                </span>
            <?php endif; ?>
            
            
            
            <div class="col-lg-5 mb-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px; z-index: 1;">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-calendar-plus me-2"></i>Agendar Nueva
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <?php if(session('success')): ?>
                            <div class="alert alert-success d-flex align-items-center small py-2">
                                <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger small py-2">
                                <ul class="mb-0 ps-3">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('docente.store_tutoria')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Tipo de Sesión</label>
                                <select class="form-select" name="tipo" id="tipoTutoria" onchange="toggleFormulario()">
                                    <option value="grupal" selected>👥 Grupal (Todo el grupo)</option>
                                    <option value="individual">👤 Individual (Un estudiante)</option>
                                </select>
                            </div>

                            
                            <div id="camposGrupal">
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Grupo</label>
                                    <select class="form-select" name="grupo_id">
                                        <option value="">-- Seleccionar --</option>
                                        <?php $__currentLoopData = $gruposAsignados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($grupo->id_grupo); ?>">
                                                <?php echo e($grupo->nombre); ?> <?php echo e($grupo->carrera ? '(' . $grupo->carrera->nombre . ')' : ''); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Tema</label>
                                    <input type="text" class="form-control" name="tema" placeholder="Ej. Integración...">
                                </div>
                            </div>

                            
                            <div id="camposIndividual" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-primary">1. Grupo del Alumno</label>
                                    <select class="form-select" id="filtroGrupoIndiv" onchange="filtrarAlumnos()">
                                        <option value="">-- Seleccionar Grupo --</option>
                                        <?php $__currentLoopData = $gruposAsignados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($grupo->id_grupo); ?>"><?php echo e($grupo->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-medium text-primary">2. Estudiante</label>
                                    <select class="form-select" name="estudiante_id" id="selectEstudiante" disabled>
                                        <option value="">-- Primero el grupo --</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-medium">Motivo</label>
                                    <input type="text" class="form-control" name="motivo" placeholder="Ej. Bajo rendimiento">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-medium">Observaciones</label>
                                    <textarea class="form-control" name="observaciones" rows="2"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-medium text-success">Estado</label>
                                    <select name="asistencia" class="form-select">
                                        <option value="" selected>📅 Programada (Pendiente)</option>
                                        <option value="1">✅ Realizada (Asistió)</option>
                                        <option value="0">❌ No Asistió (Falta)</option>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-medium">Fecha</label>
                                    <input type="date" class="form-control" name="fecha" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-medium">Hora</label>
                                    <input type="time" class="form-control" name="hora" required>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-bold">
                                    <i class="bi bi-save me-1"></i> Agendar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            
            
            
            <div class="col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-secondary">
                            <i class="bi bi-list-check me-2"></i>Mis Tutorías del Periodo
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="grupales-tab" data-bs-toggle="tab" data-bs-target="#grupales-pane" type="button" role="tab">Grupales</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="individuales-tab" data-bs-toggle="tab" data-bs-target="#individuales-pane" type="button" role="tab">Individuales</button>
                            </li>
                        </ul>

                        <div class="tab-content p-3" id="myTabContent">

                            
                            <div class="tab-pane fade show active" id="grupales-pane" role="tabpanel">
                                <?php if($misTutoriasGrupales->isEmpty()): ?>
                                    <p class="text-center text-muted py-4">No has registrado tutorías grupales este semestre.</p>
                                <?php else: ?>
                                    <div class="list-group list-group-flush">
                                        <?php $__currentLoopData = $misTutoriasGrupales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1 fw-bold"><?php echo e($tg->tema); ?></h6>
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar me-1"></i><?php echo e(\Carbon\Carbon::parse($tg->fecha)->format('d/m/Y')); ?> 
                                                        
                                                        <?php if($tg->hora): ?> <i class="bi bi-clock ms-2 me-1"></i><?php echo e(\Carbon\Carbon::parse($tg->hora)->format('H:i')); ?> <?php endif; ?>
                                                        &nbsp;|&nbsp; 
                                                        <i class="bi bi-people me-1"></i><?php echo e($tg->grupo->nombre ?? 'Sin Grupo'); ?>

                                                    </small>
                                                </div>
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditGrupal<?php echo e($tg->id_tutoria_grupal); ?>">
                                                    <i class="bi bi-pencil-square me-1"></i> Editar / Pasar Lista
                                                </button>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            
                            <div class="tab-pane fade" id="individuales-pane" role="tabpanel">
                                <?php if($misTutoriasIndividuales->isEmpty()): ?>
                                    <p class="text-center text-muted py-4">No has registrado tutorías individuales este semestre.</p>
                                <?php else: ?>
                                    <div class="list-group list-group-flush">
                                        <?php $__currentLoopData = $misTutoriasIndividuales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1 fw-bold"><?php echo e($ti->estudiante->nombre ?? 'Alumno'); ?> <?php echo e($ti->estudiante->paterno ?? ''); ?></h6>
                                                    <small class="d-block text-secondary"><?php echo e($ti->motivo); ?></small>
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar me-1"></i><?php echo e(\Carbon\Carbon::parse($ti->fecha)->format('d/m/Y')); ?>

                                                        
                                                        <?php if($ti->hora): ?> <i class="bi bi-clock ms-2 me-1"></i><?php echo e(\Carbon\Carbon::parse($ti->hora)->format('H:i')); ?> <?php endif; ?>

                                                        <?php if($ti->asistencia === 1): ?> <span class="badge bg-success ms-2">Asistió</span>
                                                        <?php elseif($ti->asistencia === 0): ?> <span class="badge bg-danger ms-2">Falta</span>
                                                        <?php else: ?> <span class="badge bg-warning text-dark ms-2">Pendiente</span> <?php endif; ?>
                                                    </small>
                                                </div>
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditIndiv<?php echo e($ti->id_tutoria_individual); ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
    

    
    <?php $__currentLoopData = $misTutoriasGrupales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="modalEditGrupal<?php echo e($tg->id_tutoria_grupal); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-primary">Editar Tutoría y Asistencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('docente.update_tutoria')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="tipo" value="grupal">
                        <input type="hidden" name="id_tutoria" value="<?php echo e($tg->id_tutoria_grupal); ?>">

                        
                        <div class="mb-3">
                            <label class="form-label fw-medium">Tema de la Sesión</label>
                            <input type="text" class="form-control" name="tema" value="<?php echo e($tg->tema); ?>" required>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <label class="form-label fw-medium">Fecha</label>
                                <input type="date" class="form-control" name="fecha" 
       value="<?php echo e(\Carbon\Carbon::parse($tg->fecha)->format('Y-m-d')); ?>" required>
                            <div class="col-6">
                                <label class="form-label fw-medium">Hora</label>
                                
                                <input type="time" class="form-control" name="hora" value="<?php echo e($tg->hora); ?>" required>
                            </div>
                        </div>

                        <hr>

                        
                        <h6 class="fw-bold mb-3"><i class="bi bi-check2-square me-2"></i>Pase de Lista - <?php echo e($tg->grupo->nombre ?? ''); ?></h6>

                        <?php if($tg->grupo && $tg->grupo->estudiantes->isNotEmpty()): ?>
                            <div class="table-responsive border rounded" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th class="ps-3">Estudiante</th>
                                            <th style="width: 160px;" class="text-center">Asistencia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $tg->grupo->estudiantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estudiante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
            $detalle = $tg->detalles->where('id_estudiante', $estudiante->id_estudiante)->first();
            $asistenciaActual = $detalle ? $detalle->asistencia : null;
                                            ?>
                                            <tr>
                                                <td class="ps-3">
                                                    <span class="fw-medium"><?php echo e($estudiante->paterno); ?> <?php echo e($estudiante->materno); ?></span> <?php echo e($estudiante->nombre); ?>

                                                    <br><small class="text-muted"><?php echo e($estudiante->num_control); ?></small>
                                                </td>
                                                <td class="pe-2">
                                                    <select name="asistencias[<?php echo e($estudiante->id_estudiante); ?>]" class="form-select form-select-sm text-center <?php echo e($asistenciaActual === 1 ? 'border-success text-success fw-bold' : ($asistenciaActual === 0 ? 'border-danger text-danger fw-bold' : '')); ?>">
                                                        <option value="" <?php echo e(is_null($asistenciaActual) ? 'selected' : ''); ?>>- Pendiente -</option>
                                                        <option value="1" <?php echo e($asistenciaActual === 1 ? 'selected' : ''); ?>>✅ Asistió</option>
                                                        <option value="0" <?php echo e($asistenciaActual === 0 ? 'selected' : ''); ?>>❌ Falta</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">No hay alumnos registrados en este grupo.</div>
                        <?php endif; ?>

                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="bi bi-save me-1"></i> Guardar Todo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<div id="data-grupos" data-json="<?php echo e(json_encode($gruposAsignados)); ?>" style="display: none;"></div>
    <script>
        const container = document.getElementById('data-grupos');
        const dataGrupos = JSON.parse(container.getAttribute('data-json'));        function toggleFormulario() {
        const tipo = document.getElementById('tipoTutoria').value;
        const divGrupal = document.getElementById('camposGrupal');
        const divIndividual = document.getElementById('camposIndividual');

            if (tipo === 'grupal') {
                divGrupal.style.display = 'block';
                divIndividual.style.display = 'none';
            } else {
                divGrupal.style.display = 'none';
                divIndividual.style.display = 'block';
            }
        }

        function filtrarAlumnos() {
            const grupoIdSeleccionado = document.getElementById('filtroGrupoIndiv').value;
            const selectEstudiante = document.getElementById('selectEstudiante');

            selectEstudiante.innerHTML = '<option value="">-- Selecciona al estudiante --</option>';
            selectEstudiante.disabled = true;

            if (!grupoIdSeleccionado) return;

            const grupoEncontrado = dataGrupos.find(g => g.id_grupo == grupoIdSeleccionado);

            if (grupoEncontrado && grupoEncontrado.estudiantes && grupoEncontrado.estudiantes.length > 0) {
                selectEstudiante.disabled = false;
                grupoEncontrado.estudiantes.forEach(est => {
                    const opcion = document.createElement('option');
                    opcion.value = est.id_estudiante;
                    opcion.text = `${est.paterno} ${est.materno || ''} ${est.nombre} (${est.num_control})`;
                    selectEstudiante.appendChild(opcion);
                });
            } else {
                const opcion = document.createElement('option');
                opcion.text = "No hay alumnos registrados en este grupo";
                selectEstudiante.appendChild(opcion);
            }
        }
    </script>
<?php $__env->stopSection(); ?>



<?php $__currentLoopData = $misTutoriasIndividuales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="modalEditIndiv<?php echo e($ti->id_tutoria_individual); ?>" 
     tabindex="-1" 
     aria-labelledby="modalLabel<?php echo e($ti->id_tutoria_individual); ?>" 
     aria-hidden="true"
     data-bs-backdrop="static"> 
    
    <div class="modal-dialog modal-dialog-centered"> 
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-primary" id="modalLabel<?php echo e($ti->id_tutoria_individual); ?>">
                    <i class="bi bi-pencil-square me-2"></i>Editar Tutoría Individual
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?php echo e(route('docente.update_tutoria')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    
                    <input type="hidden" name="tipo" value="individual">
                    <input type="hidden" name="id_tutoria" value="<?php echo e($ti->id_tutoria_individual); ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Motivo</label>
                        <input type="text" class="form-control" name="motivo" value="<?php echo e($ti->motivo); ?>" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Fecha</label>
                            <input type="date" class="form-control" name="fecha" 
                                   value="<?php echo e($ti->fecha ? \Carbon\Carbon::parse($ti->fecha)->format('Y-m-d') : ''); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Hora</label>
                            <input type="time" class="form-control" name="hora" 
                                   value="<?php echo e($ti->hora ? \Carbon\Carbon::parse($ti->hora)->format('H:i') : ''); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Observaciones</label>
                        <textarea class="form-control" name="observaciones" rows="3"><?php echo e($ti->observaciones); ?></textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-success">Estado de Asistencia</label>
                        <select name="asistencia" class="form-select border-success">
                            <option value="" <?php echo e(is_null($ti->asistencia) ? 'selected' : ''); ?>>📅 Pendiente (Programada)</option>
                            <option value="1" <?php echo e($ti->asistencia === 1 ? 'selected' : ''); ?>>✅ Asistió</option>
                            <option value="0" <?php echo e($ti->asistencia === 0 ? 'selected' : ''); ?>>❌ Falta</option>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Actualizar Datos</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maryj\Mi unidad\UNI\10_Decimo\Proyecto\Proyecto_Tec\proyectoAsesorias\resources\views/docente/tutorias.blade.php ENDPATH**/ ?>