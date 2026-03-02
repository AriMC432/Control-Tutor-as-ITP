<?php

use Illuminate\Support\Facades\Route;
use WhichBrowser\Parser;
use App\Http\Controllers\MainController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\JefeController;
use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SoporteController;

// --- RUTAS PÚBLICAS ---
Route::get('/', [MainController::class, 'pagina'])->name('pagina');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth.custom'])->group(function () {

    Route::middleware(['rol:estudiante'])->group(function () {
        Route::get('/alumno', [AlumnoController::class, 'inicioalumno'])->name('alumno.index');
        Route::get('/alumno-canalizaciones', [AlumnoController::class, 'canalizaciones'])->name('alumno.canalizaciones');
        Route::get('/alumno-tutorias', [AlumnoController::class, 'tutorias'])->name('alumno.tutorias');
        Route::get('/alumno/perfil', [AlumnoController::class, 'perfil'])->name('alumno.perfil');
        Route::post('/alumno/perfil/actualizar-password', [AlumnoController::class, 'updatePasswordAlumno'])->name('alumno.perfil.update_password');

        // Rutas de perfil - ALUMNO - FOTO
        Route::get('/alumno/perfil/editar-foto', [AlumnoController::class, 'editarFoto'])->name('alumno.perfil.editar-foto');
        Route::post('/alumno/perfil/actualizar-foto', [AlumnoController::class, 'actualizarFoto'])->name('alumno.perfil.actualizar-foto');
        Route::post('/alumno/perfil/eliminar-foto', [AlumnoController::class, 'eliminarFoto'])->name('alumno.perfil.eliminar-foto');
    });

    Route::middleware(['auth.custom', 'rol:Jefe'])->group(function () {

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
        Route::get('/Coordinador-reportes', [CoordinadorController::class, 'reportes'])->name('coord.reportes');
        Route::get('/coordinador-seguimiento', [CoordinadorController::class, 'seguimiento'])->name('coord.seguimiento');
        Route::get('/coordinador/perfil', [CoordinadorController::class, 'viewPerfil'])->name('coordinador.perfil.view'); // Usado en el subnav
        Route::post('/coordinador/perfil/actualizar-password', [CoordinadorController::class, 'updatePassword'])->name('coordinador.perfil.update_password'); // Usado en el formulario de la vista perfil.blade.php

        // Rutas de perfil - COORDINADOR - FOTO
        Route::get('/coordinador/perfil/editar-foto', [CoordinadorController::class, 'editarFoto'])->name('coordinador.editar-foto');
        Route::post('/coordinador/perfil/actualizar-foto', [CoordinadorController::class, 'actualizarFoto'])->name('coordinador.actualizar-foto');
        Route::post('/coordinador/perfil/eliminar-foto', [CoordinadorController::class, 'eliminarFoto'])->name('coordinador.eliminar-foto');

    });


    Route::middleware(['rol:Docente'])->group(function () {
        Route::get('/docente', [DocenteController::class, 'docente'])->name('docente.index');
        Route::get('/docente/tutorias', [DocenteController::class, 'viewTutorias'])->name('docente.tutorias');
        Route::post('/docente/tutorias', [DocenteController::class, 'storeTutoria'])->name('docente.store_tutoria');
        Route::get('/docente/canalizaciones', [DocenteController::class, 'viewCanalizaciones'])->name('docente.canalizaciones');
        Route::post('/docente/canalizaciones', [DocenteController::class, 'storeCanalizacion'])->name('docente.store_canalizacion');
        Route::put('/docente/canalizaciones/{id}', [DocenteController::class, 'updateCanalizacionStatus'])->name('docente.update_canalizacion');
        Route::get('/docente/perfil', [DocenteController::class, 'viewPerfil'])->name('docente.perfil.view');
        Route::post('/docente/perfil/actualizar-password', [DocenteController::class, 'updatePassword'])->name('docente.perfil.update_password');
        Route::post('/Docente-Tutorias/Update', [DocenteController::class, 'updateTutoria'])->name('docente.update_tutoria');
        Route::post('/docente/tutorias/update', [DocenteController::class, 'updateTutoria'])->name('docente.update_tutoria');
        Route::post('/docente/canalizaciones/update', [DocenteController::class, 'updateCanalizacion'])->name('docente.update_canalizacion');
        Route::put('/docente/canalizaciones/{id}', [DocenteController::class, 'updateCanalizacion'])->name('docente.update_canalizacion');

        // Rutas de perfil - DOCENTE - FOTO
        Route::get('/docente/perfil/editar-foto', [DocenteController::class, 'editarFoto'])->name('docente.editar-foto');
        Route::post('/docente/perfil/actualizar-foto', [DocenteController::class, 'actualizarFoto'])->name('docente.actualizar-foto');
        Route::post('/docente/perfil/eliminar-foto', [DocenteController::class, 'eliminarFoto'])->name('docente.eliminar-foto');
    });

    Route::middleware(['rol:Soporte'])->group(function () {

        // 1. INICIO
        Route::get('/Soporte', [SoporteController::class, 'inicio'])->name('soporte.index');

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
    });

    // RUTA PARA WHICHBROWSER DE PRUEBA - BORRAR

    Route::get('/test-browser', function () {
        $userAgent = request()->header('User-Agent');

        if (!$userAgent) {
            return "No se detectó User-Agent";
        }

        $result = new WhichBrowser\Parser($userAgent);

        return [
            'user_agent' => substr($userAgent, 0, 100) . '...',
            'navegador' => $result->browser->toString() ?: 'Desconocido',
            'version' => $result->browser->version ?: 'Desconocido',
            'sistema_operativo' => $result->os->toString() ?: 'Desconocido',
            'dispositivo' => $result->device->type ?: 'Desconocido',
            'fabricante' => $result->device->manufacturer ?: 'Desconocido',
            'modelo' => $result->device->model ?: 'Desconocido',
            'es_bot' => $result->device->type === 'bot' ? 'Sí' : 'No'
        ];
    });
});
