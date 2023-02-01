@extends('../layouts.frontend')
@section('title','BD')
@section('content')
    
   <main class="container">
 <h1>Fotos Producto ({{$producto->nombre}})</h1>
  <x-flash />
  <form name="form" action="{{route('bd_productos_fotos_post', ['id'=>$producto->id])}}" method="POST"
    enctype="multipart/form-data">
    <div class="row">
        <div class="form-group izquierda">
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control" />
        </div>

    </div>
    <hr /> 
    {{ csrf_field() }}
    <input type="submit" value="Enviar" class="btn btn-primary" />
</form>
<hr />
<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fotos as $foto)
                
            
                <tr>
                    <td>
                        <img src="{{asset('uploads/productos')}}/{{$foto->nombre}}" alt="MI proyecto" width="200" height="200" />
                    </td>
                    <td style="text-align: center;">
                    <a href="javascript:void(0);"
                        onclick="confirmaAlert('Realmente desea eliminar este registro?', '{{route('bd_productos_fotos_delete', ['producto_id'=>$producto->id, 'foto_id'=>$foto->id])}}');">
                        <i class="fas fa-trash"></i>
                    </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


</main>

@endsection