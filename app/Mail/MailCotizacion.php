<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailCotizacion extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;
    public $servicios = [];
    public $paquetes = [];
    public $url = [];
    public $serial;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pedido, $url, $serial)
    {
        $this->pedido = $pedido;

        $this->url = $url;

        $this->serial = $serial;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.cotizacion')->subject('Cotizacion')
        ->attachFromStorage('/pdf/Diagnostico #'. $this->serial . '.pdf', 
        'Diagnostico #'. $this->serial . '.pdf', [
            'mime' => 'application/pdf'
        ]);
    }
}
