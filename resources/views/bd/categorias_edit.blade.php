@extends('../layouts.frontend')
@section('title','Formularios')
@section('content')
    
   <main class="container">
   <h1>Categorías</h1>
    
   <x-flash />
    <form action="{{route('bd_categorias_edit_post', ['id'=>$datos->id])}}" method="POST">
 {{ csrf_field() }}
     
      <div class="form-group">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $datos->nombre }}" />
      </div>
       
      <hr>
      <input type="submit" value="Enviar" class="btn btn-primary" />
    </form>
</main>

@endsection