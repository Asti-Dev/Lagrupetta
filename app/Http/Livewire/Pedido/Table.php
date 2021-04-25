<?php

namespace App\Http\Livewire\Pedido;

use App\Models\Pedido;
use App\Models\PedidoEstado;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    
    public function pago($id)
    {
        $this->pedido = Pedido::find($id);

        $this->pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre','PAGO PENDIENTE')->first()->id,
        ]);
    }
    public function completado($id)
    {
        $this->pedido = Pedido::find($id);

        $this->pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre','COMPLETADO')->first()->id,
        ]);
    }

    public function destroy($id)
    {
        Pedido::find($id)->delete();
    }

    public function render()
    {
        $pedidos = Pedido::orderBy('id', 'desc')->paginate(8);

        return view('livewire.pedido.table', compact('pedidos'));
    }
}
