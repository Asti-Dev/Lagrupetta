<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle\Cotizacion;

use Livewire\Component;

class FormPaquetes extends Component
{
    public $orderPaquetes = [];
    public $indexCount;
    public $pedido;

    public function mount()
    {
        $this->indexCount = 0;
        if ($this->pedido) {
            foreach ($this->pedido->pedidodetalle->paquetes->unique() as $paquete) {
                $indexCount = $this->indexCount++;
                $this->orderPaquetes[$indexCount] = [
                    'id' => $paquete->id,
                    'nombre' => $paquete->nombre,
                    'descripcion' => $paquete->descripcion,
                    "cantidad" => $paquete->pivot->cantidad,
                    "precio_unitario" => $paquete->precio,
                    "precio" => $paquete->pivot->precio_total,
                ];
            }
        }
    }

    public function addPaquete()
    {
            $this->indexCount++;
            $this->orderPaquetes[] = [
                'id' => "",
                'nombre' => '',
                'descripcion' => "",
                'cantidad' => "",
                'precio_unitario' => "",
                "precio" => "",
            ];

    }

    public function removePaquete($index)
    {
        if ($this->indexCount > 1) {
            $this->indexCount--;
            unset($this->orderPaquetes[$index]);
        } else {
            $this->indexCount--;
            $this->orderPaquetes=[];
        }
    }
   

    public function render()
    {
        return view('livewire.pedido.pedido-detalle.cotizacion.form-paquetes');
    }
}
