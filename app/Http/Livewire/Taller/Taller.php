<?php

namespace App\Http\Livewire\Taller;

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\PedidoEstado;
use Livewire\Component;

class Taller extends Component
{
    public $view = 'table';
    public $estado;
    public $nroPedido;
    public $cliente;
    public $nroOrden;
    public $orden = [
        '1' => [
            'TERMINO' => 'fecha_entrega_aprox',
            'SENTIDO' => 'desc'
        ],
    ];

    public function depositar($id)
    {
        $pedido = Pedido::find($id);

        $estado = PedidoEstado::where('nombre', '=', 'DEPOSITADO MECANICO')->first();

        $pedido->update([
            'pedido_estado_id' => $estado->id,
        ]);
    }

    public function render()
    {
        $data['pedidoDetalles'] = PedidoDetalle::mecanicoSession()->whereHas('pedido.pedidoEstado', function($q){

            $q->where('nombre', '=', 'EN TALLER')
            ->orWhere('nombre', '=', 'EN RUTA RECOJO')
            ->orWhere('nombre', '=', 'DEPOSITADO')
            ->orWhere('nombre', '=', 'EN ALMACEN')
            ->orWhere('nombre', '=', 'COTIZADO')
            ->orWhere('nombre', '=', 'EN PROCESO')
            ->orWhere('nombre', '=', 'EN ESPERA')
            ->orWhere('nombre', '=', 'REVISAR')
            ->orWhere('nombre', '=', 'CORREGIR')
            ->orWhere('nombre', '=', 'TERMINADO');

        })->buscarPedido($this->nroPedido)
        ->buscarCliente($this->cliente)
        ->filtrarEstadoPedido($this->estado)
        ->orderBy($this->orden[$this->nroOrden]['TERMINO'] ?? 'id' , $this->orden[$this->nroOrden]['SENTIDO'] ?? 'desc')
        ->get();

        return view('livewire.taller.taller',$data)
        ->extends('layouts.app')
        ->section('content');
    }
}
