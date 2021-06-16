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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pedido, $serial)
    {
        $this->pedido = $pedido;

        $this->serial = $serial;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.servicio-terminado')
        ->attachFromStorage('/pdf/Diagnostico #'. $this->serial . '.pdf', 
        'Diagnostico #'. $this->serial . '.pdf', [
            'mime' => 'application/pdf'
        ]);
    }
}
