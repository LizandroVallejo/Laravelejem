<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EjemploMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $subject="Tienda virtual";
    public $texto="";
    public $adjunto="vacio";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $texto, $adjunto="vacio")
    {
        $this->texto=$texto;
        $this->adjunto=$adjunto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         if($this->adjunto=="vacio")
         {
            return $this->view('emails.ejemplo');
         }else
         {
            return $this->view('emails.ejemplo')->attach($this->adjunto);
         }
    }
}
