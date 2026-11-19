<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\JefeController;
use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\CoordinadorInstitucionalController;
use App\Http\Controllers\ReporteAnexo19Controller;
use App\Http\Controllers\EncabezadoReporteController;
use App\Http\Controllers\Jefe\AsesorController;

// --- RUTAS PÚBLICAS ---
Route::get('/', [MainController::class, 'pagina'])->name('pagina');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/periodos/activar-global', [PeriodoController::class, 'activarGlobal'])->name('periodo.activar.global');
Route::get('/jefe/alta-docente', [JefeController::class, 'alta_docente'])->name('jefe.alta_docente');
Route::middleware(['auth.custom'])->group(function () {

Route::middleware(['rol:estudiante'])->group(function () {

    // Inicio del alumno
    Route::get('/alumno', [AlumnoController::class, 'inicioalumno'])
        ->name('alumno.index');

    // Canalizaciones
    Route::get('/alumno-canalizaciones', [AlumnoController::class, 'canalizaciones'])
        ->name('alumno.canalizaciones');

    // Tutorías
    Route::get('/alumno-tutorias', [AlumnoController::class, 'tutorias'])
        ->name('alumno.tutorias');

    // Perfil del alumno
    Route::get('/alumno/perfil', [AlumnoController::class, 'perfil'])
        ->name('alumno.perfil');

    // Actualizar contraseña
    Route::post('/alumno/perfil/actualizar-password', [AlumnoController::class, 'updatePasswordAlumno'])
        ->name('alumno.perfil.update_password');

    // Editar foto de perfil
    Route::get('/alumno/perfil/editar-foto', [AlumnoController::class, 'editarFoto'])
        ->name('alumno.perfil.editar-foto');

    // Actualizar foto
    Route::post('/alumno/perfil/actualizar-foto', [AlumnoController::class, 'actualizarFoto'])
        ->name('alumno.perfil.actualizar-foto');

    // Eliminar foto
    Route::post('/alumno/perfil/eliminar-foto', [AlumnoController::class, 'eliminarFoto'])
        ->name('alumno.perfil.eliminar-foto');

    // Prototipo visual de asesorías académicas para el alumno
    Route::get('/alumno-asesorias', function () {
        return view('alumno.asesorias');
    })->name('alumno.asesorias');

    Route::get('/alumno-asesorias', [
    AsesorController::class,
    'catalogo'
])->name('alumno.asesorias');

});

    Route::middleware(['auth.custom', 'rol:Jefe'])->group(function () {
        // Prototipo visual de asesorías académicas
       

    Route::get('/Jefe-Asesorias', [
        AsesorController::class,
        'index'
    ])->name('jefe.asesorias');

    Route::post('/Jefe-Asesorias/asesores', [
        AsesorController::class,
        'store'
    ])->name('jefe.asesores.store');

    Route::get('/Jefe-Asesorias/asesores/{asesor}', [
        AsesorController::class,
        'show'
    ])->name('jefe.asesores.show');

    Route::put('/Jefe-Asesorias/asesores/{asesor}', [
        AsesorController::class,
        'update'
    ])->name('jefe.asesores.update');

    Route::patch('/Jefe-Asesorias/asesores/{asesor}/estado', [
        AsesorController::class,
        'desactivar'
    ])->name('jefe.asesores.desactivar');

    Route::delete(
    '/Jefe-Asesorias/asesores/{asesor}',
    [AsesorController::class, 'destroy']
)->name('jefe.asesores.destroy');


        // 1. INICIO
        Route::get('/Jefe', [JefeController::class, 'inicio'])->name('jefe.index');


        // 2. SECCIÓN: ALUMNOS
        Route::get('/Jefe-Alumnos', [JefeController::class, 'alta_alumno'])->name('jefe.alumnos');
        Route::post('/Jefe-Alumnos/guardar', [JefeController::class, 'guardar_alumno'])->name('jefe.guardar_alumno');
        Route::post('/Jefe-Alumnos/importar', [JefeController::class, 'importar_alumnos_csv'])->name('jefe.importar_alumnos');


        // 3. SECCIÓN: DOCENTES (Alta Exclusiva)
        // Apunta a 'alta_docente'. Como el nombre es 'jefe.docentes', el controlador mostrará la vista exclusiva.
        Route::get('/Jefe-Docente', [JefeController::class, 'alta_docente'])->name('jefe.docentes');


        // 4. SECCIÓN: USUARIOS (Alta General)
        // Apunta también a 'alta_docente'. Como el nombre es 'jefe.usuarios', el controlador mostrará la vista general.
        Route::get('/Jefe-Usuarios', [JefeController::class, 'alta_docente'])->name('jefe.usuarios');

        // RUTA COMPARTIDA PARA GUARDAR (Tanto Docentes como Usuarios usan esta)
        Route::post('/Jefe-Docente/guardar', [JefeController::class, 'storeDocente'])->name('jefe.docentes.store');


        // 5. SECCIÓN: GRUPOS (ALTA - CREACIÓN)
        // Para ver el formulario de creación de grupos nuevos
        Route::get('/Jefe-Grupos/Crear', [JefeController::class, 'vista_crear_grupo'])->name('jefe.grupos.crear');
        Route::post('/Jefe-Grupos/guardar', [JefeController::class, 'guardar_grupo'])->name('jefe.guardar_grupo');


        // 6. SECCIÓN: GRUPOS (ASIGNACIÓN - TUTORES)
        // Para ver la pantalla de asignar tutores y la tabla
        Route::get('/Jefe-Grupos/Asignar', [JefeController::class, 'vista_asignar_grupo'])->name('jefe.grupos.asignar');
        // Nota: Mantenemos el nombre 'jefe.grupos' como alias a esta ruta para compatibilidad con botones viejos si los hubiera
        Route::get('/Jefe-Grupos', [JefeController::class, 'vista_asignar_grupo'])->name('jefe.grupos');

        Route::post('/Jefe-Grupos/vincular', [JefeController::class, 'asignar_grupo'])->name('jefe.asignar_grupo');
        Route::get('/Jefe-Grupos/liberar/{id}', [JefeController::class, 'liberar_grupo'])->name('jefe.liberar_grupo');


        // 7. SECCIÓN: PERFIL
        Route::get('/Jefe-Perfil', [JefeController::class, 'viewPerfil'])->name('jefe.perfil.view');
        Route::post('/Jefe-Perfil/update', [JefeController::class, 'updatePassword'])->name('jefe.perfil.update_password');
        Route::get('/Jefe-Periodos', [JefeController::class, 'alta_periodo'])->name('jefe.periodos');
        Route::post('/Jefe-Periodos/guardar', [JefeController::class, 'storePeriodo'])->name('jefe.guardar_periodo');

        // Rutas de perfil - JEFE - FOTO
        Route::get('/Jefe-Perfil/editar-foto', [JefeController::class, 'editarFoto'])->name('jefe.perfil.editar-foto');
        Route::post('/Jefe-Perfil/actualizar-foto', [JefeController::class, 'actualizarFoto'])->name('jefe.perfil.actualizar-foto');
        Route::post('/Jefe-Perfil/eliminar-foto', [JefeController::class, 'eliminarFoto'])->name('jefe.perfil.eliminar-foto');
    });

    Route::middleware(['rol:Coordinador'])->group(function () {
        Route::get('/Coordinador', [CoordinadorController::class, 'inicio'])->name('coord.index');
        Route::get('/Coordinador-informes', [CoordinadorController::class, 'informes'])->name('coord.informes');
        Route::post('/Coordinador-informes', [CoordinadorController::class, 'subirInforme'])->name('coord.informes.subir');
        Route::get('/Coordinador-reportes', [CoordinadorController::class, 'reportes'])->name('coord.reportes');
        Route::get('/coordinador-seguimiento', [CoordinadorController::class, 'seguimiento'])->name('coord.seguimiento');
         Route::get('/coordinador/perfil', [CoordinadorController::class, 'viewPerfil'])->name('coordinador.perfil.view'); // Usado en el subnav
        Route::post('/coordinador/perfil/actualizar-password', [CoordinadorController::class, 'updatePassword'])->name('coordinador.perfil.update_password'); // Usado en el formulario de la vista perfil.blade.php

        // Rutas de perfil - COORDINADOR - FOTO
        Route::get('/coordinador/perfil/editar-foto', [CoordinadorController::class, 'editarFoto'])->name('coordinador.editar-foto');
        Route::post('/coordinador/perfil/actualizar-foto', [CoordinadorController::class, 'actualizarFoto'])->name('coordinador.actualizar-foto');
        Route::post('/coordinador/perfil/eliminar-foto', [CoordinadorController::class, 'eliminarFoto'])->name('coordinador.eliminar-foto');

        // Ruta de reporte - ANEXO 20
        Route::post('/coordinador/anexo20/generar', [App\Http\Controllers\ReporteAnexo20Controller::class, 'generate'])->name('coordinador.anexo20.generate');
    });


    Route::middleware(['rol:Docente'])->group(function () {
        Route::get('/docente', [DocenteController::class, 'docente'])->name('docente.index');
        Route::get('/docente/tutorias', [DocenteController::class, 'viewTutorias'])->name('docente.tutorias');
        Route::post('/docente/tutorias', [DocenteController::class, 'storeTutoria'])->name('docente.store_tutoria');
        
        Route::get(
            '/docente/canalizaciones',
            [DocenteController::class, 'viewCanalizaciones']
        )->name('docente.canalizaciones');

        Route::post(
            '/docente/canalizaciones',
            [DocenteController::class, 'storeCanalizacion']
        )->name('docente.store_canalizacion');

        Route::put(
            '/docente/canalizaciones/{id}',
            [DocenteController::class, 'updateCanalizacion']
        )->name('docente.update_canalizacion');

        Route::get('/docente/perfil', [DocenteController::class, 'viewPerfil'])->name('docente.perfil.view');
        Route::post('/docente/perfil/actualizar-password', [DocenteController::class, 'updatePassword'])->name('docente.perfil.update_password');
        Route::post('/docente/tutorias/update', [DocenteController::class, 'updateTutoria'])->name('docente.update_tutoria');

        // Rutas de perfil - DOCENTE - FOTO
        Route::get('/docente/perfil/editar-foto', [DocenteController::class, 'editarFoto'])->name('docente.editar-foto');
        Route::post('/docente/perfil/actualizar-foto', [DocenteController::class, 'actualizarFoto'])->name('docente.actualizar-foto');
        Route::post('/docente/perfil/eliminar-foto', [DocenteController::class, 'eliminarFoto'])->name('docente.eliminar-foto');

        // REPORTES

        Route::post('/docente/reporte/anexo19/{id_grupo}/{id_periodo}', [App\Http\Controllers\ReporteAnexo19Controller::class, 'generate'])->name('docente.reporte.anexo19');
        Route::get('/docente/reporte/configurar/{id_grupo}/{id_periodo}', [App\Http\Controllers\ReporteAnexo19Controller::class, 'configurar'])->name('docente.reporte.configurar');
        Route::post('/docente/reporte/guardar-medio/{id_grupo}', [App\Http\Controllers\ReporteAnexo19Controller::class, 'guardarMedioComunicacion'])->name('docente.reporte.guardar_medio');
        Route::post('/docente/reporte/agregar-problema', [App\Http\Controllers\ReporteAnexo19Controller::class, 'agregarProblema'])->name('docente.reporte.agregar_problema');
        Route::post('/docente/reporte/editar-problema', [App\Http\Controllers\ReporteAnexo19Controller::class, 'editarProblema'])->name('docente.reporte.editar_problema');
        Route::delete('/docente/reporte/eliminar-problema/{id_problema}', [App\Http\Controllers\ReporteAnexo19Controller::class, 'eliminarProblema'])->name('docente.reporte.eliminar_problema');
    });

    Route::middleware(['rol:Soporte'])->group(function () {

        // 1. INICIO
        Route::get('/Soporte', [SoporteController::class, 'inicio'])->name('soporte.index');


        // Prototipo visual de asesorías académicas
        Route::get('/Soporte-Asesorias', function () {
            return view('jefe.asesorias');
        })->name('soporte.asesorias');
        // 2. SECCIÓN: GESTIÓN DE ALUMNOS
        Route::get('/Soporte-Alumnos', [SoporteController::class, 'alta_alumno'])->name('soporte.alumnos');
        Route::post('/Soporte-Alumnos/guardar', [SoporteController::class, 'guardar_alumno'])->name('soporte.guardar_alumno');
        Route::post('/Soporte-Alumnos/importar', [SoporteController::class, 'importar_alumnos_csv'])->name('soporte.importar_alumnos');

        // 3. SECCIÓN: GRUPOS (ALTA - CREACIÓN)
        Route::get('/Soporte-Grupos/Crear', [SoporteController::class, 'vista_crear_grupo'])->name('soporte.grupos.crear');
        Route::post('/Soporte-Grupos/guardar', [SoporteController::class, 'guardar_grupo'])->name('soporte.guardar_grupo');

        // 4. SECCIÓN: GRUPOS (ASIGNACIÓN - TUTORES)
        Route::get('/Soporte-Grupos/Asignar', [SoporteController::class, 'vista_asignar_grupo'])->name('soporte.grupos.asignar');
        // Alias para compatibilidad si usas 'soporte.grupos' en algún lugar
        Route::get('/Soporte-Grupos', [SoporteController::class, 'vista_asignar_grupo'])->name('soporte.grupos');

        Route::post('/Soporte-Grupos/vincular', [SoporteController::class, 'asignar_grupo'])->name('soporte.asignar_grupo');
        Route::get('/Soporte-Grupos/liberar/{id}', [SoporteController::class, 'liberar_grupo'])->name('soporte.liberar_grupo');

        // 5. SECCIÓN: PERIODOS ESCOLARES
        Route::get('/Soporte-Periodos', [SoporteController::class, 'alta_periodo'])->name('soporte.periodos');
        Route::post('/Soporte-Periodos/guardar', [SoporteController::class, 'storePeriodo'])->name('soporte.guardar_periodo');

        // 6. SECCION PARA LAS FIRMAS
        Route::get('/firmas', [App\Http\Controllers\FirmaReporteController::class, 'index'])->name('firmas.index');
        Route::post('/firmas/store', [App\Http\Controllers\FirmaReporteController::class, 'store'])->name('firmas.store');
        Route::delete('/firmas/eliminar/{id}', [App\Http\Controllers\FirmaReporteController::class, 'destroy'])->name('firmas.destroy');

        // Las rutas de encabezados se declaran una sola vez más abajo.
    });

    // ==========================================
    // RUTAS PARA ENCABEZADOS DE REPORTE
    // ACCESIBLE POR JEFE Y SOPORTE (CONTROLADO EN CONTROLADOR)
    // ==========================================
    Route::get('/encabezados', [EncabezadoReporteController::class, 'index'])->name('encabezados.index');
    Route::post('/encabezados/subir', [EncabezadoReporteController::class, 'subir'])->name('encabezados.subir');
    Route::delete('/encabezados/eliminar/{id}', [EncabezadoReporteController::class, 'eliminar'])->name('encabezados.eliminar');
    Route::post('/encabezados/activar/{id}', [EncabezadoReporteController::class, 'activar'])->name('encabezados.activar');
    Route::put('/encabezados/desactivar/{id}', [EncabezadoReporteController::class, 'desactivar'])->name('encabezados.desactivar');
});

// RUTA PARA CAMBIAR PERIODO ACTIVO (USADA EN EL SUBNAV)
Route::post('/cambiar-periodo', [App\Http\Controllers\PeriodoController::class, 'cambiarPeriodo'])->name('periodo.cambiar');


// RUTAS PARA COORDINADOR INSTITUCIONAL

// ==========================================
// RUTAS PARA COORDINADOR INSTITUCIONAL
// ==========================================
Route::middleware(['auth.custom', 'rol:Coordinador Institucional'])->group(function () {

    // Dashboard / Inicio
    Route::get('/Coordinador-Institucional', [App\Http\Controllers\CoordinadorInstitucionalController::class, 'index'])->name('coordinst.index');

    // Listados (solo consulta)
    Route::get('/Coordinador-Institucional/estudiantes', [App\Http\Controllers\CoordinadorInstitucionalController::class, 'estudiantes'])->name('coordinst.estudiantes');
    Route::get('/Coordinador-Institucional/docentes', [App\Http\Controllers\CoordinadorInstitucionalController::class, 'docentes'])->name('coordinst.docentes');
    Route::get('/Coordinador-Institucional/tutorias', [App\Http\Controllers\CoordinadorInstitucionalController::class, 'tutorias'])->name('coordinst.tutorias');
    Route::get('/Coordinador-Institucional/canalizaciones', [App\Http\Controllers\CoordinadorInstitucionalController::class, 'canalizaciones'])->name('coordinst.canalizaciones');

    // Perfil
    Route::get('/Coordinador-Institucional/perfil', [App\Http\Controllers\CoordinadorInstitucionalController::class, 'perfil'])->name('coordinst.perfil.view');
    Route::post('/Coordinador-Institucional/perfil/actualizar-password', [App\Http\Controllers\CoordinadorInstitucionalController::class, 'updatePassword'])->name('coordinst.perfil.update_password');

    // Foto de perfil
    Route::get('/Coordinador-Institucional/perfil/editar-foto', [App\Http\Controllers\CoordinadorInstitucionalController::class, 'editarFoto'])->name('coordinst.editar-foto');
    Route::post('/Coordinador-Institucional/perfil/actualizar-foto', [App\Http\Controllers\CoordinadorInstitucionalController::class, 'actualizarFoto'])->name('coordinst.actualizar-foto');
    Route::post('/Coordinador-Institucional/perfil/eliminar-foto', [App\Http\Controllers\CoordinadorInstitucionalController::class, 'eliminarFoto'])->name('coordinst.eliminar-foto');
});
