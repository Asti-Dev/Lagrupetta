<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle\Cotizacion;

use Livewire\Component;

class FormServicios extends Component
{
    public $orderServicios = [];
    public $indexCount;
    public $pedido;

    public function mount()
    {
        $this->indexCount = 0;
        if ($this->pedido) {
            foreach ($this->pedido->servicios as $servicio) {
                $indexCount = $this->indexCount++;
                $this->orderServicios[$indexCount] = [
                    'id' => $servicio->id,
                    'nombre' => $servicio->nombre,
                    "precio" => $servicio->precio
                ];
            }
        }
    }

    public function addServicio()
    {
        $this->indexCount++;
        $this->orderServicios[] = [
            'id' => '',
            'nombre' => '',
            'cantidad' => '',
            'precio_unitario' => '',
            "precio" => '',
        ];
    }

    public function removeServicio($index)
    {
        if ($this->indexCount > 1) {
            $this->indexCount--;
            unset($this->orderServicios[$index]);
        } else {
            $this->indexCount--;
            $this->orderServicios = [];
        }
    }
    public function render()
    {
        return view('livewire.pedido.pedido-detalle.cotizacion.form-servicios');
    }
}
