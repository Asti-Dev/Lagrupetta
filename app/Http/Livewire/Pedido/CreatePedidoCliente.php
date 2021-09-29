<?php

namespace App\Http\Livewire\Pedido;

use App\Models\Cliente;
use Livewire\Component;

class CreatePedidoCliente extends Component
{
    public Cliente $cliente;

    public function render()
    {
        return view('livewire.pedido.create-pedido-cliente')
        ->extends('layouts.app')
        ->section('content');
    }
}
