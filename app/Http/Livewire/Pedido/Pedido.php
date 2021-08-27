<?php

namespace App\Http\Livewire\Pedido;

use App\Models\Empleado;
use App\Models\Pedido as ModelsPedido;
use App\Models\PedidoEstado;
use App\Models\Transporte;
use Livewire\Component;
use Livewire\WithPagination;

class Pedido extends Component
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
    public $nroPedido;
    public $direccion;
    public $nroOrden;
    public $orden = [
        '1' => [
            'TERMINO' => 'created_at',
            'SENTIDO' => 'desc'
        ],
        '2' => [
            'TERMINO' => 'created_at',
            'SENTIDO' => 'asc'
        ],
        '3' => [
            'TERMINO' => 'updated_at',
            'SENTIDO' => 'desc'
        ],
        '4' => [
            'TERMINO' => 'updated_at',
            'SENTIDO' => 'asc'
        ],
        '5' => [
            'TERMINO' => 'id',
            'SENTIDO' => 'desc'
        ],
        '6' => [
            'TERMINO' => 'id',
            'SENTIDO' => 'asc'
        ],
    ];



    public function create()
    {
        $this->view = 'create';
    }

    public function index()
    {
        $this->view = 'table';
    }

    public function asignarChofer($id)
    {
        $this->pedido = ModelsPedido::find($id);

        $this->direccion = $this->pedido->transporteRecojo->direccion;

        $this->view = 'asignarChofer';
    }

    public function asignar(){

        $chofer = Empleado::where('nombre_apellido','=', $this->chofer)->first();

        $transporteEntrega = Transporte::where([
            ['pedido_id', $this->pedido->id],
            ['ruta', Transporte::RUTA[0]],
        ])->first();

        if ($transporteEntrega !== null) {
            $transporteEntrega->update([
                'chofer' => $chofer->id,
                'direccion' => $this->direccion,
                'aceptar_chofer' => NULL,
                'fecha_hora_aceptar_chofer' => NULL
            ]);
        } else {
            $transporteEntrega = Transporte::create([
                'chofer' => $chofer->id,
                'pedido_id' => $this->pedido->id,
                'ruta' => Transporte::RUTA[0],
                'direccion' => $this->direccion
            ]);
        }

        
        $this->view = 'table';
    }

    public function pago($id)
    {
        $this->pedido = ModelsPedido::find($id);

        $this->pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre','PAGO PENDIENTE')->first()->id,
        ]);
    }
    public function completado($id)
    {
        $this->pedido = ModelsPedido::find($id);

        $this->pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre','COMPLETADO')->first()->id,
        ]);
    }

    public function destroy($id)
    {
        ModelsPedido::find($id)->delete();
    }

    public function restore($id)
    {
        ModelsPedido::withTrashed()->find($id)->restore();
    }

    public function updatedChofer()
    {
        if($this->chofer != ""){
        $this->chofers = Empleado::where([
            ['cargo','=','chofer'],
            ["nombre_apellido", "like","%" . trim($this->chofer) . "%"]
            ])->take(10)
            ->get();
        }else{
            $this->chofers = [];
        }

    }

    public function render()
    {
        $pedidos = ModelsPedido::with(['cliente', 'bicicleta', 'pedidoEstado','pedidoDetalle','revision', 'transportes','transporteEntrega','transporteRecojo'])->buscarPedido($this->nroPedido)
            ->buscarCliente($this->cliente)
            ->filtrarEstadoPedido($this->estado)
            ->orderBy($this->orden[$this->nroOrden]['TERMINO'] ?? 'id' , $this->orden[$this->nroOrden]['SENTIDO'] ?? 'desc')
            ->paginate(8);
        
        return view('livewire.pedido.pedido', compact('pedidos'))
        ->extends('layouts.app')
        ->section('content');
    }
}
