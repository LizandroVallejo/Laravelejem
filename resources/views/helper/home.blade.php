@extends('../layouts.frontend')
@section('title','Helper')
@section('content')
    
   <main class="container">
  <h1>Helper</h1>
  <h2>{{Helpers::getVersion()}}</h2>
  <h3>{{$texto}}</h3>
  <h3>{{Helpers::getName("César Cancino")}}</h3>
</main>

@endsection