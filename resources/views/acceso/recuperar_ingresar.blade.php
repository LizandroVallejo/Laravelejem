@extends('../layouts.frontend')
@section('title','Recuperar Contraseña')
@section('content')
    
   <main class="container">
   <h1>recuperar</h1>
    
   <x-flash />
    <form action="{{route('recuperar_ingresar_post')}}" method="POST">
 {{ csrf_field() }}
     
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