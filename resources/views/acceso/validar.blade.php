@extends('../layouts.frontend')
@section('title','Recuperar Contraseña')
@section('content')
    
   <main class="container">
   <h1>recuperar</h1>
    
   <x-flash />
    <form action="{{route('validarcorreo_post')}}" method="POST">
 {{ csrf_field() }}
    <div class="form-group">
        <label for="correo">Ingresa tu correo: </label>
        <input type="email" name="correo" id="correo" class="form-control"  />
    </div>
     
       
        <hr>
      <input type="submit" value="Enviar" class="btn btn-primary" />
    </form>
</main>

@endsection