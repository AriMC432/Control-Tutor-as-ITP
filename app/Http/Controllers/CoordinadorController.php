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

class CoordinadorController extends Controller
{
    public function inicio()
    {
        return view('coordinador.index');
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

        // 1. Validación de datos
        $request->validate([
            // Verificar que la contraseña actual sea correcta (usando el campo 'contrasena' del modelo Docente)
            'current_password' => ['required', function ($attribute, $value, $fail) use ($usuario) {
                if (!Hash::check($value, $usuario->contrasena)) {
                    $fail('La contraseña actual ingresada no es correcta.');
                }
            }],
            
            // Nueva contraseña: Mínimo 6 caracteres y debe coincidir con 'password_confirmation'
            'password' => 'required|string|min:6|confirmed', 

        ], [
            // Mensajes de error personalizados
            'current_password.required' => 'Debes ingresar tu contraseña actual para confirmar el cambio.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ]);

        // 2. Actualizar la contraseña
        $usuario->contrasena = Hash::make($request->password);
        $usuario->save();

        // 3. Redireccionar con éxito
        return back()->with('success', 'Contraseña actualizada exitosamente.');
    }
}