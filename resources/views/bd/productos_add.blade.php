@extends('../layouts.frontend')
@section('title','Formularios')
@section('content')
    
   <main class="container">
   <h1>Productos</h1>
    
   <x-flash />
    <form action="{{route('bd_productos_add_post')}}" method="POST">
 {{ csrf_field() }}
     <div class="form-group">
        <label for="categoria">Categoría: </label>
        <select class="form-control" name="categorias_id" id="categorias_id">
          @foreach ($categorias as $categoria)
              <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
          @endforeach  
        </select>
      </div>
      <div class="form-group">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" />
      </div>
       <div class="form-group">
        <label for="precio">Precio: </label>
        <input type="text" name="precio" id="precio" class="form-control" value="{{ old('precio') }}" onkeypress="return soloNumeros(event)" />
      </div>
      <div class="form-group">
        <label for="stock">Stock: </label>
        <select class="form-control" name="stock" id="stock">
          @for ($i=1 ; $i<=100 ; $i++)
              <option value="{{$i}}">{{$i}}</option>
          @endfor
        </select>
      </div>
      <div class="form-group">
        <label for="descripcion">Descripción: </label>
        <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
      </div>
      <hr>
      <input type="submit" value="Enviar" class="btn btn-primary" />
    </form>
</main>

@endsection