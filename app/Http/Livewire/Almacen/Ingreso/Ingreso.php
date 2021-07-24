<?php

namespace App\Http\Livewire\Almacen\Ingreso;

use App\Models\Pedido;
use Livewire\Component;
use Livewire\WithPagination;

class Ingreso extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    
    public $view = 'table';
    public Pedido $pedido;
    public $cliente;
    public $nroPedido;

    public function enTaller($id)
    {
        $this->pedido = Pedido::find($id);
     
        $this->view = 'asignar';
    }

    public function index(){
     
        $this->view = 'table';
    }


    public function render()
    {
        $data['pedidos'] = Pedido::whereHas('pedidoEstado', function($q){

            $q->where('nombre', '=', 'RECOGIDO');
        
        })->buscarPedido($this->nroPedido)
        ->buscarCliente($this->cliente)
        ->orderBy('id', 'desc')->paginate(3);

        return view('livewire.almacen.ingreso.ingreso', $data);
    }
}
