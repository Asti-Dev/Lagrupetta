<?php

namespace App\Http\Livewire\Export;

use App\Models\Pedido;
use Illuminate\Support\Collection;
use Livewire\Component;

class Pedidos extends Component
{
    public Collection $pedidos;
    public Collection $pedidosIDs;
    public $fechaInicio;
    public $fechaFinal;

    protected $rules = [
        'fechaInicio' => 'required',
        'fechaFinal' => 'required',
    ];

    public function mount(){
        $this->pedidos = Pedido::with(['cliente', 'bicicleta', 'pedidoEstado','pedidoDetalle','revision', 'transportes'])->get();
        $this->pedidosIDs = collect();
    }

    public function setFechas(){

    }

    public function render()
    {
        
        return view('livewire.export.pedidos')
        ->extends('layouts.app')
        ->section('content');
    }
}
