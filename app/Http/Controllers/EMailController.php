<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\EjemploMailable;
use Illuminate\Support\Facades\Mail;
class EMailController extends Controller
{
    public function email_inicio()
    { 
        return view('email.home' );
    }
    public function email_enviar(Request $request)
    { 
        
        $html='<h1>Hola este es un mail</h1>
            <hr/>
            <a href="">Link</a>
            .';
        $correo=new EjemploMailable($html );
        Mail::to("lizoef@gmail.com")->send($correo);
        
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se envió el mail exitosamente");
        return redirect()->route('email_inicio');
    }
}
