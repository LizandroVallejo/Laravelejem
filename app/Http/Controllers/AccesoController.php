<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserMetadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EjemploMailable;
use App\Helpers\Helpers;





class AccesoController extends Controller
{
    
    public function acceso_login()
    { 
        return view('acceso.login' );
    }
    public function acceso_login_post(Request $request)
    {
        $request->validate(
            [
                'correo' => 'required|email:rfc,dns',
                'password' => 'required|min:6' 
            ],
            [
                'correo.required'=>'El campo E-Mail está vacío',
                'correo.email'=>'El E-Mail ingresado no es válido',
                'password.required'=>'El campo Password está vacío',
                'password.min'=>'El campo Password debe tener al menos 6 caracteres'
                
            ]
        );
        if (Auth::attempt(['email' => $request->input('correo') , 'password' => $request->input('password') ])) 
        {
            $usuario = UserMetadata::where('users_id', Auth::id())->first();
            session(['users_metadata_id' => $usuario->id]);
            session(['perfil_id' => $usuario->perfil_id]);
            session(['perfil' => $usuario->perfil->nombre]);
            return redirect()->intended('/template');
        }else
        {
            $request->session()->flash('css', 'danger');
            $request->session()->flash('mensaje', "Las credenciales indicadas no son válidas");
            return redirect()->route('acceso_login');
        }
    }
    public function acceso_registro()
    {
        
        return view('acceso.registro' );
    }
    public function acceso_registro_post(Request $request)
    {
        $request->validate(
            [
                'nombre' => 'required|min:6',
                'correo' => 'required|email:rfc,dns|unique:users,email',
                'telefono' => 'required',
                'direccion' => 'required',
                'password' => 'required|min:6|confirmed' 
            ],
            [
                'nombre.required'=>'El campo Nombre está vacío',
                'nombre.min'=>'El campo Nombre debe tener al menos 6 caracteres',
                'correo.required'=>'El campo E-Mail está vacío',
                'correo.email'=>'El E-Mail ingresado no es válido',
                'telefono.required'=>'El campo Teléfono está vacío',
                'direccion.required'=>'El campo Dirección está vacío',
                'password.required'=>'El campo Password está vacío',
                'password.min'=>'El campo Password debe tener al menos 6 caracteres',
                'password.required'=>'El campo Password está vacío',
                'password.min'=>'El campo Password debe tener al menos 6 caracteres',
                'password.confirmed'=>'Las contraseñas ingresadas no coiciden',
            ]
        );
        $user=User::create
         (
            [
            'name' => $request->input('nombre'),
            'email' => $request->input('correo'),
            'password' => Hash::make($request->input('password')),
            'created_at' => date('Y-m-d H:i:s')
            ]
         );
        $userMetadata=UserMetadata::create
        (
            [
                'users_id'=>$user->id,
                'perfil_id'=>2,
                'telefono'=>$request->input('telefono'),
                'direccion'=>$request->input('direccion')
            ]
        );
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se ha creado el registro exitosamente");
        return redirect()->route('acceso_registro');
    }
    public function acceso_salir(Request $request)
    {
        Auth::logout();
        $request->session()->forget('perfil_id'); 
        $request->session()->forget('perfil');
        $request->session()->forget('users_metadata_id');
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', 'Cerraste la sesión exitosamente');
        return redirect()->route('acceso_login');
    }
    public function recuperar(Request $request){
        $token= bin2hex(random_bytes(10));
        $token = $token.date("YmdHis");
        $html="<h1>Hola este es un mail</h1>
        <hr/>
        <a href='http://127.0.0.1:8000/recuperar_ingresar?token=".$token."'>Link</a>
        .";
        
        $correo=new EjemploMailable($html);
        Mail::to("lizoef@gmail.com")->send($correo);
        $user = Auth::user();

        $datos=User::where(['id'=>$user->id])->first();
        $datos->remember_token=$token;
        $datos->save();
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se envió un mail de confirmacion a tu correo");
        return redirect()->route('template_inicio');
        
    }


    public function validarcorreo(){
        return view('acceso.validar');
    }
    public function validarcorreo_post(Request $request){
        $request->validate(
            [ 
                'correo' => 'required' 
            ],
            [
                'correo.required' => 'El correo es obligatorio'
            ]
            
            );
            $datos=User::where(['email'=>$request->input('correo')])->first();
            
            if($datos){
                $token= bin2hex(random_bytes(10));
                $token.date("YmdHis");
                
                $html="<h1>Hola este es un mail</h1>
                <hr/>
                <a href='http://127.0.0.1:8000/recuperar_ingresar?token=".$token."'>Link</a>.";
                $correo=new EjemploMailable($html);
                Mail::to($request->input('correo'))->send($correo);
                $datos=User::where(['email'=>$request->input('correo')])->first();
                $datos->remember_token=$token;
                $datos->save();
                $request->session()->flash('css', 'success');
                $request->session()->flash('mensaje', "Se envio una validacion a tu correo");
                return redirect()->route('template_inicio');

            }else{
                $request->session()->flash('css', 'danger');
                $request->session()->flash('mensaje', "Email no encontrado");
                return redirect()->route('template_inicio');
            }
    }
    public function recuperar_ingresar(Request $request ){
        $token =$request->token;
        $datos=User::where(['remember_token'=>$token])->first();
        if(!$datos){
            $request->session()->flash('css', 'danger');
            $request->session()->flash('mensaje', "Token no valido");
            return redirect()->route('template_inicio');
        }
        
        return view('acceso.recuperar_ingresar',compact('token'));
    }
    public function recuperar_ingresar_post(Request $request){
            $request->validate(
            [ 
                'password' => 'required|min:6|confirmed',
                
            ],
            [
                'password.min'=>'El campo Contraseña debe tener al menos 6 caracteres',
                'password.required'=>'El campo Contraseña es obligatorio',
                'password.confirmed'=>'Las contraseñas ingresadas no coiciden',
                
            ]
            
            );
            $datos=User::where(['remember_token'=>$request->input('token')])->first();
           

            if($datos){
                $datos->remember_token=null;
                $datos->password =Hash::make($request->input('password'));
                $datos->save();
                $request->session()->flash('css', 'success');
                $request->session()->flash('mensaje', "Se cambio la contraseña exitosamente");
                return redirect()->route('template_inicio');
            }

    }
}
