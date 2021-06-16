<?php

namespace App\Http\Livewire;

use App\Models\Bicicleta;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Transporte;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;

class Test extends Component
{
    public $try;
    public $testE;
    public $text;
    public $urlwords;

    public  function pdf(){
        $this->urlwords = rawurlencode($this->text);
    }
    
    public function render()
    {
        return view('livewire.test')
        ->extends('layouts.app')
        ->section('content');;
    }
}
