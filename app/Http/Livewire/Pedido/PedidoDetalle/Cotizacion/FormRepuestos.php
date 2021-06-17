<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle\Cotizacion;

use Livewire\Component;

class FormRepuestos extends Component
{
    public $orderRepuestos = [];
    public $indexCount;
    public $pedido;

    public function mount()
    {

        $this->indexCount = 0;
        if ($this->pedido) {
            foreach ($this->pedido->pedidoDetalle->repuestos as $repuesto) {
                    $indexCount = $this->indexCount++;
                    $this->orderRepuestos[$indexCount] = [
                        'id' => $repuesto->id,
                        'nombre' => $repuesto->nombre,
                        'cantidad' => $repuesto->pivot->cantidad,
                        'precio_unitario' => $repuesto->precio,
                        "precio" => $repuesto->pivot->precio_total
                    ];
                
            }
        }
    }

    public function addRepuesto()
    {
        $this->indexCount++;
        $this->orderRepuestos[] = [
            'id' => '',
            'nombre' => '',
            'cantidad' => '',
            'precio_unitario' => '',
            "precio" => '',
        ];
    }

    public function removeRepuesto($index)
    {
        if ($this->indexCount > 1) {
            $this->indexCount--;
            unset($this->orderRepuestos[$index]);
        } else {
            $this->indexCount--;
            $this->orderRepuestos = [];
        }
    }
    public function render()
    {
        return view('livewire.pedido.pedido-detalle.cotizacion.form-repuestos');
    }
}
