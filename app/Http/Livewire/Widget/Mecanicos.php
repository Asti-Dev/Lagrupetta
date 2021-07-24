<?php

namespace App\Http\Livewire\Widget;

use App\Models\Empleado;
use Livewire\Component;

class Mecanicos extends Component
{

    public function render()
    {
        $mecanicos = Empleado::where('cargo','=','mecanico')->paginate(5);

        return view('livewire.widget.mecanicos', compact('mecanicos'));
    }
}
