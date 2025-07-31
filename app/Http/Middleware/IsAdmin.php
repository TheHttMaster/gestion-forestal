<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Añade esta línea

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario está autenticado Y su rol es 'administrador', permite el acceso.
        if (Auth::check() && Auth::user()->role === 'administrador') {
            return $next($request);
        }

        // Si el usuario no es un administrador, le negamos el acceso.
        // Esto evita bucles de redirección.
        abort(403);
    }
}
