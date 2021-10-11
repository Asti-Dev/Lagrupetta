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
    public $estadosTrabajar = [
        'COTIZADO',
        'EN ESPERA',
        'EN PROCESO',
    ];
    public $estadosEditar = [
        'COTIZADO',
        'EN ESPERA',
        'EN PROCESO',
        'EN CALIDAD',
        'CORREGIR',
        'TERMINADO',
    ];


    public function render()
    {
        $this->mecanicos = Empleado::where('cargo','=','mecanico')->orWhere('cargo','=','jefe mecanicos')->get();

        $data['pedidoDetalles'] = PedidoDetalle::mecanicoSession()->whereHas('pedido.pedidoEstado', function($q){

            $q->where('nombre', '=', 'EN TALLER')
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
