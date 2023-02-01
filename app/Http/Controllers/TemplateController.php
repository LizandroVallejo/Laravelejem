<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
 
class TemplateController extends Controller
{
    
    public function template_inicio()
    { 
        return view('template.home' );
    }
   
}