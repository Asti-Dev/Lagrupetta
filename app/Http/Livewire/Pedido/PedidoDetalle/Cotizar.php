<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle;

use App\Models\PedidoDetalle;
use Livewire\Component;

class Cotizar extends Component
{

    public PedidoDetalle $pedidoDetalle;
    public $bicicleta;

    // protected $listeners = ['sendData'];

 
    public function mount(){
        // $this->partes = $this->pedidoDetalle->pedido->bicicleta->partes;
    }



    public function render()
    {
        $this->bicicleta = $this->pedidoDetalle->pedido->bicicleta;
        return view('livewire.pedido.pedido-detalle.cotizar')
        ->extends('layouts.app')
        ->section('content');
    }
}
