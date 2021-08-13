<?php

namespace App\Http\Livewire\Diagnostico;

use App\Models\PedidoDetalle;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Diagnostico extends Component
{
    public $pedidoDetalleId;
    public $pedidoDetalle;
    public $partes = [];
    public $partes2 = [];
    public $partesD1 = [];
    public $partesD2 = [];
    public $color;
    public $inventario;
    public $comentarioDiag;

    public function mount(){
        $this->pedidoDetalle = PedidoDetalle::find($this->pedidoDetalleId);
        $this->partes = $this->pedidoDetalle->pedido->bicicleta->partes;
        $data = json_decode($this->pedidoDetalle->diagnostico->data);
        $this->partesD1 = $data->partes;
        $this->partesD2 = $data->partes2;
        $this->color = $data->color;
        $this->inventario = $data->inventario;
        $this->comentarioDiag = $data->comentarioDiag;
        //utf8_decode

    }
    public function render()
    {
        return view('livewire.diagnostico.diagnostico')
        ->extends('layouts.app')
        ->section('content');
    }
}
