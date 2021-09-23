<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle\Cotizacion;

use App\Models\Pedido;
use Livewire\Component;

class CotizacionEdit2 extends Component
{
    public $pedido;
    public $fechaEntrega;
    public $explicacion;
    public $precioTotal;

    protected function rules()
    {
        return [
            'fechaEntrega' => 'required',
            'explicacion' => 'required',
        ];
    }

    public function updated()
    {
        $this->validate();
    }

    public function mount(Pedido $pedido){
        $this->pedido = $pedido;
        $this->fechaEntrega =  date('Y-m-d',strtotime($pedido->pedidoDetalle->fecha_entrega_aprox));        
        $this->explicacion = $pedido->pedidoDetalle->explicacion;
        $this->precioTotal = $pedido->pedidoDetalle->precio_total;
    }

    public function render()
    {
        return view('livewire.pedido.pedido-detalle.cotizacion.cotizacion-edit2')
        ->extends('layouts.app')
        ->section('content');
    }
}
