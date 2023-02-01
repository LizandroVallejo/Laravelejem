@extends('../layouts.frontend')
@section('title','Paypal')
@section('content')
    
   <main class="container">
 <h1>Paypal</h1>
  <x-flash />
   <div class="alert alert-warning">
    Se canceló la orden {{$id}}
   </div>

</main>

@endsection