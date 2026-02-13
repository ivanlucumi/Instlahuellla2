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
            if(Auth::user()->rol == 1){
                return redirect('administrador/');
            }

            if(Auth::user()->rol == 2){
                return redirect('tecnicos/');
            }

            if(Auth::user()->rol == 3){
                return redirect('usuarios/');
            }

            if(Auth::user()->rol == 4){
                return redirect('reservas/');
            }  

            if(Auth::user()->rol == 5){
                return redirect('monitoreo/');
            } 
            
            if(Auth::user()->rol == 6){
                return redirect('parqueadero/');
            } 
            
            if(Auth::user()->rol == 7){
                return redirect('inpec/');
            }  
            
            if(Auth::user()->rol == 8){
                return redirect('porteria/ingreso');
            } 
            
            if(Auth::user()->rol == 9){
                return redirect('porteria/salida');
            }
            
            if(Auth::user()->rol == '10'){
            
                return redirect('coordinador/ingresos');   
             }
             
             if(Auth::user()->rol == '11'){
            
                return redirect('revision/proceso/digitalizacion');   
             }
             
             if(Auth::user()->rol == '12'){
            
                return redirect('servisoft/');   
             }
               if(Auth::user()->rol == '13'){
            
                return redirect('mantenimiento/reporte/incidentes');   
             }
             if(Auth::user()->rol == '14'){
            
                return redirect('reporte/incidentes/operario/');   
             }
             if(Auth::user()->rol == '17'){
            
                return redirect('tecnico/soporte');   
             }
             if(Auth::user()->rol == '21'){
            
                return redirect('/administracion/reserva/salas');   
             }
             if(Auth::user()->rol == '23'){
            
                return redirect('/administracion/solicitud/fichas');   
             }
              




        }

        return $next($request);
    }
}
