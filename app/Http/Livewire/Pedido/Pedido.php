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

        $this->view = 'asignarChofer';
    }

    public function asignar(){

        $chofer = Empleado::where('nombre_apellido','=', $this->chofer)->first();

        $transporteEntrega = Transporte::where([
            ['pedido_id', $this->pedido->id],
            ['ruta', Transporte::RUTA[0]]
        ])->first();

        if ($transporteEntrega !== null) {
            $transporteEntrega->update(['chofer' => $chofer->id]);
        } else {
            $transporteEntrega = Transporte::create([
                'chofer' => $chofer->id,
                'pedido_id' => $this->pedido->id,
                'ruta' => Transporte::RUTA[0]
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
        $pedidos = ModelsPedido::orderBy('id', 'desc')->paginate(8);
        
        return view('livewire.pedido.pedido', compact('pedidos'))
        ->extends('layouts.app')
        ->section('content');
    }
}
