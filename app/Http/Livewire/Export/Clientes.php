<?php

namespace App\Http\Livewire\Export;

use App\Exports\ClientesExport;
use App\Models\Cliente;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class Clientes extends Component
{
    public Collection $clientes;
    public Collection $clientesIDs;
    public $fechaInicio;
    public $fechaFinal;

    protected $rules = [
        'fechaInicio' => 'required',
        'fechaFinal' => 'required',
    ];

    public function mount(){
        $this->clientesIDs = collect();
    }

    public function setFechas(){
        $this->validate();
        $this->fechaInicio = new Carbon($this->fechaInicio);
        $this->fechaFinal = new Carbon($this->fechaFinal);
        $this->clientesIDs = $this->clientes = Cliente::with(['cliente', 'bicicleta'])
        ->whereBetween('created_at',[$this->fechaInicio->format('Y-m-d')." 00:00:00"
        , $this->fechaFinal->format('Y-m-d')." 23:59:59"])->pluck('id');

        return Excel::download(new ClientesExport($this->clientesIDs), 'clientes '. $this->fechaInicio->format('Y-m-d') . '-' . $this->fechaFinal->format('Y-m-d') . '.xlsx');
    }
    public function render()
    {
        return view('livewire.export.clientes')
        ->extends('layouts.app')
        ->section('content');
    }
}
