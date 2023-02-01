@extends('../layouts.frontend')
@section('title','Home - extra')
@section('content')
    
   <main class="container">
 <h1>E-Mail</h1>
  <x-flash />
 <a href="{{route('email_enviar')}}">Enviar</a>
 
</main>

@endsection