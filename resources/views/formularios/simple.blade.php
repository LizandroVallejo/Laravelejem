@extends('../layouts.frontend')
@section('title','Formularios')
@section('content')
    
   <main class="container">
   <h1>Formularios simple</h1>
   <x-flash />
    <form action="{{route('formularios_simple_post')}}" method="POST">
 {{ csrf_field() }}
      <div class="form-group">
        <label for="pais">País: </label>
        <select name="pais" id="pais" class="form-control">
          <option value="0">Seleccione.....</option>
          @foreach ($paises as $pais)
              <option value="{{$pais['id']}}">{{$pais['nombre']}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" />
      </div>
      <div class="form-group">
        <label for="correo">E-Mail: </label>
        <input type="text" name="correo" id="correo" class="form-control" value="{{ old('correo') }}" />
      </div>
      <div class="form-group">
        <label for="nombre">Descripción: </label>
        <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
      </div>
      <div class="form-group">
        <label for="correo">Password: </label>
        <input type="password" name="password" id="password" class="form-control" />
      </div>
      <hr>
       <div class="form-group">
        <label for="intereses">Intereses: </label>
       <div class="form-check">
        @foreach ($intereses as $interes)
        <input class="form-check-input" type="checkbox" value="{{$interes['id']}}" id="interes_{{$loop->index}}" name="interes_{{$loop->index}}" />
        <label class="form-check-label" for="flexCheckDefault">
          {{$interes['nombre']}}
        </label>
        <br>
        @endforeach
       
      </div>
      </div>
      <hr>
      <input type="submit" value="Enviar" class="btn btn-primary" />
    </form>
</main>

@endsection