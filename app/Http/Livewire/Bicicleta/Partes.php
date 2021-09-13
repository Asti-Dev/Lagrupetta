<?php

namespace App\Http\Livewire\Bicicleta;

use Livewire\Component;
use Livewire\WithPagination;

class Partes extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    
    public $bicicleta;

    public function render()
    {
        $partes = $this->bicicleta->partes()->paginate(10);

        return view('livewire.bicicleta.partes', compact('partes'));
    }
}
