<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMetadata;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class ApiAccesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = json_decode(file_get_contents('php://input') , true);
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
        $users = User::where(['email'=>$request->input('correo')])->first();
        if(!is_object($users))
        {
            $array=array
                (
                    'estado'=>'badrequest',
                    'mensaje'=>'Los credenciales no son validas', 
                ); 
            return response()->json( $array, 404);
        }
        $users_metadata = UserMetadata::where(['email'=>$request->input('correo')])->first();
        if(!is_object($users_metadata))
        {
            $array=array
                (
                    'estado'=>'badrequest',
                    'mensaje'=>'Los credenciales no son validas', 
                ); 
            return response()->json( $array, 404);
        }
        if(!Auth::attempt(['email' => $request->input('correo'), 'password' => $request->input('password')]))
        {
            $array=array
            (
                'estado'=>'badrequest',
                'mensaje'=>'Los datos no son validas', 
            ); 
        return response()->json( $array, 404);
        }
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
        return response()->json( $array, 200    );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
