<?php

namespace App\Http\Livewire\Taller;

use App\Models\PedidoEstado;
use App\Models\Revision;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class Corregir extends Component
{
    public $revisionId;
    public $revision;
    public $pruebas2 = [];
    public $pruebasR = [];

    protected $rules = [

        'pruebasR.*.completado' => 'required',
        'pruebasR.*.corregir' => 'required',
        'pruebasR.*.comentario' => 'required',
        'pruebasR.*.respuesta' => 'required',

    ];

    public function mount(){
       
        $this->revision = Revision::find($this->revisionId);
        $this->pruebas2 = $this->revision->pruebas()->get();
        foreach ($this->pruebas2 as $key => $prueba) {
            $this->pruebasR[$key] = [
                'completado' =>  $prueba->pivot->completado ,
                'respuesta' =>  $prueba->pivot->respuesta ?? '',
                'comentario' =>  $prueba->pivot->comentario ?? '',

            ];
        }
    }

    
    public function checkCorregir(){

        foreach ($this->pruebas2 as $key => $prueba) {
            $prueba->revisiones()->sync( [$prueba->id => [
                'revision_id' => $this->revision->id,
                'completado' =>  $this->pruebasR[$key]['completado'],
                'respuesta' =>  $this->pruebasR[$key]['respuesta'],
                'corregir' => $this->pruebasR[$key]['completado']  ? 0 : 1 ,
                'comentario' =>  $this->pruebasR[$key]['comentario'],

            ]]);
        }

    }

    public function save(){

        $this->revision->pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre','=','REVISAR')->first()->id,
        ]);

        return Redirect::route('taller.index');
    }

    public function render()
    {
        $pruebas = $this->revision->pruebas()->get();

        return view('livewire.taller.corregir', compact('pruebas'))
        ->extends('layouts.app')
        ->section('content');
    }
}
