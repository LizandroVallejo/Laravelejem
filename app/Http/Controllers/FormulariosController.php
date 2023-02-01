<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\ValidaSelect;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class FormulariosController extends Controller
{
    
    public function formularios_inicio()
    { 
        return view('formularios.home' );
    }
    public function formularios_simple()
    { 
        $paises=array(
            array(
                "nombre"=>"Chile", "id"=>1
            ),
            array(
                "nombre"=>"Perú", "id"=>2
            ),
            array(
                "nombre"=>"Venezuela", "id"=>3
            ),
            array(
                "nombre"=>"México", "id"=>4
            ),
            array(
                "nombre"=>"España", "id"=>5
            )
        );
        $intereses=array(
            array(
                "nombre"=>"Deportes", "id"=>1
            ),
            array(
                "nombre"=>"Música", "id"=>2
            ),
            array(
                "nombre"=>"Religión", "id"=>3
            ),
            array(
                "nombre"=>"Comida", "id"=>4
            ),
            array(
                "nombre"=>"Viajes", "id"=>5
            )
        );
        return view('formularios.simple', compact('paises', 'intereses'));
    }
    public function formularios_simple_post(Request $request)
    { 
         $request->validate(
            [
                'nombre' => 'required|min:6',
                'correo' => 'required|email:rfc,dns',
                'descripcion' => 'required',
                'password' => 'required|min:6',
                'pais'=>[  new ValidaSelect]
            ],
            [
                'nombre.required'=>'El campo Nombre está vacío',
                'nombre.min'=>'El campo Nombre debe tener al menos 6 caracteres',
                'correo.required'=>'El campo E-Mail está vacío',
                'correo.email'=>'El E-Mail ingresado no es válido',
                'descripcion.required'=>'El campo Descripción está vacío',
                'password.required'=>'El campo Password está vacío',
                'password.min'=>'El campo Password debe tener al menos 6 caracteres',
            ]
        );
        $intereses=array(
            array(
                "nombre"=>"Deportes", "id"=>1
            ),
            array(
                "nombre"=>"Música", "id"=>2
            ),
            array(
                "nombre"=>"Religión", "id"=>3
            ),
            array(
                "nombre"=>"Comida", "id"=>4
            ),
            array(
                "nombre"=>"Viajes", "id"=>5
            )
        );
        foreach($intereses as $key=>$interes)
        {
            if(isset($_POST['interes_'.$key]))
            {
                echo $_POST['interes_'.$key]."<br/>";
            }
        }
        //echo $request->input("nombre");
    }
    public function formularios_flash()
    { 
        return view('formularios.flash' );
    }
    public function formularios_flash3(Request $request)
    { 
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Mensaje dese flash con ñandú");
        return redirect()->route('formularios_flash2');
    }
    public function formularios_flash2()
    { 
        return view('formularios.flash2' );
    }
    public function formularios_upload()
    { 
        return view('formularios.upload' );
    }
    public function formularios_upload_post(Request $request)
    {  

        $request->validate(
            [
                'foto' => 'required|mimes:jpg,bmp,png|max:2048' 
            ],
            [
                'foto.required'=>'El campo foto está vacío',
                'foto.mimes'=>'El campo foto debe set JPG|PNG'
            ]
        );
        
        switch($_FILES['foto']['type'])
        {
            case 'image/png':
                $extension=".png";
            break;
            case 'image/jpeg':
                $extension=".jpg";
            break;
        }
        $fileName = time().$extension;
        copy($_FILES['foto']['tmp_name'], 'uploads/udemy/'.$fileName);
 
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se subió el archivo exitosamente");
        return redirect()->route('formularios_upload');
 
    }
}