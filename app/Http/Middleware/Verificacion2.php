<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Verificacion2
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = explode(' ', $request->header('Authorization'));
        if(!isset( $headers[1]))
        {
            $array=
		        	array
		        	(
		        		'response'=>array
			        	(
			        		'estado'=>'Unauthorized',
			        		'mensaje'=>'Acceso no autorizado ' 
			        	)
		        	)
		        ;  	
		    return response()->json($array, 401);
        }
        //decodificar el token
        $decoded = JWT::decode($headers[1], new Key(env('SECRETO'), 'HS512'));
        //validar si es válido o no
        $fecha = strtotime(date('Y-m-d H:i:s'));
        //echo $decoded->iat." | ".$fecha;exit;
        
        if($decoded->iat > $fecha)
        {
            $array=
		        	array
		        	(
		        		'response'=>array
			        	(
			        		'estado'=>'Unauthorized',
			        		'mensaje'=>'Acceso no autorizado ' 
			        	)
		        	)
		        ;  	
		    return response()->json($array, 401);
        } 
        $decoded = JWT::decode($payload, env('SECRETO'),'HS512');
        return $next($request);
    }
}
