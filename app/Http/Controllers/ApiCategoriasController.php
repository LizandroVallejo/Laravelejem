<?php
 
namespace App\Http\Controllers;
use App\Models\Categorias;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

class ApiCategoriasController extends Controller
{
    public function __construct()
    {
        #$this->middleware('auth.basic'); 
        $this->middleware('verificacion');
    }
     
    //get listar
    public function index(Request $request)
    {
        $datos = Categorias::orderBy('id', 'desc')->get();
        return response()->json($datos, 200);
    }
     
    public function create()
    {
        
    }
    //post crear
    public function store(Request $request)
    {
       //recibir el json
       //echo file_get_contents('php://input');exit;
       $json = json_decode(file_get_contents('php://input') , true);
       //print_r($json);
       //validar que viene un json
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
       //crear el registro
        Categorias::create(
            [
                'nombre'=>$json['nombre'],
                'slug'=>Str::slug($json['nombre'], '-')
            ]
        );
       //retornar un json
       $array=array
                    (
                        'estado'=>'ok',
                        'mensaje'=>'Se creó el registro exitosamente', 
                    ); 
        return response()->json( $array, 201);
    }
    //get listar 1  http://localhost/tienda/api/v1/categorias/1
    public function show($id)
    {
        $datos=Categorias::where(['id'=>$id])->first();
        if(!is_object($datos))
        {
            $array=array
                (
                    'estado'=>'error',
                    'mensaje'=>'No existe el registro', 
                ); 
            return response()->json( $array, 404);
        }else
        {
            return response()->json( $datos, 200);
        }
    }
    public function edit($id)
    {
       
    }
    //put
    public function update(Request $request, $id)
    {
       $datos=Categorias::where(['id'=>$id])->first();
       if(!is_object($datos))
       {
            $array=array
                    (
                        'estado'=>'error',
                        'mensaje'=>'No existe el registro', 
                    ); 
        return response()->json( $array, 404);
       }else
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
        //ejecuto el update
        $datos->nombre=$json['nombre'];
        $datos->slug=Str::slug($json['nombre'], '-');
        $datos->save();
        //retorno un json
        $array=array
                    (
                        'estado'=>'ok',
                        'mensaje'=>'Se modificó el registro', 
                    ); 
        return response()->json( $array, 201);
       }
    }
    //delete
    public function destroy($id)
    {
        $datos=Categorias::where(['id'=>$id])->firstOrFail();
        $existe = Productos::where(['categorias_id'=>$id])->count();
        if($existe==0)
        {
            Categorias::where(['id'=>$id])->delete();
            $array=array
                        (
                            'estado'=>'ok',
                            'mensaje'=>'Se eliminó el registro', 
                        ); 
            return response()->json( $array, 201);
        }else
        { 
            $array=array
                        (
                            'estado'=>'Bad Request',
                            'mensaje'=>'No se puede eliminar el registro', 
                        ); 
            return response()->json( $array, 400);
        }
        
    }
}