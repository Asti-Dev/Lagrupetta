<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle\Cotizacion;

use App\Models\Paquete;
use Livewire\Component;

class DetallePaquetes extends Component
{
    public $index;
    public $count;
    public $orderPaquete;
    public $paquete =[];
    public $listaPaquetes =[];


    public function mount($orderPaquete, $index)
    {
        $this->count = $index;
        $this->paquete = [
            'id' => $orderPaquete['id'],
            'nombre' => $orderPaquete['nombre'],
            'descripcion' => $orderPaquete['descripcion'],
            'cantidad' => $orderPaquete['cantidad'],
            'precio_unitario' => $orderPaquete['precio_unitario'],
            'precio' => $orderPaquete['precio'],
        ];
    }

    public function encontrarPaquete()
    {

        $paquete = Paquete::where("nombre", "=", trim($this->paquete['nombre']))
            ->first();
        if ($paquete) {
            $this->paquete = [
                'id' => $paquete->id,
                'nombre' => $paquete->nombre,
                'descripcion' => $paquete->descripcion,
                'cantidad' => 1,
                'precio_unitario' => $paquete->precio,
                'precio' => $paquete->precio,
            ];
        } else{
            $this->paquete = [
                'id' => '',
                'nombre' => $this->paquete['nombre'],
                'descripcion' => '',
                'cantidad' => 1,
                'precio_unitario' => '',
                'precio' => '',
            ];
        };
    }

    public function totalPaquete()
    {
        $check = $this->paquete['cantidad'];
        $check2 = $this->paquete['precio_unitario'];

        if (is_numeric($check) && is_numeric($check2)) {
            $this->paquete = [
                'id' => $this->paquete['id'],
                'nombre' => $this->paquete['nombre'],
                'descripcion' => $this->paquete['descripcion'],
                'cantidad' => $this->paquete['cantidad'],
                'precio_unitario' => $this->paquete['precio_unitario'],
                'precio' =>  $this->paquete['cantidad'] * $this->paquete['precio_unitario'],
            ];

        } else {
            $this->paquete = [
                'id' => $this->paquete['id'],
                'nombre' => $this->paquete['nombre'],
                'descripcion' => $this->paquete['descripcion'],
                'cantidad' => $this->paquete['cantidad'],
                'precio_unitario' => $this->paquete['precio_unitario'],
                "precio" => ""
            ];
        }
    }

    public function render()
    {
        $this->listaPaquetes = Paquete::all();
        return view('livewire.pedido.pedido-detalle.cotizacion.detalle-paquetes');
    }
}
