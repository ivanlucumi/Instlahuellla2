<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleProtectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Si no se pasaron roles, permitir el paso (o podrías decidir bloquear)
        if (empty($roles)) {
            return $next($request);
        }

        // Verificar si el usuario tiene alguno de los roles permitidos
        $hasRole = $user->roles()->whereIn('nombre', $roles)->exists();

        if (!$hasRole) {
            // Cierra la sesión si no tiene el rol permitido, como solicitó el usuario
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('swal', [
                'icon' => 'error',
                'title' => 'Acceso No Autorizado',
                'text' => 'Tu rol no permite el acceso a esta sección. La sesión ha sido cerrada por seguridad.'
            ]);
        }

        return $next($request);
    }
}
