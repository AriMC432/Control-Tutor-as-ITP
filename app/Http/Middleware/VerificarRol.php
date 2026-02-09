<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles  Lista de roles permitidos separados por coma
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Obtenemos los datos de la sesión actual
        $miTipo = Session::get('user_type'); // Ej: 'estudiante', 'docente'
        $miRol  = Session::get('user_role'); // Ej: 'Jefe', 'Coordinador'

        // 2. Recorremos los roles requeridos por la ruta
        foreach ($roles as $rolPermitido) {
            
            // Verificamos si coincide el tipo (ej. 'estudiante') o el rol (ej. 'Jefe')
            if ($miTipo === $rolPermitido || $miRol === $rolPermitido) {
                return $next($request);
            }
        }

        // 3. CORRECCIÓN: Si no tiene permiso, lo mandamos al LOGIN con el mensaje de error.
        // Antes te mandaba al inicio ('/'), ahora te manda al login para que veas la alerta roja.
        return redirect()->route('login')
            ->with('error', 'Acceso denegado: Debe iniciar sesión primero.');
    }
}