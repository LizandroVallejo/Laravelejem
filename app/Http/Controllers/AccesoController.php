<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserMetadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
}
