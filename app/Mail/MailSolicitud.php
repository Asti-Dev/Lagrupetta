<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSolicitud extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;
    public $url = [];
    public $hoy;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pedido, $url)
    {
        $this->pedido = $pedido;

        $this->url = $url;

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($pedido->fecha_recojo_aprox);
        $mes = $meses[($fecha->format('n')) - 1];

        $this->hoy = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.solicitud')->subject('Solicitud');
    }
}
