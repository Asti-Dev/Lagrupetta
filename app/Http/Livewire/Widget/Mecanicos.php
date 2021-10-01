<?php

namespace App\Http\Livewire\Widget;

use App\Models\Empleado;
use Livewire\Component;

class Mecanicos extends Component
{

    public function render()
    {
        $mecanicos = Empleado::where('cargo','=','mecanico')->withCount([
            'pedidodDetalles' => function ($query){
                $query->whereHas('pedido.pedidoEstado', function($query2){
                    $query2->whereIn('nombre', ['EN TALLER','COTIZADO','EN PROCESO','EN ESPERA','EN CALIDAD','CORREGIR']);
                });
            }
        ])->get();

        return view('livewire.widget.mecanicos', compact('mecanicos'));
    }
}
