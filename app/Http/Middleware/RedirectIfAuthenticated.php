<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            
            if($user->hasRol('SUPERADMIN') || $user->hasRol('ADMIN') || $user->hasRol('DIRECTOR')){
                return redirect()->route('home');
            }

            if($user->hasRol('ESTUDIANTE')){
                return redirect()->route('estudiante.dashboard');
            }

            if($user->hasRol('DOCENTE')){
                return redirect()->route('docente.dashboard');
            }

            return redirect()->route('home');
        }

        return $next($request);
    }
}
