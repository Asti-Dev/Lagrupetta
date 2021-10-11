<?php

namespace App\Events;

use App\Models\Pedido;
use App\Models\PedidoLog;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProcesarNotificacion
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Pedido $pedido;
    public $subEstado;
    public PedidoLog $pedidoLog;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($pedido, $eliminado = false, $subEstado = '')
    {
        $this->subEstado = $subEstado;
        $this->pedido = $pedido;
        $this->pedidoLog = $this->pedido->logs()->create([
            'pedido_estado_id' => $this->pedido->pedido_estado_id,
            'sub_estado' => $subEstado,
            'eliminado' => $eliminado,
        ]);
    }


}
