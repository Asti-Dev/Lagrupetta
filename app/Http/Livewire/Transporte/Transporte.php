<?php

namespace App\Http\Livewire\Transporte;

use App\Models\Pedido;
use App\Models\PedidoEstado;
use App\Models\Transporte as ModelsTransporte;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Transporte extends Component
{
    
    public $view = 'table';

    public ModelsTransporte $transporte;
    public $observacion;
    public $transportes = [];


    public function rules()
    {
        return [
            'completado' => Rule::in(ModelsTransporte::CUMPLIMIENTO),
        ];
    }

    /** Mostrar los pedido que tengan una instancia en transporte y poder separarlos en recojo y entrega
     * poder ingresar a la instancia y poner observaciones marcar como completado o fallido
     * los estados del pedido seran 
     *  */ 

    public function edit($id)
    {
        $this->transporte = ModelsTransporte::find($id);
        $this->observacion = $this->transporte->observacion_chofer;
     
        $this->view = 'completar';
    }

    public function completado()
    {
        
        $this->transporte->update([
            'observacion_chofer' => $this->observacion,
            'completado' => ModelsTransporte::CUMPLIMIENTO[0] ,
            'fecha_hora_completado' => now(),
        ]);

        $this->transporte->pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre','RECOGIDO')->first()->id,
        ]);

        $this->view = 'table';
    }

    public function fallido()
    {
        $this->transporte->update([
            'observacion_chofer' => $this->observacion,
            'completado' => ModelsTransporte::CUMPLIMIENTO[1] ,
            'fecha_hora_completado' => now(),
        ]);

        $this->view = 'table';
    }


    public function render()
    {
        $this->transportes = ModelsTransporte::where([
                ['ruta', '=', 'RECOJO'] ,
                ['completado','=', null ]
            ])->orWhere([
                ['ruta', '=', 'RECOJO'] ,
                ['completado','!=', 'COMPLETADO' ]
            ])->
            orWhere([
                ['ruta', '=', 'ENTREGA'] ,
                ['completado','=', null ]
            ])->orWhere([
                ['ruta', '=', 'ENTREGA'] ,
                ['completado','!=', 'COMPLETADO' ]
            ])->orderBy('id', 'desc')->get();
        // $this->transportes = ModelsTransporte::whereHas('pedido.pedidoEstado', function($q){

        //     $q->where('nombre', '=', 'SOLICITADO')
        //     ->orWhere('nombre', '=', 'RECOGIDO')
        //     ->orWhere('nombre', '=', 'TERMINADO')
        //     ->orWhere('nombre', '=', 'ENTREGADO');

        // })->orderBy('id', 'desc')->get();
        
        return view('livewire.transporte.transporte')
        ->extends('layouts.app')
        ->section('content');
    }
}
