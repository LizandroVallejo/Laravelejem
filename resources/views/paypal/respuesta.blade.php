@extends('../layouts.frontend')
@section('title','Paypal')
@section('content')
    
   <main class="container">
 <h1>Paypal</h1>
  <x-flash />
  @if ($estado=='ok')
      <div class="alert alert-success">
    Tu pago se gestionó exitosamente con el número de transacción <strong>{{$id}}</strong>
</div>

  @endif
  @if ($estado=='error')
      <div   class="alert alert-danger">La transacción <strong>{{$id}}</strong> ya está caducada</div>

  @endif

</main>

@endsection