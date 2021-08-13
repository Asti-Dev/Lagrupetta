<?php

namespace App\Http\Livewire\Diagnostico;

use App\Models\Parte;
use App\Models\PedidoDetalle;
use Livewire\Component;


class Form extends Component
{
    public $pedidoDetalleId;
    public $pedidoDetalle;
    public $partes = [];
    public $test = [];
    // public $partesRenderizado = [];

    // public $comentarioMecanico;

    // protected $listeners = ['requestData'];

    protected function rules()
    {
        return [
            'test.*' => 'required',
        ];
    }

    protected $rules = [
        // 'partes.*.porcentaje' => 'required',
        // 'partes.*.comentario' => 'required',
        // 'partes.*.detalle' => 'required',
        // 'comentarioMecanico' => 'required'
    ];

    // public function requestData(){
    //     $data = [];
    //     $data['partes'] = $this->partes;
    //     $data['comentarioMecanico'] = $this->comentarioMecanico;
    //     $this->emitUp('sendData', $data);
    // }

    public function mount(){
        $this->pedidoDetalle = PedidoDetalle::find($this->pedidoDetalleId);
        // $this->partesRenderizado =$this->pedidoDetalle->pedido->bicicleta->partes;
        $this->partes = $this->pedidoDetalle->pedido->bicicleta->partes;

        // $this->validate();

    }

    public function render()
    {
        return view('livewire.diagnostico.form');
    }
}
