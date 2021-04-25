<?php

namespace App\Http\Livewire\Pedido;

use App\Models\Empleado;
use App\Models\Transporte;
use Livewire\Component;

class AsignarEntregaChofer extends Component
{
    public $pedido;
    public $chofer;
    public $chofers = [];
    
    public function updatedChofer()
    {
        if($this->chofer != ""){
        $this->chofers = Empleado::where([
            ['cargo','=','chofer'],
            ["nombre_apellido", "like","%" . trim($this->chofer) . "%"]
            ])->take(10)
            ->get();
        }else{
            $this->chofers = [];
        }

    }
    
    public function asignar(){

        $chofer = Empleado::where('nombre_apellido','=', $this->chofer)->first();

        Transporte::create([
            'chofer' => $chofer->id,
            'pedido_id' => $this->pedido->id,
            'ruta' => Transporte::RUTA[0]
        ]);

        return redirect()->route('pedidos.index'); 
    }

    public function render()
    {
        return view('livewire.pedido.asignar-entrega-chofer');
    }
}
