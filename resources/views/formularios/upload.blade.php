@extends('../layouts.frontend')
@section('title','Formularios')
@section('content')
    
   <main class="container">
   <h1>Formularios Upload</h1>
   <x-flash />
    <form action="{{route('formularios_upload_post')}}" method="POST" enctype="multipart/form-data">
 {{ csrf_field() }}
      
      <div class="form-group">
        <label for="nombre">Archivo: </label>
        <input type="file" name="foto" id="foto" class="form-control"  />
      </div>
       
      <hr>
      <input type="submit" value="Enviar" class="btn btn-primary" />
    </form>
</main>

@endsection