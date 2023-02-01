<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
 
class HomeController extends Controller
{
    
    public function home_inicio()
    {
        $texto="hola";
        $numero =12;
        $paises=array(
            array(
                "nombre"=>"Chile", "dominio"=>"cl"
            ),
            array(
                "nombre"=>"Perú", "dominio"=>"pe"
            ),
            array(
                "nombre"=>"Venezuela", "dominio"=>"ve"
            ),
            array(
                "nombre"=>"México", "dominio"=>"mx"
            ),
            array(
                "nombre"=>"España", "dominio"=>"es"
            )
        );
        return view('home.home', compact('texto', 'numero', 'paises'));
    }
   
}