@extends('../layouts.frontend')
@section('title','Error 404')
@section('content')
    
   <main class="container">
  <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
    <div class="col-md-6 px-0">
      <h1 class="display-4 fst-italic">Error 404 - Página no encontrada</h1>
     
    </div>
  </div>
 <img src="{{asset('images/yoda.png')}}" alt="">
</main>

@endsection