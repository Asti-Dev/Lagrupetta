<?php

namespace App\Http\Livewire\Revision;

use App\Models\PedidoEstado;
use App\Models\Prueba;
use App\Models\Revision as ModelsRevision;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class Revision extends Component
{
    public $view = 'table';
    public $revision;
    public $pruebas2 = [];
    public $pruebasR = [];
    public $checkC;
    public $cliente;

    protected $rules = [

        'pruebasR.*.completado' => 'required',
        'pruebasR.*.corregir' => 'required',
        'pruebasR.*.comentario' => 'required',
        'pruebasR.*.respuesta' => 'required',

    ];

    public function revision($revision){
        $this->revision = ModelsRevision::find($revision);
        $this->pruebas2 = $this->revision->pruebas;
        foreach ($this->pruebas2 as $key => $prueba) {
            $this->pruebasR[$key] = [
                'corregir' =>  $prueba->pivot->corregir ,
                'comentario' =>  $prueba->pivot->comentario,
                'respuesta' =>  $prueba->pivot->respuesta,
            ];
        }
        $this->checkC = $this->in_2d_array(1, $this->pruebasR);

        $this->view = 'revisar';
    }

    
    public function checkCorregir(){
        $this->checkC = $this->in_2d_array(1, $this->pruebasR);

        foreach ($this->pruebas2 as $key => $prueba) {
            $prueba->revisiones()->sync( [$prueba->id => [
                'revision_id' => $this->revision->id,
                'corregir' =>  $this->pruebasR[$key]['corregir'],
                'comentario' =>  $this->pruebasR[$key]['comentario'],
                'completado' => ($this->pruebasR[$key]['corregir'] == 1 ) ? 0 : 1 
            ]]);
        }

    }

    public function save(){

        DB::table('revisiones')->where('id', '=', $this->revision->id)
        ->update([
            'mecanico' => (session()->get('empleado_id') == '') ? null : session()->get('empleado_id')
        ]);

        $this->revision->pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre','=','CORREGIR')->first()->id,
        ]);

        $this->view = 'table';

    }

    public static function in_2d_array($needle, $haystack) {
        foreach($haystack as $element) {
            if(in_array($needle, $element))
                return true;
        }
        return false;
    }

    
    public function salida(){

        $pedidoID = $this->revision->pedido->id;

        return Redirect::route('diagnostico.salida', $pedidoID );

    }

    public function index(){

        $this->view = 'table';

    }
    public function render()
    {
        if($this->revision){
            $data['pruebas'] = $this->revision->pruebas()->get();
        }

        $data['revisiones'] = ModelsRevision::whereHas('pedido.pedidoEstado', function($q){

            $q->where('nombre', '=', 'EN CALIDAD');

        })
        ->buscarCliente($this->cliente)
        ->orderBy('id', 'desc')->get();

        return view('livewire.revision.revision', $data)
        ->extends('layouts.app')
        ->section('content');
    }
}
