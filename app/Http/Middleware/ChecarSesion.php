<?php

namespace App\Http\Middleware;

use Closure;

class ChecarSesion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) { 
            return redirect()->route('logout');
        }
        

        return $next($request);
    }
}
