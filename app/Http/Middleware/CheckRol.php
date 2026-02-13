<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Session;

class CheckRol
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Usuario no autenticado
        if (!auth()->check()) {
            abort(403);
        }

        // Si no se pasan roles, deja continuar
        if (empty($roles)) {
            return $next($request);
        }

        // Validar roles
        if (!auth()->user()
            ->roles()
            ->whereIn('nombre', $roles)
            ->exists()) {
            abort(403);
        }
    }
}
