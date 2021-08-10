<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle\Cotizacion;

use App\Models\Repuesto;
use Livewire\Component;

class DetalleRepuestos extends Component
{
    public $index;
    public $count;
    public $orderRepuesto;
    public $repuesto =[];
    public $listaRepuestos =[];


    public function mount($orderRepuesto, $index)
    {
        $this->count = $index;
        $this->repuesto = [
            'id' => $orderRepuesto['id'],
            'nombre' => $orderRepuesto['nombre'],
            'cantidad' => $orderRepuesto['cantidad'],
            'precio_unitario' => $orderRepuesto['precio_unitario'],
            'precio' => $orderRepuesto['precio'],
        ];
    }

    public function encontrarRepuesto()
    {
        $repuesto = Repuesto::where("nombre", "=", trim($this->repuesto['nombre']))
        ->first();
        if ($repuesto) {
            $this->repuesto = [
                'id' => $repuesto->id,
                'nombre' => $repuesto->nombre,
                'cantidad' => 1,
                'precio_unitario' => $repuesto->precio,
                'precio' => $repuesto->precio,
            ];
        } else{
            $this->repuesto = [
                'id' => '',
                'nombre' => $this->repuesto['nombre'],
                'cantidad' => 1,
                'precio_unitario' => '',
                'precio' => '',
            ];
        };
    }

    public function totalRepuesto()
    {
        $check = $this->repuesto['cantidad'];
        $check2 = $this->repuesto['precio_unitario'];

        if (is_numeric($check) && is_numeric($check2)) {
            $this->repuesto = [
                'id' => $this->repuesto['id'],
                'nombre' => $this->repuesto['nombre'],
                'cantidad' => $this->repuesto['cantidad'],
                'precio_unitario' => $this->repuesto['precio_unitario'],
                'precio' =>  $this->repuesto['cantidad'] * $this->repuesto['precio_unitario'],
            ];

        } else {
            $this->repuesto = [
                'id' => $this->repuesto['id'],
                'nombre' => $this->repuesto['nombre'],
                'cantidad' => $this->repuesto['cantidad'],
                'precio_unitario' => $this->repuesto['precio_unitario'],
                "precio" => ""
            ];
        }
    }

    public function render()
    {
        $this->listaRepuestos = Repuesto::where('activo','=',0)->get();
        return view('livewire.pedido.pedido-detalle.cotizacion.detalle-repuestos');
    }
}
