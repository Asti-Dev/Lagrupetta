<?php

namespace App\Http\Livewire\Export;

use App\Exports\PedidosExport;
use App\Models\Pedido;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Pedidos extends Component
{
    public Collection $pedidos;
    public Collection $pedidosIDs;
    public $fechaInicio;
    public $fechaFinal;

    protected $rules = [
        'fechaInicio' => 'required',
        'fechaFinal' => 'required',
    ];

    public function mount(){
        $this->pedidosIDs = collect();
    }

    public function setFechas(){
        $this->validate();
        $this->fechaInicio = new Carbon($this->fechaInicio);
        $this->fechaFinal = new Carbon($this->fechaFinal);
        $this->pedidosIDs = $this->pedidos = Pedido::with(['cliente', 'bicicleta', 'pedidoEstado','pedidoDetalle','revision', 'transportes'])
        ->whereBetween('created_at',[$this->fechaInicio->format('Y-m-d')." 00:00:00"
        , $this->fechaFinal->format('Y-m-d')." 23:59:59"])->pluck('id');

        return Excel::download(new PedidosExport($this->pedidosIDs), 'pedidos '. $this->fechaInicio->format('Y-m-d') . '-' . $this->fechaFinal->format('Y-m-d') . '.xlsx');
    }

    public function render()
    {
        
        return view('livewire.export.pedidos')
        ->extends('layouts.app')
        ->section('content');
    }
}
