<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdministradorMiddleware
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();

        // 🔐 Validar cambio de contraseña primero
        if ($user->cambiopassword != 1) {
            return redirect()->to('/cambiarPassword/nueva/contrasena');
        }

        if (\Auth::check()) {
            if ($this->auth->user()->rol == '1') {
                // return $next($request);
                if ($this->auth->user()->cambiopassword == 1) {
                    return $next($request);
                } else {
                    // dd('entro2');
                    return redirect()->to('/cambiarPassword/nueva/contrasena');
                }
            }

        }

        Session::flash('message-error', 'Sin privilegios de administrador');

        return redirect()->route('logout');
    }
}
