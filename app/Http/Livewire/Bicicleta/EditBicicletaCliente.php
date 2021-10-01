<?php

namespace App\Http\Livewire\Bicicleta;

use App\Models\Bicicleta;
use Livewire\Component;

class EditBicicletaCliente extends Component
{
    public $marca;
    public $modelo;
    public $color;
    public $codigo;
    public $bicicleta;
    public $bicicletas = [];

    public function updatedBicicleta(){

        $bicicleta = Bicicleta::find($this->bicicleta);

        if (isset($bicicleta)) {
            $this->marca = $bicicleta->marca ?? '';
            $this->modelo = $bicicleta->modelo ?? '';
            $this->codigo = $bicicleta->codigo ?? '';
            $this->color = $bicicleta->color ?? '';
        } else {
            $this->marca = '';
            $this->modelo = '';
            $this->codigo = '';
            $this->color = '';

        }

    }

    public function render()
    {
        return view('livewire.bicicleta.edit-bicicleta-cliente');
    }
}
