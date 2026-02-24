<?php

namespace App\Http\Controllers;

use WhichBrowser\Parser; // Agregamos biblioteca para navegadores
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

        // Agregamos el remember 16/02 (recordar sesión)
        $remember = $request->has('remember');

        // ---------------------------------------------------------
        // 1. BUSCAR EN TABLA ESTUDIANTE
        // ---------------------------------------------------------
        $estudiante = Estudiante::where('correo', $credentials['email'])->first();

        if ($estudiante && Hash::check($credentials['password'], $estudiante->contrasena)) {

            //Prueba para identificar el token
            $deviceName = $this->getDeviceName();

            //Prueba de Token con Sanctum
            $token = $estudiante->createToken($deviceName, ['estudiante'])->plainTextToken;

            //Prueba para limitar a 3 sesiones por usuario  
            if ($estudiante->tokens()->count() > 3) {
                $oldestToken = $estudiante->tokens()->orderBy('created_at', 'asc')->first();
                $oldestToken->delete();
            }


            Session::put('user_type', 'estudiante');
            Session::put('user_id', $estudiante->id_estudiante);

            // Concatenamos Nombre + Apellido
            $nombreCompleto = $estudiante->nombre . ' ' . $estudiante->paterno;
            Session::put('user_name', $nombreCompleto);

            //Prueba de cookie con token 
            $cookie = cookie(
                'auth_token',           // nombre
                $token,                 // valor
                120,                    // minutos (2 horas)
                '/',                    // path
                null,                   // dominio
                true,                   // secure (solo HTTPS)
                true,                   // httpOnly
                false,                  // raw
                'strict'                // same-site
            );

            // Linea con cookie
            return redirect()->intended(route('alumno.index'))->withCookie($cookie);

            // Linea anterior
            // return redirect()->intended(route('alumno.index'));
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

            //Prueba para identificar token
            $deviceName = $this->getDeviceName();

            // Prueba de token con Sanctum
            $token = $docente->createToken($deviceName, ['docente', $roleName])->plainTextToken;

            // Prueba ede limitar sesiones por usuario
            if ($docente->tokens()->count() > 3) {
                $oldestToken = $docente->tokens()->orderBy('created_at', 'asc')->first();
                $oldestToken->delete();
            }

            Session::put('user_type', 'docente'); // Se usa 'docente' porque está en la tabla docente
            Session::put('user_id', $docente->id_docente);

            $nombreCompleto = $docente->nombre . ' ' . $docente->paterno;
            Session::put('user_name', $nombreCompleto);
            Session::put('user_role', $roleName);

            // Prueba de cookie con token
            $cookie = cookie(
                'auth_token',
                $token,
                120,
                '/',
                null,
                true,
                true,
                false,
                'strict'
            );

            /* --- REDIRECCIÓN SEGÚN EL ROL --- SIN COOKIE 
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
            */ // -- BLOQUE DE ANTES


            // --- REDIRECCIÓN SEGÚN EL ROL --- CON COOKIE
            switch ($roleName) {

                case 'Jefe':
                    return redirect()->intended(route('jefe.index'))->withCookie($cookie);

                case 'Coordinador':
                    return redirect()->intended(route('coord.index'))->withCookie($cookie);

                case 'Soporte':
                    return redirect()->intended(route('soporte.index'))->withCookie($cookie);

                case 'Docente':
                default:
                    return redirect()->intended(route('docente.index'))->withCookie($cookie);
            }
        }

        return back()->with('error', 'El correo o la contraseña son incorrectos.');
    }

    public function logout(Request $request)
    {
        // Prueba de revocacion Sanctum 

        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        // Bloque anterior
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');

        // Eliminar cookie
        $cookie = cookie('auth_token', '', -1);

        return redirect()->route('login')
            ->with('success', 'Has cerrado sesión correctamente.')
            ->withCookie($cookie);
    }

    // Nombre del dispositivo para token
    private function getDeviceName()
    {
        $userAgent = request()->header('User-Agent', '');
        $ip = request()->ip();

        // Si no hay User-Agent, usar valor por defecto
        if (empty($userAgent)) {
            return "Dispositivo desconocido ({$ip})";
        }
        // Analizar el User-Agent con WhichBrowser
        $result = new Parser($userAgent);
        // Obtener navegador 
        $browser = $result->browser->toString() ?: 'Navegador desconocido';
        // Obtener SO
        $os = $result->os->toString() ?: 'SO desconocido';
        // dispositivo
        $deviceType = $result->device->type ?: 'desconocido';
        // nombre descriptivo
        return trim("{$os} - {$browser} - {$deviceType} ({$ip})");
    }
}
