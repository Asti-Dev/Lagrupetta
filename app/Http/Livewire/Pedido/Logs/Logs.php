<?php

namespace App\Http\Livewire\Pedido\Logs;

use App\Exports\PedidoLogExport;
use App\Models\PedidoLog;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;

class Logs extends Component
{
    public $nroPedido;
    public $estado;

    protected $paginationTheme = 'bootstrap';
    use WithPagination;

    public function export(){
        return Excel::download(new PedidoLogExport, 'historial.xlsx');
    }
    public function render()
    {
        $logs = PedidoLog::with('pedido')
        ->buscarPedido($this->nroPedido)
        ->filtrarEstadoPedido($this->estado)
        ->orderBy('id','desc')->paginate(10);

        return view('livewire.pedido.logs.logs',compact('logs'))
        ->extends('layouts.app')
        ->section('content');
    }
}
