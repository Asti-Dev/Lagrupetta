<?php

namespace App\Http\Livewire\Pedido\Solicitud;

use App\Models\Pedido;
use Livewire\Component;

class Solicitud extends Component
{
    public Pedido $pedido;

    public function render()
    {
        return view('livewire.pedido.solicitud.solicitud')
        ->extends('layouts.app')
        ->section('content');
    }
}
