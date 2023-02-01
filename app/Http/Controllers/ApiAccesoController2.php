<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMetadata;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class ApiAccesoController2 extends Controller
{

    public function store(Request $request)
    {
        $json = json_decode(file_get_contents('php://input'), true);
        if(!is_array($json)){
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
    $users = User::where(['email'=>$request->input('correo')])->first();
    if(!is_object($users)){
        $array=
        array
        (
            'response'=>array
            (
                'estado'=>'Bad Request',
                'mensaje'=>'La credenciales no son validas 1' 
            )
        );  	
        return response()->json($array, 400);
        

    }
    $users = User::where(['email'=>$request->input('correo')])->first();
    if(!is_object($users)){
        $array=
        array
        (
            'response'=>array
            (
                'estado'=>'Bad Request',
                'mensaje'=>'La credenciales no son validas 2' 
            )
        );  	
        return response()->json($array, 400);
        

    }
    $users_metadata = UserMetadata::where(['users_id'=>$users->id])->first();
    if(!is_object($users_metadata))
    {
        $array=array
            (
                'estado'=>'badrequest',
                'mensaje'=>'Los credenciales no son validas', 
            ); 
        return response()->json( $array, 404);
    }
    if(!Auth::attempt(['email' => $request->input('correo'), 'password' => $request->input('password')])){
        $array=
        array
        (
            'response'=>array
            (
                'estado'=>'Bad Request',
                'mensaje'=>'La credenciales no son validas 3' 
            )
        );  	
    return response()->json($array, 400);
    }
    $fecha = strtotime(date('Y-m-d H:i:s'));
    $payload = [
        'id' => $users_metadata->id,
        'iat' => $fecha

    ];
    $jwt = JWT::encode($payload, env('SECRETO'),'HS512');
    $array=array
    (
        'estado'=>'ok',
        'nombre'=>$users->name,
        'token' =>$jwt 
    );
    return response()->json( $array, 200);
    }
   
}