<?php

namespace App\Http\Livewire\Almacen;

use App\Models\Pedido;
use App\Models\PedidoEstado;
use Livewire\Component;
use Livewire\WithPagination;

class Almacen extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    
    public $view = 'table';
    public Pedido $pedido;
    public $cliente;
    public $nroPedido;


    function enAlmacen($id){
        $this->pedido = Pedido::find($id);

        if (isset($this->pedido->revision)) {
            $estado = PedidoEstado::where('nombre', '=', 'EN ALMACEN TERMINADO')->first();

            $this->pedido->update([
                'pedido_estado_id' => $estado->id,
            ]);
        } else {
            $estado = PedidoEstado::where('nombre', '=', 'EN ALMACEN')->first();

            $this->pedido->update([
                'pedido_estado_id' => $estado->id,
            ]);
        
            $this->pedido->transporteRecojo->update([
                'fecha_hora_local' => now(),
            ]);
        }

        
    }

    function enAlmacenTerminado($id){
        $this->pedido = Pedido::find($id);

        $estado = PedidoEstado::where('nombre', '=', 'EN ALMACEN TERMINADO')->first();

        $this->pedido->update([
            'pedido_estado_id' => $estado->id,
        ]);
    }

    function enTaller($id){
        $this->pedido = Pedido::find($id);

        $estado = PedidoEstado::where('nombre', '=', 'EN TALLER')->first();

        $this->pedido->update([
            'pedido_estado_id' => $estado->id,
        ]);
    }

    function retirar($id){
        $this->pedido = Pedido::find($id);

        $estado = PedidoEstado::where('nombre', '=', 'EN RUTA ENTREGA')->first();

        $this->pedido->update([
            'pedido_estado_id' => $estado->id,
        ]);
    }

    public function render()
    {
        $data['pedidos'] = Pedido::whereHas('pedidoEstado', function($q){

            $q->where('nombre', '=', 'DEPOSITADO')
            ->orWhere('nombre', '=', 'EN ALMACEN')
            ->orWhere('nombre', '=', 'DEPOSITADO MECANICO')
            ->orWhere('nombre', '=', 'EN ALMACEN TERMINADO');
        
        })->buscarPedido($this->nroPedido)
        ->buscarCliente($this->cliente)
        ->orderBy('id', 'desc')->paginate(8);

        return view('livewire.almacen.almacen', $data)
        ->extends('layouts.app')
        ->section('content');
    }
}
