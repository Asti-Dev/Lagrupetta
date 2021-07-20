<?php

namespace App\Http\Livewire\Taller;

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Livewire\Component;

class Taller extends Component
{
    public $view = 'table';

    public function diagnostico(){
        //create diagnostico
        //update pedidoDetalle
    }

    public function render()
    {
        $data['pedidoDetalles'] = PedidoDetalle::mecanicoSession()->whereHas('pedido.pedidoEstado', function($q){

            $q->where('nombre', '=', 'EN TALLER')
            ->orWhere('nombre', '=', 'COTIZADO')
            ->orWhere('nombre', '=', 'EN PROCESO')
            ->orWhere('nombre', '=', 'EN ESPERA')
            ->orWhere('nombre', '=', 'REVISAR')
            ->orWhere('nombre', '=', 'CORREGIR')
            ->orWhere('nombre', '=', 'TERMINADO');

        })->orderBy('id', 'desc')->paginate(6);

        return view('livewire.taller.taller',$data)
        ->extends('layouts.app')
        ->section('content');
    }
}
