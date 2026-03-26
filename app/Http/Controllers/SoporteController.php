<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Generacion;
use App\Models\Grupo;
use App\Models\Estudiante;
use App\Models\Docente;
use App\Models\Periodo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Session; -- Incluir en caso de hacer perfil

class SoporteController extends Controller
{
    /**
     * DASHBOARD SOPORTE
     */
    public function inicio()
    {
        $periodoActivo = DB::table('periodo')->where('activo', 1)->first();
        return view('soporte.index', compact('periodoActivo'));
    }

    // ==========================================
    // 1. GESTIÓN DE ALUMNOS
    // ==========================================

    public function alta_alumno()
    {
        $carreras = Carrera::all();
        $generaciones = Generacion::all();

        // Filtro por Periodo Activo
        $periodoActual = Periodo::where('activo', 1)->first();

        if ($periodoActual) {
            $grupos = Grupo::where('id_periodo', $periodoActual->id_periodo)
                ->with(['carrera', 'generacion'])
                ->get();
        } else {
            $grupos = collect();
        }

        return view('soporte.alumnos', compact('carreras', 'generaciones', 'grupos'));
    }

    public function guardar_alumno(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'paterno' => 'required|string|max:100',
            'materno' => 'nullable|string|max:100',
            'num_control' => 'required|unique:ESTUDIANTE,num_control|max:20',
            'correo' => 'required|email|unique:ESTUDIANTE,correo|max:100',
            'contrasena' => 'required|min:6',
            'id_grupo' => 'required|exists:GRUPO,id_grupo',
        ]);

        Estudiante::create([
            'nombre' => $request->nombre,
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'num_control' => $request->num_control,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena),
            'id_grupo' => $request->id_grupo,
        ]);

        return redirect()->route('soporte.alumnos')->with('success', 'Alumno registrado correctamente.');
    }

    public function importar_alumnos_csv(Request $request)
    {
        $request->validate([
            'archivo_csv' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('archivo_csv');
        $handle = fopen($file->getPathname(), 'r');

        $registrados = 0;
        $errores = [];
        $fila = 1;

        // Obtenemos periodo activo para asignar a nuevos grupos si se crean
        $periodoActual = Periodo::where('activo', 1)->first();
        $idPeriodo = $periodoActual ? $periodoActual->id_periodo : null;

        DB::beginTransaction();

        try {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if (count($data) < 9) {
                    $errores[] = "Fila $fila: Datos incompletos.";
                    $fila++;
                    continue;
                }

                $nombre = trim($data[0]);
                if (strtolower($nombre) == 'nombre') {
                    $fila++;
                    continue;
                }

                $paterno = trim($data[1]);
                $materno = trim($data[2]);
                $num_control = trim($data[3]);
                $correo = trim($data[4]);
                $contrasena = trim($data[5]);

                $nombre_grupo = trim($data[6]);
                $nombre_carrera = trim($data[7]);
                $texto_generacion = trim($data[8]);

                if (Estudiante::where('num_control', $num_control)->exists()) {
                    $errores[] = "Fila $fila: El No. Control $num_control ya existe.";
                    $fila++;
                    continue;
                }
                if (Estudiante::where('correo', $correo)->exists()) {
                    $errores[] = "Fila $fila: El correo $correo ya existe.";
                    $fila++;
                    continue;
                }

                // Lógica de Grupo/Carrera/Generación
                $grupo = Grupo::where('nombre', $nombre_grupo)->first();
                if (!$grupo) {
                    $errores[] = "Fila $fila: El grupo '$nombre_grupo' no existe.";
                    $fila++;
                    continue;
                }

                $carrera = Carrera::where('nombre', $nombre_carrera)->first();
                if (!$carrera) {
                    $errores[] = "Fila $fila: La carrera '$nombre_carrera' no existe.";
                    $fila++;
                    continue;
                }

                $anios = preg_split('/[^0-9]+/', $texto_generacion, -1, PREG_SPLIT_NO_EMPTY);
                $generacion = null;
                if (count($anios) >= 2) {
                    $generacion = Generacion::where('ano_inicio', $anios[0])
                        ->where('ano_fin', $anios[1])
                        ->first();
                }

                if (!$generacion) {
                    $errores[] = "Fila $fila: Generación no encontrada.";
                    $fila++;
                    continue;
                }

                // Actualizar Grupo
                $grupo->id_carrera = $carrera->id_carrera;
                $grupo->id_generacion = $generacion->id_generacion;
                if ($idPeriodo) {
                    $grupo->id_periodo = $idPeriodo;
                }
                $grupo->save();

                // Crear Estudiante
                Estudiante::create([
                    'nombre' => $nombre,
                    'paterno' => $paterno,
                    'materno' => $materno,
                    'num_control' => $num_control,
                    'correo' => $correo,
                    'contrasena' => Hash::make($contrasena),
                    'id_grupo' => $grupo->id_grupo,
                ]);

                $registrados++;
                $fila++;
            }

            DB::commit();

            if (count($errores) > 0) {
                return redirect()->route('soporte.alumnos')
                    ->with('warning', "Importados $registrados. Errores: " . implode(' | ', $errores));
            }

            return redirect()->route('soporte.alumnos')
                ->with('success', "Se importaron $registrados alumnos correctamente.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('soporte.alumnos')
                ->with('error', 'Error crítico: ' . $e->getMessage());
        } finally {
            fclose($handle);
        }
    }


    // ==========================================
    // 2. SECCIÓN: GRUPOS (CREACIÓN - ALTA)
    // ==========================================

    public function vista_crear_grupo()
    {
        $periodoActual = Periodo::where('activo', 1)->first();
        $carreras = Carrera::all();
        $generaciones = Generacion::all();

        // Nota: Debes crear la vista resources/views/soporte/alta_grupos.blade.php
        return view('soporte.alta_grupos', compact('carreras', 'generaciones', 'periodoActual'));
    }

    public function guardar_grupo(Request $request)
    {
        $periodoActual = Periodo::where('activo', 1)->first();

        if (!$periodoActual) {
            return back()->with('error', 'No se puede crear el grupo: No hay periodo activo.');
        }

        $request->validate([
            'nombre' => 'required|string|max:20',
            'semestre' => 'required|integer|min:1|max:14',
            'id_carrera' => 'required|exists:CARRERAS,id_carrera',
            'id_generacion' => 'required|exists:GENERACION,id_generacion',
        ]);

        $grupo = new Grupo();
        $grupo->nombre = $request->nombre;
        $grupo->semestre = $request->semestre;
        $grupo->id_carrera = $request->id_carrera;
        $grupo->id_generacion = $request->id_generacion;
        $grupo->id_periodo = $periodoActual->id_periodo;

        $grupo->save();

        return back()->with('success', 'Grupo creado exitosamente en el periodo actual.');
    }


    // ==========================================
    // 3. SECCIÓN: GRUPOS (ASIGNACIÓN - TUTORES)
    // ==========================================

    public function vista_asignar_grupo()
    {
        $periodoActual = Periodo::where('activo', 1)->first();

        if (!$periodoActual) {
            return back()->withErrors('No hay un periodo activo.');
        }

        $docentes = Docente::where('id_rol', 2)->get();

        $grupos = Grupo::where('id_periodo', $periodoActual->id_periodo)
            ->whereNull('id_docente')
            ->with('carrera')
            ->get();

        $asignaciones = Grupo::where('id_periodo', $periodoActual->id_periodo)
            ->whereNotNull('id_docente')
            ->with(['docente', 'carrera', 'generacion'])
            ->get();


        return view('soporte.grupos', compact('docentes', 'grupos', 'asignaciones', 'periodoActual'));
    }

    public function asignar_grupo(Request $request)
    {
        $request->validate([
            'id_docente' => 'required|exists:DOCENTE,id_docente',
            'id_grupo' => 'required|exists:GRUPO,id_grupo',
        ]);

        $grupo = Grupo::findOrFail($request->id_grupo);
        $grupo->id_docente = $request->id_docente;
        $grupo->save();

        return redirect()->route('soporte.grupos.asignar')->with('success', "Grupo asignado correctamente.");
    }

    public function liberar_grupo($id_grupo)
    {
        $grupo = Grupo::findOrFail($id_grupo);
        $grupo->id_docente = null;
        $grupo->save();

        return redirect()->route('soporte.grupos.asignar')->with('success', "Grupo liberado.");
    }


    // ==========================================
    // 4. SECCIÓN: PERIODOS ESCOLARES
    // ==========================================

    public function alta_periodo()
    {
        $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();

        return view('soporte.periodos', compact('periodos'));
    }

    public function storePeriodo(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        DB::transaction(function () use ($request) {
            Periodo::query()->update(['activo' => 0]);

            Periodo::create([
                'nombre' => $request->nombre,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'activo' => 1
            ]);
        });

        return back()->with('success', 'Nuevo periodo creado y activado.');
    }

    // Formulario para editar foto -- SOPORTE
    // Actualizar foto perfil -- SOPORTE
    // Eliminar foto perfil -- SOPORTE

}
