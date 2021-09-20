<?php

namespace App\Http\Livewire\Taller;

use App\Models\Empleado;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\PedidoEstado;
use Livewire\Component;

class Taller extends Component
{
    public $view = 'table';
    public $estado;
    public $cliente;
    public $fechaIni;
    public $fechaFin;
    public $mecanicos;
    public $mecanico;

    function enTaller($id){
        $pedido = Pedido::find($id);

        $estado = PedidoEstado::where('nombre', '=', 'EN TALLER')->first();

        $pedido->update([
            'pedido_estado_id' => $estado->id,
        ]);
    }

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
        $this->mecanicos = Empleado::where('cargo','=','mecanico')->orWhere('cargo','=','jefe mecanicos')->get();

        $data['pedidoDetalles'] = PedidoDetalle::mecanicoSession()->whereHas('pedido.pedidoEstado', function($q){

            $q->where('nombre', '=', 'EN TALLER')
            ->orWhere('nombre', '=', 'EN RUTA RECOJO')
            ->orWhere('nombre', '=', 'DEPOSITADO')
            ->orWhere('nombre', '=', 'EN ALMACEN')
            ->orWhere('nombre', '=', 'COTIZADO')
            ->orWhere('nombre', '=', 'EN PROCESO')
            ->orWhere('nombre', '=', 'EN ESPERA')
            ->orWhere('nombre', '=', 'EN CALIDAD')
            ->orWhere('nombre', '=', 'CORREGIR')
            ->orWhere('nombre', '=', 'TERMINADO');

        })->filtrarFecha($this->fechaIni, $this->fechaFin)
        ->buscarCliente($this->cliente)
        ->filtrarEstadoPedido($this->estado)
        ->filtrarMecanico($this->mecanico)
        ->orderBy('id' ,  'desc')
        ->get();

        return view('livewire.taller.taller',$data)
        ->extends('layouts.app')
        ->section('content');
    }
}
