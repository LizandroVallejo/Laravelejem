<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;

use App\Models\Productos;
use App\Models\ProductosFotos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 
use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class ApiProductosController extends Controller
{
    public function __construct()
    {
        #$this->middleware('auth.basic'); 
        $this->middleware('verificacion');
    }
    public function index(Request $request)
    {
        $datos=Productos::orderBy('id', 'desc')->get();
        return response()->json( $datos);
    }
    public function create()
    {
        
    }
    /*
    {
	"nombre": "Tazón de tomar té",
    "descripcion": "ssss",
    "precio": 22222,
    "stock": 12,
    "categorias_id": 1
}
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
        
        Productos::create(
            [
                'nombre'=>$request->input('nombre'),
                'slug'=>Str::slug($request->input('nombre'), '-'),
                'descripcion'=>$request->input('descripcion'), 
                'precio'=>$request->input('precio'), 
                'stock'=>$request->input('stock'),
                'categorias_id'=>$request->input('categorias_id'),
                'fecha'=>date('Y-m-d')
            ]
            );
        $array=array
                    (
                        'estado'=>'ok',
                        'mensaje'=>'Se creó el registro exitosamente', 
                    ); 
        return response()->json( $array, 201);
    }
    public function show($id)
    {
        $datos=Productos::where(['id'=>$id])->first();
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
       $datos=Productos::where(['id'=>$id])->first();
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
        $datos->precio=$json['precio'];
        $datos->descripcion=$json['descripcion'];
        $datos->categorias_id=$json['categorias_id'];
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
        $datos=Productos::where(['id'=>$id])->firstOrFail();
        $existe = ProductosFotos::where(['productos_id'=>$id])->count();
        if($existe==0)
        {
            Productos::where(['id'=>$id])->delete();
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