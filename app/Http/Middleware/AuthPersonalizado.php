<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthPersonalizado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        // 1. Verificamos si existe la variable 'user_id' que creas en tu AuthController
        // Si NO existe, significa que no ha pasado por el login correctamente.
        if (!Session::has('user_id')) {
            
            // 2. Lo redirigimos al login con un mensaje de error
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        // 3. Opcional: Evitar caché (Back button browser history issue)
        // Esto ayuda a que si el usuario hace logout, no pueda volver atrás con el botón del navegador
        $response = $next($request);
        
        return $response->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
}