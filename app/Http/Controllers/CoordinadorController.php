<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Estudiante;
use App\Models\TutoriaIndividual;
use App\Models\TutoriaGrupal;
use App\Models\DetalleTutoriaGrupal;
use App\Models\Canalizacion;
use App\Models\Docente;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Password;

class CoordinadorController extends Controller
{
    public function inicio()
    {
        $periodoActivo = DB::table('periodo')->where('activo', 1)->first();
        return view('coordinador.index', compact('periodoActivo'));
    }

    public function informes()
    {
        return view('coordinador.informes');
    }

    public function reportes()
    {
        return view('coordinador.reportes');
    }

    public function seguimiento()
    {
        return view('coordinador.seguimiento');
    }


    public function viewPerfil()
    {
        $idUsuario = Session::get('user_id');

        // Buscar el objeto Docente (que incluye al Coordinador)
        // Usamos with('rol') para poder mostrar el rol en la vista
        $usuario = Docente::with('rol')->findOrFail($idUsuario);

        return view('coordinador.perfil', compact('usuario'));
    }

    /**
     * Procesa la actualización de la contraseña del Coordinador logueado.
     */
    public function updatePassword(Request $request)
    {
        $idUsuario = Session::get('user_id');
        $usuario = Docente::findOrFail($idUsuario);

        // 1. Validación de datos con reglas Pro
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($usuario) {
                    if (!Hash::check($value, $usuario->contrasena)) {
                        $fail('La contraseña actual ingresada no es correcta.');
                    }
                }
            ],

            // Nueva contraseña: Reglas robustas
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()      // Al menos una letra
                    ->mixedCase()    // Mayúsculas y minúsculas
                    ->numbers()      // Al menos un número
                    ->symbols()      // Al menos un símbolo (!@#$%...)
                    ->uncompromised(), // Verifica que no haya sido hackeada antes
            ],

        ], [
            // Mensajes de error personalizados y traducidos
            'current_password.required' => 'Debes ingresar tu contraseña actual para confirmar el cambio.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.letters' => 'La contraseña debe contener al menos una letra.',
            'password.mixed' => 'La contraseña debe contener mayúsculas y minúsculas.',
            'password.numbers' => 'La contraseña debe contener al menos un número.',
            'password.symbols' => 'La contraseña debe contener al menos un símbolo.',
            'password.uncompromised' => 'Esta contraseña es poco segura porque ha aparecido en filtraciones de datos. Elige una más original.',
        ]);

        // 2. Actualizar la contraseña
        $usuario->contrasena = Hash::make($request->password);
        $usuario->save();

        // 3. Redireccionar con éxito
        return back()->with('success', '¡Tu contraseña se cambió correctamente!');
    }

    // Formulario para editar foto -- COORDINADOR
    public function editarFoto()
    {
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

        return view('coordinador.editar-foto', compact('usuario'));
    }

    // Actualizar foto -- COORDINADOR
    public function actualizarFoto(Request $request)
    {
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

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

            return redirect()->route('coordinador.perfil.view')->with('success', 'Foto actualizada correctamente.');
        }

        return back()->with('error', 'No se pudo subir la foto.');
    }

    // Eliminar foto -- COORDINADOR
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

            return redirect()->route('coordinador.perfil.view')->with('success', 'Foto eliminada correctamente.');
        }

        return back()->with('error', 'No hay foto para eliminar.');
    }
}
