<?php

namespace App\Http\Controllers;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\ProductosFotos;
class BdController extends Controller
{
    public function bd_inicio()
    { 
      return view('bd.home' );
    }
    public function bd_categorias()
    { 
        $datos = Categorias::orderBy('id', 'desc')->get();
        return view('bd.categorias', compact('datos'));
    }
    
    public function bd_categorias_add()
    { 
      return view('bd.categorias_add' );
    }
    public function categorias_add_post(Request $request)
    {
        $request->validate(
            [
                'nombre' => 'required|min:6' 
            ],
            [
                'nombre.required'=>'El campo Nombre está vacío',
                'nombre.min'=>'El campo Nombre debe tener al menos 6 caracteres' 
            ]
        );
        Categorias::create(
            [
                'nombre'=>$request->input('nombre'),
                'slug'=>Helpers::slugify($request->input('nombre'))
            ]
        );
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se creó el registro exitosamente");
        return redirect()->route('bd_categorias_add');
    }
    public function bd_categorias_edit($id)
    {
        $datos = Categorias::where(['id'=>$id])->firstOrFail();
        return view('bd.categorias_edit', compact('datos'));
    }
    public function bd_categorias_edit_post(Request $request, $id)
    {
        $datos = Categorias::where(['id'=>$id])->firstOrFail();
        $datos->nombre = $request->input('nombre');
        $datos->slug=Helpers::slugify($request->input('nombre'));
        $datos->save();
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se editó el registro exitosamente");
        return redirect()->route('bd_categorias_edit', ['id'=>$id]);
    }
    public function bd_categorias_delete(Request $request, $id)
    {
        if(Productos::where(['categorias_id'=>$id])->count()==0)
        {
            Categorias::where(['id'=>$id])->delete();
            $request->session()->flash('css', 'success');
            $request->session()->flash('mensaje', "Se eliminó el registro exitosamente");
            return redirect()->route('bd_categorias');
        }else
        {
            $request->session()->flash('css', 'danger');
            $request->session()->flash('mensaje', "No es posible eliminar el registro");
            return redirect()->route('bd_categorias');
        }
    }

    public function bd_productos()
    {
        $datos = Productos::orderBy('id', 'desc')->get();
        return view('bd.productos', compact('datos'));
    }
    public function bd_productos_categoria($id)
    { 
        $categoria = Categorias::where(['id'=>$id])->firstOrFail();
        $datos = Productos::where(['categorias_id'=>$id])->orderBy('id', 'desc')->get();
        return view('bd.productos', compact('datos', 'categoria'));
    }
    public function bd_productos_add()
    {
        $categorias = Categorias::get();
        return view('bd.productos_add', compact('categorias'));
    }
    public function bd_productos_add_post(Request $request)
    {
        $request->validate(
            [
                'nombre' => 'required|min:6',
                'precio' => 'required|numeric',
                'descripcion' => 'required'  
            ],
            [
                'nombre.required'=>'El campo Nombre está vacío',
                'nombre.min'=>'El campo Nombre debe tener al menos 6 caracteres',
                'precio.required'=>'El campo Precio está vacío',
                'precio.numeric'=>'El Precio ingresado no es válido',
                'descripcion.required'=>'El campo Descripción está vacío', 
            ]
        );
        Productos::create(
            [
                'nombre'=>$request->input('nombre'),
                'slug'=>Helpers::slugify($request->input('nombre')),
                'precio'=>$request->input('precio'),
                'stock'=>$request->input('stock'),
                'descripcion'=>$request->input('descripcion'),
                'categorias_id'=>$request->input('categorias_id'),
                'fecha'=>date('Y-m-d')
            ]
        );
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se creó el registro exitosamente");
        return redirect()->route('bd_productos_add');
    }
    public function bd_productos_edit($id)
    {
        $datos = Productos::where(['id'=>$id])->firstOrFail();
        $categorias = Categorias::get();
        return view('bd.productos_edit', compact('datos', 'categorias'));
    }
    public function bd_productos_edit_post(Request $request, $id)
    {
        $datos = Productos::where(['id'=>$id])->firstOrFail();
        $request->validate(
            [
                'nombre' => 'required|min:6',
                'precio' => 'required|numeric',
                'descripcion' => 'required'  
            ],
            [
                'nombre.required'=>'El campo Nombre está vacío',
                'nombre.min'=>'El campo Nombre debe tener al menos 6 caracteres',
                'precio.required'=>'El campo Precio está vacío',
                'precio.numeric'=>'El Precio ingresado no es válido',
                'descripcion.required'=>'El campo Descripción está vacío', 
            ]
        );
        $datos->nombre=$request->input('nombre');
        $datos->slug=Helpers::slugify($request->input('nombre'));
        $datos->precio=$request->input('precio');
        $datos->stock=$request->input('stock');
        $datos->descripcion=$request->input('descripcion');
        $datos->categorias_id=$request->input('categorias_id');
        $datos->save();
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se editó el registro exitosamente");
        return redirect()->route('bd_productos_edit', ['id'=>$id]);
    }
    public function bd_productos_delete(Request $request, $id)
    {
        if(ProductosFotos::where(['productos_id'=>$id])->count()==0)
        {
            Productos::where(['id'=>$id])->delete();
            $request->session()->flash('css', 'success');
            $request->session()->flash('mensaje', "Se eliminó el registro exitosamente");
            return redirect()->route('bd_productos');
        }else
        {
            $request->session()->flash('css', 'danger');
            $request->session()->flash('mensaje', "No es posible eliminar el registro");
            return redirect()->route('bd_productos');
        }
    }
    public function bd_productos_fotos($id)
    {
        $producto = Productos::where(['id'=>$id])->firstOrFail();
        $fotos = ProductosFotos::where(['productos_id'=>$id])->orderBy('id', 'desc')->get();
        return view('bd.productos_fotos', compact('producto', 'fotos'));
    }
    public function bd_productos_fotos_post(Request $request, $id)
    {
        $producto = Productos::where(['id'=>$id])->firstOrFail();
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
        copy($_FILES['foto']['tmp_name'], 'uploads/productos/'.$fileName);
        ProductosFotos::create
        (
            [
                'productos_id'=>$id,
                'nombre'=>$fileName
            ]
        );
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se creó el registro exitosamente");
        return redirect()->route('bd_productos_fotos', ['id'=>$id]);
    }
    public function bd_productos_fotos_delete(Request $request, $producto_id, $foto_id)
    {
        $producto = Productos::where(['id'=>$producto_id])->firstOrFail();
        $foto = ProductosFotos::where(['id'=>$foto_id])->firstOrFail();
        unlink("/var/www/html/pruebas/ejemplo_1/public/uploads/productos/".$foto->nombre);
        ProductosFotos::where(['id'=>$foto_id])->delete();
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se eliminó el registro exitosamente");
        return redirect()->route('bd_productos_fotos', ['id'=>$producto_id]);
    }
    public function bd_productos_paginacion()
    {
        $datos = Productos::orderBy('id', 'desc')->paginate(1);
        return view('bd.productos_paginacion', compact('datos'));
    }
    public function bd_productos_buscador()
    { 
        if(isset($_GET['b']))
        {
            $b=$_GET['b'];
            $datos = Productos::where('nombre', 'like', '%'.$_GET['b'].'%')->orderBy('id', 'desc')->get();
        }else
        {
            $b="";
            $datos = Productos::orderBy('id', 'desc')->get();
        }
        
        return view('bd.productos_buscador', compact('datos', 'b'));
    }
}
