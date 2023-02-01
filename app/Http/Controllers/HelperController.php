<?php

namespace App\Http\Controllers;
use App\Helpers\Helpers;
use Illuminate\Http\Request;

class HelperController extends Controller
{
     public function helper_home()
    { 
        $texto = Helpers::getName("Juan Pérez");
        return view('helper.home', compact('texto'));
    }
}
