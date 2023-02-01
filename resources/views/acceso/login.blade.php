@extends('../layouts.frontend')
@section('title','Registro')
@section('content')
    
   <main class="container">
   <h1>Login</h1>
    
   <x-flash />
    <form action="{{route('acceso_login_post')}}" method="POST">
 {{ csrf_field() }}
     
       <div class="form-group">
        <label for="correo">E-Mail: </label>
        <input type="text" name="correo" id="correo" class="form-control" value="{{ old('correo') }}" />
      </div>
       <div class="form-group">
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" class="form-control"  />
      </div>
       
      <hr>
      <input type="submit" value="Enviar" class="btn btn-primary" />
    </form>
</main>

@endsection