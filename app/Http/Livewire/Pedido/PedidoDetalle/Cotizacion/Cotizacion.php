<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle\Cotizacion;

use Livewire\Component;

class Cotizacion extends Component
{
    public $pedido;

    public function render()
    {
        return view('livewire.pedido.pedido-detalle.cotizacion.cotizacion');
    }
}
