<?php

namespace App\Http\Livewire\Pedido;

use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;
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
    public $direccion;
    public $fechaIni;
    public $fechaFin;
    public $nroPedido;
    public $distritos = Cliente::DISTRITOS;
    public $distrito;



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

        $this->distrito = $this->pedido->transporteRecojo->distrito;

        $this->chofers = Empleado::where([['cargo','=','chofer']])->get();

        $this->view = 'asignarChofer';
    }

    public function asignar(){
        
        $this->validate([
            'chofer' => 'required',
            'distrito' => 'required',
            'direccion' => 'required',
        ]);

        $chofer = Empleado::where('nombre_apellido','=', $this->chofer)->first();

        $transporteEntrega = $this->pedido->transporteEntrega;

        if ($transporteEntrega !== null) {
            $transporteEntrega->update([
                'chofer' => $chofer->id,
                'distrito' => $this->distrito,
                'direccion' => $this->direccion,
            ]);
        } else {
            Transporte::create([
                'chofer' => $chofer->id,
                'pedido_id' => $this->pedido->id,
                'ruta' => Transporte::RUTA[0],
                'distrito' => $this->distrito,
                'direccion' => $this->direccion,
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
            'pedido_estado_id' => PedidoEstado::where('nombre','FACTURADO')->first()->id,
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

    public function render()
    {
        $pedidos = ModelsPedido::with(['cliente', 'bicicleta', 'pedidoEstado','pedidoDetalle','revision', 'transportes','transporteEntrega','transporteRecojo'])
            ->buscarCliente($this->cliente)
            ->filtrarFecha($this->fechaIni, $this->fechaFin)
            ->filtrarEstadoPedido($this->estado)
            ->buscarPedido($this->nroPedido)
            ->orderBy('id','desc')
            ->paginate(9);
        
        return view('livewire.pedido.pedido', compact('pedidos'))
        ->extends('layouts.app')
        ->section('content');
    }
}
