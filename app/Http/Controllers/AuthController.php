<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Rol; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('inicio_sesion.iniciosesion'); 
    }

    public function login(Request $request)
    {
        // 1. Validar los datos
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // ---------------------------------------------------------
        // 1. BUSCAR EN TABLA ESTUDIANTE
        // ---------------------------------------------------------
        $estudiante = Estudiante::where('correo', $credentials['email'])->first();

        if ($estudiante && Hash::check($credentials['password'], $estudiante->contrasena)) {
            
            Session::put('user_type', 'estudiante');
            Session::put('user_id', $estudiante->id_estudiante);
            
            // Concatenamos Nombre + Apellido
            $nombreCompleto = $estudiante->nombre . ' ' . $estudiante->paterno;
            Session::put('user_name', $nombreCompleto);

            return redirect()->intended(route('alumno.index'));
        }

        // ---------------------------------------------------------
        // 2. BUSCAR EN TABLA DOCENTE (Aquí están SuperAdmin, Jefe, etc.)
        // ---------------------------------------------------------
        $docente = docente::with('rol') 
                      ->where('correo', $credentials['email'])
                      ->first();

        if ($docente && Hash::check($credentials['password'], $docente->contrasena)) {
            
            if (!$docente->rol) {
                return back()->with('error', 'El usuario no tiene un rol asignado. Contacte al soporte.');
            }

            $roleName = $docente->rol->nombre; // Ej: 'SuperAdmin', 'Jefe', 'Docente'

            Session::put('user_type', 'docente'); // Se usa 'docente' porque está en la tabla docente
            Session::put('user_id', $docente->id_docente);
            
            $nombreCompleto = $docente->nombre . ' ' . $docente->paterno;
            Session::put('user_name', $nombreCompleto);
            
            Session::put('user_role', $roleName);

            // --- REDIRECCIÓN SEGÚN EL ROL ---
            switch ($roleName) {

                case 'Jefe': 
                    return redirect()->intended(route('jefe.index'));
                
                case 'Coordinador': 
                    return redirect()->intended(route('coord.index'));

                case 'Soporte': 
                    return redirect()->intended(route('soporte.index'));
                
                case 'Docente':
                default: 
                    return redirect()->intended(route('docente.index'));
            }
        }

        return back()->with('error', 'El correo o la contraseña son incorrectos.');
    }

    public function logout(Request $request)
    {
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }
}