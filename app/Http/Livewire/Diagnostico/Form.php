<?php

namespace App\Http\Livewire\Diagnostico;

use App\Models\Parte;
use App\Models\PedidoDetalle;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;


class Form extends Component
{
    public $pedidoDetalleId;
    public $pedidoDetalle;
    public $partes = [];
    public $partes2 = [];
    public $porcentajes = [];
    public $color;


    public function mount(){
        $this->pedidoDetalle = PedidoDetalle::find($this->pedidoDetalleId);
        $this->partes = Parte::where('bicicleta_id', $this->pedidoDetalle->pedido->bicicleta->id)->whereHas('parteModelo', function (Builder $query) {
            $query->where('tag', false);
        })->get();
        $this->partes2 = Parte::where('bicicleta_id', $this->pedidoDetalle->pedido->bicicleta->id)->whereHas('parteModelo', function (Builder $query) {
            $query->where('tag', true);
        })->get();
        $this->color = $this->pedidoDetalle->pedido->bicicleta->color;
    }

    
    // protected function rules()
    // {
    //     $array = [];
    //     foreach ($this->partes as $key => $parte) {
    //         $array['porcentajes.' . $key] ='required';
    //     }
    //     return $array;
    // }

    // public function updated()
    // {
    //     $this->validate();
    // }


    public function render()
    {
        return view('livewire.diagnostico.form');
    }
}
