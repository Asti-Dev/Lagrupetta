<?php

namespace App\Http\Livewire\Transporte;

use App\Models\Pedido;
use App\Models\PedidoEstado;
use App\Models\Transporte as ModelsTransporte;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Transporte extends Component
{
    
    public $view = 'table';

    public ModelsTransporte $transporte;
    public $observacion;
    public Collection $transportes;
    public $estados = [
        'TERMINADO' => 'ENTREGADO',
        'SOLICITADO' => 'RECOGIDO',
    ];
    public $ruta;
    public $cliente;
    public $nroPedido;


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
        $estado = $this->transporte->pedido->pedidoEstado->nombre;
        $this->transporte->update([
            'observacion_chofer' => $this->observacion,
            'completado' => ModelsTransporte::CUMPLIMIENTO[0] ,
            'fecha_hora_completado' => now(),
        ]);

        $this->transporte->pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre',$this->estados[$estado])->first()->id,
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
        $transportes = ModelsTransporte::buscarCliente($this->cliente)
            ->buscarPedido($this->nroPedido)
            ->filtrarRuta($this->ruta)
            ->choferSession()
            ->whereHas('pedido', function($q){

                $q->where('confirmacion', '=', 'ACEPTADO');
    
            })->orderBy('id', 'desc')->get();

        $this->transportes = $transportes->whereIn('ruta', ['RECOJO','ENTREGA'])->
        whereNotIn('completado', ['COMPLETADO']);
        
        return view('livewire.transporte.transporte')
        ->extends('layouts.app')
        ->section('content');
    }
}
