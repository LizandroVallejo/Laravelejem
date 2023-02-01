@extends('../layouts.frontend')
@section('title','Formularios')
@section('content')
    
   <main class="container">
   <h1>Formularios</h1>
    

    <ul>
      <li>
        <a href="{{route('formularios_simple')}}">Simple</a>
      </li>
      <li>
        <a href="{{route('formularios_flash')}}">Flash</a>
      </li> 
       <li>
        <a href="{{route('formularios_upload')}}">Upload</a>
      </li>
    </ul>
</main>

@endsection