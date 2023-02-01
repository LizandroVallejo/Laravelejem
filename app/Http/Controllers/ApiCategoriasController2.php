<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias;
use App\Models\Productos;
use Illuminate\Support\Str; 


class ApiCategoriasController2 extends Controller
{
    //Autenticacion basica
    // public function __construct(){
    //     $this->middleware('auth.basic');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         #$this->middleware('auth.basic'); 
         $this->middleware('verificacion2');
     }
    public function index()
    {
        $datos = Categorias::orderBy('id','desc')->get();
        return response()->json($datos,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = json_decode(file_get_contents('php://input'), true);
        if(!is_array($json)){
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
     Categorias::create(
        [
            'nombre'=> $request->input("nombre"),
            'slug'=>Str::slug($request->input("nombre"))
        ]
        );
        $array=
        array
        (
            'response'=>array
            (
                'estado'=>'Ok',
                'mensaje'=>'Se creo el registro exitosamente ' 
            )
        )
    ;  	
return response()->json($array, 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    //Para mostrar datos
    {
        $datos = Categorias::where(['id'=>$id])->firstorFail();
        return response()->json($datos,200);

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    // Actualizar registr
    {
        $json = json_decode(file_get_contents('php://input'), true);
        if(!is_array($json)){
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
     $datos = Categorias::where(['id'=>$id])->firstorFail();
     $datos->nombre=$request->input("nombre");
     $datos->slug=Str::slug($request->input("nombre"));
     $datos->save();

     $array=
     array
     (
         'response'=>array
         (
             'estado'=>'Ok',
             'mensaje'=>'Se modifico el registro exitosamente ' 
         )
         );
     return response()->json($array, 200);
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $datos = Categorias::where(['id'=>$id])->firstorFail();
        $existe= Productos::where(['categorias_id'=>$id])->count();
        if($existe ==0){
           Categorias::where(['id'=>$id])->delete();

           $array=
           array
           (
               'response'=>array
               (
                   'estado'=>'Ok',
                   'mensaje'=>'Se elimino el registro correctamente ' 
               )
           );
       return response()->json($array, 200);
        }else{
            $array=
            array
            (
                'response'=>array
                (
                    'estado'=>'Bad Request',
                    'mensaje'=>'No se puede eliminar ' 
                )
            );
        return response()->json($array, 400);

        }
    }
}
