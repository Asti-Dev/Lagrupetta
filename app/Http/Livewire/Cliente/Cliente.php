<?php

namespace App\Http\Livewire\Cliente;

use App\Models\Cliente as ModelsCliente;
use Livewire\Component;

class Cliente extends Component
{
    public ModelsCliente $cliente;
    public $tipoDoc = ModelsCliente::TIPODOC;

    public function render()
    {
        return view('livewire.cliente.cliente')  
        ->extends('layouts.app')
        ->section('content');
    }
}
