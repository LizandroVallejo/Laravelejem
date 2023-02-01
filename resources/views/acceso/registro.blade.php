@extends('../layouts.frontend')
@section('title','Registro')
@section('content')
    
   <main class="container">
   <h1>Registro</h1>
    
   <x-flash />
    <form action="{{route('acceso_registro_post')}}" method="POST">
 {{ csrf_field() }}
     
      <div class="form-group">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" />
      </div>
      <div class="form-group">
        <label for="correo">E-Mail: </label>
        <input type="text" name="correo" id="correo" class="form-control" value="{{ old('correo') }}" />
      </div>
      <div class="form-group">
        <label for="telefono">Teléfono: </label>
        <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}" />
      </div>
      <div class="form-group">
        <label for="direccion">Dirección: </label>
        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}" />
      </div>
      <div class="form-group">
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" class="form-control"  />
      </div>
      <div class="form-group">
        <label for="password2">Repetir Contraseña: </label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"  />
      </div>
      <hr>
      <input type="submit" value="Enviar" class="btn btn-primary" />
    </form>
</main>

@endsection