<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle\Cotizacion;

use Livewire\Component;

class Cotizacion extends Component
{
    public $pedido;
    public $explicacion;
    public $fecha;

    protected function rules()
    {
        return [
            'fecha' => 'required',
            'explicacion' => 'required',
        ];
    }

    public function updated()
    {
        $this->validate();
    }

    public function render()
    {
        return view('livewire.pedido.pedido-detalle.cotizacion.cotizacion');
    }
}
