<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Estudiante;
use App\Models\Docente;
use App\Models\TutoriaIndividual;
use App\Models\TutoriaGrupal;
use App\Models\Canalizacion;
use App\Models\Grupo;
use App\Models\Periodo;
use App\Models\Carrera;
use Illuminate\Validation\Rules\Password;

class CoordinadorInstitucionalController extends Controller
{
    // mostrar dashboard principal con estadisticas

    public function index()
    {
        // Estadísticas básicas
        $totalEstudiantes = Estudiante::count();
        $totalDocentes = Docente::count();
        $totalGrupos = Grupo::count();
        $totalCarreras = Carrera::count();

        // Tutorías
        $totalTutoriasIndividuales = TutoriaIndividual::count();
        $totalTutoriasGrupales = TutoriaGrupal::count();

        // Canalizaciones
        $totalCanalizaciones = Canalizacion::count();

        // Periodo activo
        $periodoActivo = Periodo::where('activo', 1)->first();

        // Tutorías del periodo activo (si existe)
        $tutoriasIndividualesPeriodo = 0;
        $tutoriasGrupalesPeriodo = 0;

        if ($periodoActivo) {
            $tutoriasIndividualesPeriodo = TutoriaIndividual::whereBetween('fecha', [$periodoActivo->fecha_inicio, $periodoActivo->fecha_fin])->count();
            $tutoriasGrupalesPeriodo = TutoriaGrupal::whereBetween('fecha', [$periodoActivo->fecha_inicio, $periodoActivo->fecha_fin])->count();
        }

        return view('coordinador_institucional.index', compact(
            'totalEstudiantes',
            'totalDocentes',
            'totalGrupos',
            'totalCarreras',
            'totalTutoriasIndividuales',
            'totalTutoriasGrupales',
            'totalCanalizaciones',
            'periodoActivo',
            'tutoriasIndividualesPeriodo',
            'tutoriasGrupalesPeriodo'
        ));
    }

    // Lista de estudiantes

    public function estudiantes()
    {
        $estudiantes = Estudiante::with('grupo.carrera')->get();
        $periodoActivo = Periodo::where('activo', 1)->first();

        return view('coordinador_institucional.estudiantes', compact('estudiantes', 'periodoActivo'));
    }

    // lista de docentes
    public function docentes()
    {
        $docentes = Docente::with('rol')->get();
        $periodoActivo = Periodo::where('activo', 1)->first();

        return view('coordinador_institucional.docentes', compact('docentes', 'periodoActivo'));
    }

    // lista de todas las tutorias

    public function tutorias()
    {
        $periodoActivo = Periodo::where('activo', 1)->first();

        // Tutorías individuales con relaciones
        $tutoriasIndividuales = TutoriaIndividual::with(['estudiante', 'docente'])
            ->orderBy('fecha', 'desc')
            ->get();

        // Tutorías grupales con relaciones
        $tutoriasGrupales = TutoriaGrupal::with(['grupo', 'docente'])
            ->orderBy('fecha', 'desc')
            ->get();

        return view('coordinador_institucional.tutorias', compact(
            'tutoriasIndividuales',
            'tutoriasGrupales',
            'periodoActivo'
        ));
    }

    // lista de todas las canalilzaciones 

    public function canalizaciones()
    {
        $periodoActivo = Periodo::where('activo', 1)->first();

        $canalizaciones = Canalizacion::with(['tutoria.estudiante', 'area'])
            ->orderBy('fecha', 'desc')
            ->get();

        return view('coordinador_institucional.canalizaciones', compact('canalizaciones', 'periodoActivo'));
    }

    // perfil 

    public function perfil()
    {
        $idUsuario = Session::get('user_id');
        $usuario = Docente::with('rol')->findOrFail($idUsuario);

        return view('coordinador_institucional.perfil', compact('usuario'));
    }

    /**
     * Actualizar perfil (datos personales)
     */
    public function updatePerfil(Request $request)
    {
        $idUsuario = Session::get('user_id');
        $usuario = Docente::findOrFail($idUsuario);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'paterno' => 'required|string|max:100',
            'materno' => 'nullable|string|max:100',
            'correo' => 'required|email|max:100|unique:docente,correo,' . $idUsuario . ',id_docente',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->paterno = $request->paterno;
        $usuario->materno = $request->materno;
        $usuario->correo = $request->correo;
        $usuario->save();

        // Actualizar nombre en sesión
        Session::put('user_name', $usuario->nombre . ' ' . $usuario->paterno);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Actualizar contraseña
     */
    public function updatePassword(Request $request)
    {
        $idUsuario = Session::get('user_id');
        $usuario = Docente::findOrFail($idUsuario);

        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($usuario) {
                    if (!Hash::check($value, $usuario->contrasena)) {
                        $fail('La contraseña actual ingresada no es correcta.');
                    }
                }
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ], [
            'current_password.required' => 'Debes ingresar tu contraseña actual.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.letters' => 'La contraseña debe contener al menos una letra.',
            'password.mixed' => 'La contraseña debe contener mayúsculas y minúsculas.',
            'password.numbers' => 'La contraseña debe contener al menos un número.',
            'password.symbols' => 'La contraseña debe contener al menos un símbolo.',
        ]);

        $usuario->contrasena = Hash::make($request->password);
        $usuario->save();

        return back()->with('success', 'Contraseña actualizada exitosamente.');
    }

    /**
     * Mostrar formulario para editar foto
     */

    /**
     * FORMULARIO PARA EDITAR FOTO
     */
    public function editarFoto()
    {
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

        if ($usuario->foto) {
            $usuario->foto_url = asset('storage/fotos/docentes/' . $usuario->foto);
        } else {
            $usuario->foto_url = asset('images/default-avatar.png');
        }

        return view('coordinador_institucional.editar-foto', compact('usuario'));
    }

    /**
     * ACTUALIZAR FOTO
     */
    public function actualizarFoto(Request $request)
    {
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior
            if ($usuario->foto && file_exists(storage_path('app/public/fotos/docentes/' . $usuario->foto))) {
                unlink(storage_path('app/public/fotos/docentes/' . $usuario->foto));
            }

            $extension = $request->file('foto')->getClientOriginalExtension();
            $nombreArchivo = $usuario->num_control . '.' . $extension;
            $request->file('foto')->storeAs('fotos/docentes', $nombreArchivo, 'public');

            $usuario->foto = $nombreArchivo;
            $usuario->save();

            return redirect()->route('coordinst.perfil.view')->with('success', 'Foto actualizada correctamente.');
        }

        return back()->with('error', 'No se pudo subir la foto.');
    }


    // Eliminar foto

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

            return redirect()->route('coordinst.perfil.view')->with('success', 'Foto eliminada correctamente.');
        }

        return back()->with('error', 'No hay foto para eliminar.');
    }
}
