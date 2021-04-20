<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle\Cotizacion;

use App\Models\Servicio;
use Livewire\Component;

class DetalleServicios extends Component
{
    public $index;
    public $count;
    public $orderServicio;
    public $servicio =[];
    public $listaServicios =[];


    public function mount($orderServicio, $index)
    {
        $this->count = $index;
        $this->servicio = [
            'id' => $orderServicio['id'],
            'nombre' => $orderServicio['nombre'],
            'cantidad' => $orderServicio['cantidad'],
            'precio_unitario' => $orderServicio['precio_unitario'],
            'precio' => $orderServicio['precio'],
        ];
    }

    public function encontrarServicio()
    {
        $servicio = Servicio::where("nombre", "=", trim($this->servicio['nombre']))
        ->first();
        if ($servicio) {
            $this->servicio = [
                'id' => $servicio->id,
                'nombre' => $servicio->nombre,
                'cantidad' => 1,
                'precio_unitario' => $servicio->precio,
                'precio' => $servicio->precio,
            ];
        } else{
            $this->servicio = [
                'id' => '',
                'nombre' => $this->servicio['nombre'],
                'cantidad' => 1,
                'precio_unitario' => '',
                'precio' => '',
            ];
        };
    }

    public function totalServicio()
    {
        $check = $this->servicio['cantidad'];
        $check2 = $this->servicio['precio_unitario'];

        if (is_numeric($check) && is_numeric($check2)) {
            $this->servicio = [
                'id' => $this->servicio['id'],
                'nombre' => $this->servicio['nombre'],
                'cantidad' => $this->servicio['cantidad'],
                'precio_unitario' => $this->servicio['precio_unitario'],
                'precio' =>  $this->servicio['cantidad'] * $this->servicio['precio_unitario'],
            ];

        } else {
            $this->servicio = [
                'id' => $this->servicio['id'],
                'nombre' => $this->servicio['nombre'],
                'cantidad' => $this->servicio['cantidad'],
                'precio_unitario' => $this->servicio['precio_unitario'],
                "precio" => ""
            ];
        }
    }

    public function render()
    {
        $this->listaServicios = Servicio::where('activo','=',0)->get();
        return view('livewire.pedido.pedido-detalle.cotizacion.detalle-servicios');
    }
}
