<?php
 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserMetadata; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiLoginController extends Controller
{
    public function store(Request $request)
    {
        $json = json_decode(file_get_contents('php://input'), true);
        if(!is_array($json ))
        {
       		$array=
		        	array
		        	(
		        		'response'=>array
			        	(
			        		'estado'=>'Bad Request',
			        		'mensaje'=>'La peticion HTTP no trae datos para procesar ' 
			        	)
		        	)
		        ;  	
		    return response()->json($array, 400);
        }
        $users = User::where(['email'=>$request->input('correo') ])->first();
        if(!is_object($users))
        {
            $array=array
                    (
                        'estado'=>'error',
                        'mensaje'=>'Error desconocido', 
                    ); 
            return response()->json( $array, 404);
        }
        $users_metadata=UserMetadata::where(['users_id'=>$users->id ])->first();
        if(!is_object($users_metadata))
        {
            $array=array
                    (
                        'estado'=>'error',
                        'mensaje'=>'Error desconocido', 
                    ); 
            return response()->json( $array, 404);
        } 
        if(!Auth::attempt(['email' => $request->input('correo'), 'password' => $request->input('password')]))
        {
            $array=array
                    (
                        'estado'=>'error',
                        'mensaje'=>'Error desconocido', 
                    ); 
            return response()->json( $array, 404);
        }
        $fecha = strtotime(date('Y-m-d H:i:s'));
        $payload = [
            'id'=>$users_metadata->id,
            'iat'=>$fecha
        ];
        $jwt =JWT::encode($payload, env('SECRETO'), 'HS256');
        $array=array
                    (
                        'estado'=>'ok',
                        'nombre'=>$users->name, 
                        'token'=>$jwt
                    ); 
        return response()->json( $array, 200);
    }
}