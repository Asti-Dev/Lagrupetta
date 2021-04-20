<?php

namespace App\Http\Livewire\Diagnostico;

use App\Http\Livewire\Pedido\Form;
use App\Models\PedidoDetalle;
use Livewire\Component;

class Diagnostico extends Component
{
    public $pedidoDetalleId;
    public $pedidoDetalle;
    public $partes = [];

    public function mount(){
        $this->pedidoDetalle = PedidoDetalle::find($this->pedidoDetalleId);
        $this->partes = $this->pedidoDetalle->pedido->bicicleta->partes;

    }
    public function render()
    {
        return view('livewire.diagnostico.diagnostico')
        ->extends('layouts.app')
        ->section('content');
    }
}
