<?php

namespace App\Http\Livewire\Bicicleta;

use Livewire\Component;
use Livewire\WithPagination;

class Diagnosticos extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    
    public $bicicleta;


    public function render()
    {
        $diagnosticos = $this->bicicleta->diagnosticos()->orderBy('updated_at','desc')->paginate(3);

        return view('livewire.bicicleta.diagnosticos', compact('diagnosticos'));
    }
}
