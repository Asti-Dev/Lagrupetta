<?php

namespace App\Http\Livewire\Cobranza;

use App\Models\Pedido;
use App\Models\PedidoEstado;
use Livewire\Component;
use Livewire\WithPagination;

class Cobranza extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    
    public $view = 'table';
    public $solicitudView = 'create';
    public $chofer;
    public $chofers =[];
    public $pedido;
    public $estado;
    public $cliente;
    public $direccion;
    public $fechaIni;
    public $fechaFin;
    public $nroPedido;


    public function pago($id)
    {
        $this->pedido = Pedido::find($id);

        $this->pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre','PAGO PENDIENTE')->first()->id,
        ]);
    }
    public function completado($id)
    {
        $this->pedido = Pedido::find($id);

        $this->pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre','FACTURADO')->first()->id,
        ]);
    }

    public function render()
    {
        $pedidos = Pedido::with(['cliente', 'bicicleta', 'pedidoEstado','pedidoDetalle','revision', 'transportes','transporteEntrega','transporteRecojo'])
            ->whereHas('pedido.pedidoEstado', function($q){

                $q->where('nombre', '=', 'TERMINADO')
                ->orWhere('nombre', '=', 'EN RUTA ENTREGA')
                ->orWhere('nombre', '=', 'EN ALMACEN TERMINADO')
                ->orWhere('nombre', '=', 'PAGO PENDIENTE');

            })->buscarCliente($this->cliente)
            ->filtrarFecha($this->fechaIni, $this->fechaFin)
            ->filtrarEstadoPedido($this->estado)
            ->orderBy('id','desc')
            ->paginate(9);
        return view('livewire.cobranza.cobranza', compact('pedidos'))
        ->extends('layouts.app')
        ->section('content');
    }
}
