<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\OrdenesPaypal;
class PaypalController extends Controller
{
    public function paypal_inicio()
    {
        $monto=10;
        //Pedir token
        $responseToken=Http::withBasicAuth(env('PAYPAL_CLIENT_ID'),env('PAYPAL_CLIENT_SECRET'))->asForm()->post(env('PAYPAL_BASE_URI')."/v1/oauth2/token",
    [
        'grant_type' => 'client_credentials'
    ]);

       


    $token=  $responseToken->json()['access_token'] ;
    $orden=OrdenesPaypal::create(
            [
                'token'=>$token,
                'orden'=>'' ,
                'nombre'=>'',
                'correo'=>'',
                'id_captura'=>'',
                'monto'=>$monto,
                'country_code'=>'',
                'estado'=>0,//0 iniciada 1 pagada 2 cancelada
                'fecha'=>date('Y-m-d H:i:s'),
                'paypal_request'=>''
             ]);

             
        $response = Http::withHeaders(
            [
            'Authorization' => "Bearer ".$token,
            'PayPal-Request-Id'=>"order_".$orden->id
            ]
         )->post(env('PAYPAL_BASE_URI')."/v2/checkout/orders",
         [
             'intent' => 'CAPTURE',
                 'purchase_units' => [
                     0 => [
                         "reference_id"=> "reference_".$orden->id,
                         'amount' => [
                             'currency_code' => 'MXN',
                             'value' => $monto,
                         ]
                     ]
                 ],
                 'payment_source' => [
                     'paypal'=>[
                         'experience_context'=>[
                             "payment_method_preference"=>"IMMEDIATE_PAYMENT_REQUIRED",
                             "payment_method_selected"=> "PAYPAL",
                             "brand_name"=> "LIZANDRO",
                             "locale"=> "es-ES",
                             "landing_page"=> "LOGIN",
                             "shipping_preference"=> "SET_PROVIDED_ADDRESS",
                             "user_action"=> "PAY_NOW",
                             "return_url"=> "http://127.0.0.1:8000/paypal/respuesta",
                             "cancel_url"=> "http://127.0.0.1:8000/paypal/cancelado"
                         ]
                        
                     ]
                    
                 ]
         ]);
        
         if($response->status()!=200)
         {
             die("error ".$response->status());
         }
         $ordenBd=OrdenesPaypal::find($orden->id);
         $ordenBd->orden=$response->json()['id'];
         $ordenBd->save();
         return view('paypal.home', compact('orden', 'response'));
    }
    public function paypal_respuesta()
    {
        $id= $_GET['token'];
        $orden=OrdenesPaypal::where(['orden'=>$id ])->firstOrFail();
        $headers = [
            "Content-Type"  => "application/json",
        ];
        //Bearer arewrh9weh98
        $response = Http::withToken($orden->token)
                    ->withHeaders($headers)
                    ->send("POST", env('PAYPAL_BASE_URI')."/v2/checkout/orders/".$orden->orden."/capture");
        if(isset($response->json()['id']))
        {
            $orden->nombre=$response->json()['payment_source']['paypal']['name']['given_name']." ".$response->json()['payment_source']['paypal']['name']['surname'];
            $orden->correo=$response->json()['payment_source']['paypal']['email_address'];
            $orden->id_captura=$response->json()['purchase_units'][0]['payments']['captures'][0]['id'];
            $orden->country_code=$response->json()['payment_source']['paypal']['address']['country_code'];
            $orden->estado=1;
            
            $orden->save();
            $estado="ok";
        }else
        {
            $estado="error";
        }
        return view('paypal.respuesta',compact('estado','id'));
    }
    public function paypal_cancelado(Request $request)
    {
        $id=$request->input('token');
        $orden=OrdenesPaypal::where(['orden'=>$id])->firstOrFail();
        $orden->estado=2;
        $orden->save();
        return view('paypal.cancelado', compact(  'id'));
    }
}
