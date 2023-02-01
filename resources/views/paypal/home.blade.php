@extends('../layouts.frontend')
@section('title','Paypal')
@section('content')
    
   <main class="container">
 <h1>Paypal</h1>
  <x-flash />
  <ul>
    <li><strong>Producto</strong>: Mesa de computador</li>
    <li><strong>Valor</strong>: USD100</li>
    <li><strong>Cantidad</strong>: 1</li>
    <li><strong>Orden de compra</strong>: {{"order_".$orden->id}}</li>
</ul>
<a class="btn btn-warning" href="{{$response->json()['links'][1]['href']}}"><i class="fab fa-paypal"></i> Pagar</a>
</main>

<div id="smart-button-container">
  <div style="text-align: center;">
    <div id="paypal-button-container"></div>
  </div>
</div>

@endsection


<script src="https://www.paypal.com/sdk/js?client-id=Afgab8oko8HtSeysfkaOh-g3L-K8760-JlHTEQN1uv4Yk6Nfwzhv451wNoOztQFjFpc3xye7RsscHxs-&enable-funding=venmo&currency=MXN" data-sdk-integration-source="button-factory"></script>
<script>
function initPayPalButton() {
  paypal.Buttons({
    style: {
      shape: 'rect',
      color: 'gold',
      layout: 'vertical',
      label: 'paypal',
      
    },

    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{"description":"Pago laravel","amount":{"currency_code":"MXN","value":100}}]
      });
    },

    onApprove: function(data, actions) {
      return actions.order.capture().then(function(orderData) {
        
        // Full available details
        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

        // Show a success message within this page, e.g.
        const element = document.getElementById('paypal-button-container');
        element.innerHTML = '';
        element.innerHTML = '<h3>Thank you for your payment!</h3>';

        // Or go to another URL:  actions.redirect('thank_you.html');
        
      });
    },

    onError: function(err) {
      console.log(err);
    }
  }).render('#paypal-button-container');
}
initPayPalButton();
</script>