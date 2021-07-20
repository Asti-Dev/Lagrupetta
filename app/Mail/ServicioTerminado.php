<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServicioTerminado extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;
    public $serial;
    public $nombre;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pedido, $serial, $nombre)
    {
        $this->pedido = $pedido;

        $this->serial = $serial;

        $this->nombre = $nombre;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.servicio-terminado')
        ->attachFromStorage('/pdf/'. $this->nombre . $this->serial . '.pdf', 
        $this->nombre . $this->serial . '.pdf', [
            'mime' => 'application/pdf'
        ]);
    }
}
