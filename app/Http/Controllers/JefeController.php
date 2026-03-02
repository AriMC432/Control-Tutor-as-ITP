<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Generacion;
use App\Models\Grupo;
use App\Models\Estudiante;
use App\Models\Docente;
use App\Models\Rol;
use App\Models\Periodo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class JefeController extends Controller
{
    public function inicio()
    {
        return view('jefe.index');
    }

    // ==========================================
    // 1. SECCIÓN: GESTIÓN DE ALUMNOS
    // ==========================================

    public function alta_alumno()
    {
        $carreras = Carrera::all();
        $generaciones = Generacion::all();

        $periodoActual = Periodo::where('activo', 1)->first();

        if ($periodoActual) {
            $grupos = Grupo::where('id_periodo', $periodoActual->id_periodo)
                ->with(['carrera', 'generacion'])
                ->get();
        } else {
            $grupos = collect();
        }

        return view('jefe.alumnos', compact('carreras', 'generaciones', 'grupos'));
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

        return redirect()->route('jefe.alumnos')->with('success', 'Alumno registrado correctamente.');
    }

    public function importar_alumnos_csv(Request $request)
    {
        $request->validate(['archivo_csv' => 'required|file|mimes:csv,txt']);

        $file = $request->file('archivo_csv');
        $handle = fopen($file->getPathname(), 'r');

        $registrados = 0;
        $errores = [];
        $fila = 1;

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
                    $generacion = Generacion::where('ano_inicio', $anios[0])->where('ano_fin', $anios[1])->first();
                }
                if (!$generacion) {
                    $errores[] = "Fila $fila: Generación no encontrada.";
                    $fila++;
                    continue;
                }

                $grupo->id_carrera = $carrera->id_carrera;
                $grupo->id_generacion = $generacion->id_generacion;
                if ($idPeriodo) {
                    $grupo->id_periodo = $idPeriodo;
                }
                $grupo->save();

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
                return redirect()->route('jefe.alumnos')->with('warning', "Importados $registrados. Errores: " . implode(' | ', $errores));
            }
            return redirect()->route('jefe.alumnos')->with('success', "Se importaron $registrados alumnos correctamente.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('jefe.alumnos')->with('error', 'Error crítico: ' . $e->getMessage());
        } finally {
            fclose($handle);
        }
    }


    // ==========================================
    // 2. SECCIÓN: DOCENTES Y USUARIOS
    // ==========================================

    public function alta_docente()
    {
        $roles = Rol::all();
        if (request()->routeIs('jefe.usuarios')) {
            return view('jefe.docente', compact('roles'));
        }
        return view('jefe.docente', compact('roles'));
    }

    public function storeDocente(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'paterno' => 'required|string|max:100',
            'materno' => 'nullable|string|max:100',
            'num_control' => 'required|string|max:20|unique:DOCENTE,num_control',
            'correo' => 'required|email|max:100|unique:DOCENTE,correo',
            'contrasena' => 'required|string|min:6',
            'id_rol' => 'required|exists:ROLES,id_rol',
        ]);

        $docente = new Docente();
        $docente->nombre = $request->nombre;
        $docente->paterno = $request->paterno;
        $docente->materno = $request->materno;
        $docente->num_control = $request->num_control;
        $docente->correo = $request->correo;
        $docente->contrasena = Hash::make($request->contrasena);
        $docente->id_rol = $request->id_rol;

        $docente->save();

        return back()->with('success', 'Usuario registrado exitosamente.');
    }


    // ==========================================
    // 3. SECCIÓN: GRUPOS (ALTA - CREACIÓN)
    // ==========================================

    public function vista_crear_grupo()
    {
        $periodoActual = Periodo::where('activo', 1)->first();
        $carreras = Carrera::all();
        $generaciones = Generacion::all();

        return view('jefe.alta_grupos', compact('carreras', 'generaciones', 'periodoActual'));
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
    // 4. SECCIÓN: GRUPOS (ASIGNACIÓN - TUTORES)
    // ==========================================

    public function vista_asignar_grupo()
    {
        $periodoActual = Periodo::where('activo', 1)->first();

        if (!$periodoActual) {
            return view('jefe.asignar_grupos', [
                'docentes' => [],
                'grupos' => [],
                'asignaciones' => []
            ])->withErrors('No hay un periodo activo.');
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

        return view('jefe.grupos', compact('docentes', 'grupos', 'asignaciones', 'periodoActual'));
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

        return redirect()->route('jefe.grupos.asignar')->with('success', "Grupo asignado correctamente.");
    }

    public function liberar_grupo($id_grupo)
    {
        $grupo = Grupo::findOrFail($id_grupo);
        $grupo->id_docente = null;
        $grupo->save();

        return redirect()->route('jefe.grupos.asignar')->with('success', "Grupo liberado.");
    }


    // ==========================================
    // 5. SECCIÓN: PERIODOS ESCOLARES (NUEVO)
    // ==========================================

    /**
     * Muestra la vista de gestión de periodos.
     */
    public function alta_periodo()
    {
        // Traemos todos los periodos para mostrarlos en la tabla de historial
        $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();
        return view('jefe.periodos', compact('periodos'));
    }

    /**
     * Crea un nuevo periodo y lo establece como activo.
     */
    public function storePeriodo(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50', // Ej: "Agosto-Diciembre 2026"
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        // Usamos una transacción para asegurar integridad
        DB::transaction(function () use ($request) {

            // 1. Desactivamos TODOS los periodos existentes
            Periodo::query()->update(['activo' => 0]);

            // 2. Creamos el nuevo periodo como ACTIVO (1)
            Periodo::create([
                'nombre' => $request->nombre,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'activo' => 1
            ]);
        });

        return back()->with('success', 'Nuevo ciclo escolar iniciado. Se ha establecido como el periodo activo.');
    }


    // ==========================================
    // 6. SECCIÓN: PERFIL
    // ==========================================

    public function viewPerfil()
    {
        $idUsuario = Session::get('user_id');
        $usuario = Docente::with('rol')->findOrFail($idUsuario);
        return view('jefe.perfil', compact('usuario'));
    }

    public function updatePassword(Request $request)
    {
        $idDocente = Session::get('user_id');
        $usuario = Docente::findOrFail($idDocente);

        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($usuario) {
                if (!Hash::check($value, $usuario->contrasena)) {
                    $fail('La contraseña actual no es correcta.');
                }
            }],
            'password' => 'required|string|min:6|confirmed',
        ]);

        $usuario->contrasena = Hash::make($request->password);
        $usuario->save();

        return back()->with('success', 'Contraseña actualizada exitosamente.');
    }

    // Editar foto -- JEFE

    public function editarFoto()
    {
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

        return view('jefe.editar-foto', compact('usuario'));
    }

    // Actualizar foto de perfil -- JEFE

    public function actualizarFoto(Request $request)
    {
        $userId = Session::get('user_id');
        $usuario  = Docente::findOrFail($userId);

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'foto.required' => 'Debes seleccionar una imagen.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif.',
            'foto.max' => 'La imagen no debe pesar más de 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior
            if ($usuario->foto && file_exists(storage_path('app/public/fotos/docentes/' . $usuario->foto))) {
                unlink(storage_path('app/public/fotos/docentes/' . $usuario->foto));
            }

            // Guardar nueva foto
            $extension = $request->file('foto')->getClientOriginalExtension();
            $nombreArchivo = $usuario->num_control . '.' . $extension;
            $path = $request->file('foto')->storeAs('fotos/docentes', $nombreArchivo, 'public');

            $usuario->foto = $nombreArchivo;
            $usuario->save();

            return redirect()->route('jefe.perfil.view')->with('success', 'Foto actualizada correctamente.');
        }

        return back()->with('error', 'No se pudo subir la foto.');
    }

    //  Eliminar foto de perfil -- JEFE
    public function eliminarFoto()
    {
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

        if ($usuario->foto) {
            $rutaArchivo = storage_path('app/public/fotos/docentes/' . $usuario->foto);
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }

            $usuario->foto = null;
            $usuario->save();

            return redirect()->route('jefe.perfil.view')->with('success', 'Foto eliminada correctamente.');
        }

        return back()->with('error', 'No hay foto para eliminar.');
    }
}
