<?php

namespace App\Http\Livewire\Cobranza;

use App\Events\ProcesarNotificacion;
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

        event(new ProcesarNotificacion($this->pedido));
    }
    public function completado($id)
    {
        $this->pedido = Pedido::find($id);

        $this->pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre','FACTURADO')->first()->id,
        ]);

        event(new ProcesarNotificacion($this->pedido));
    }

    public function render()
    {
        $pedidos = Pedido::with(['cliente', 'bicicleta', 'pedidoEstado','pedidoDetalle','revision', 'transportes','transporteEntrega','transporteRecojo'])
            ->whereHas('pedidoEstado', function($q){

                $q->where('nombre', '=', 'TERMINADO')
                ->orWhere('nombre', '=', 'EN RUTA ENTREGA')
                ->orWhere('nombre', '=', 'PAGO PENDIENTE');

            })->buscarCliente($this->cliente)
            ->filtrarFecha($this->fechaIni, $this->fechaFin)
            ->filtrarEstadoPedido($this->estado)
            ->buscarPedido($this->nroPedido)
            ->orderBy('id','desc')
            ->paginate(9);

        return view('livewire.cobranza.cobranza', compact('pedidos'))
        ->extends('layouts.app')
        ->section('content');
    }
}
