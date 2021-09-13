<?php

namespace App\Http\Livewire\Transporte;

use App\Models\Empleado;
use App\Models\Pedido;
use App\Models\PedidoEstado;
use App\Models\Transporte as ModelsTransporte;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Transporte extends Component
{
    
    public $view = 'table';

    public ModelsTransporte $transporte;
    public $observacion;
    public Collection $transportes;
    public $estados = [
        'SOLICITADO' => 'EN RUTA RECOJO',
    ];
    public $fechaIni;
    public $fechaFin;
    public $ruta;
    public $cliente;
    public $chofers;
    public $chofer;

    public function rules()
    {
        return [
            'completado' => Rule::in(ModelsTransporte::CUMPLIMIENTO),
        ];
    }

    public function clear()
    {
        $this->fechaIni = '';
        $this->fechaFin = '';
        $this->ruta = '';
        $this->cliente = '';
        $this->chofer = '';

    }

    public function depositar($id)
    {
        $this->transporte = ModelsTransporte::find($id);

        $estado = PedidoEstado::where('nombre', '=', 'DEPOSITADO')->first();

        $this->transporte->update([
            'check' => true,
        ]);

        $this->transporte->pedido->update([
            'pedido_estado_id' => $estado->id,
        ]);
    }

    /** Mostrar los pedido que tengan una instancia en transporte y poder separarlos en recojo y entrega
     * poder ingresar a la instancia y poner observaciones marcar como completado o fallido
     * los estados del pedido seran 
     *  */ 

    public function edit($id)
    {
        $this->transporte = ModelsTransporte::find($id);
        $this->observacion = $this->transporte->observacion_chofer;
     
        $this->view = 'completar';
    }

    public function index()
    {
     
        $this->view = 'table';
    }

    public function completado()
    {
        if( $this->transporte->pedido->pedidoEstado->nombre == 'EN RUTA ENTREGA'){
            $this->transporte->update([
                'observacion_chofer' => $this->observacion,
                'completado' => ModelsTransporte::CUMPLIMIENTO[0] ,
                'fecha_hora_completado' => now(),
                'check' => true,
            ]);
        }else {
            $this->transporte->update([
                'observacion_chofer' => $this->observacion,
                'completado' => ModelsTransporte::CUMPLIMIENTO[0] ,
                'fecha_hora_completado' => now(),
            ]);
        }
        

        $this->view = 'table';
    }

    public function fallido()
    {
        $this->transporte->update([
            'observacion_chofer' => $this->observacion,
            'completado' => ModelsTransporte::CUMPLIMIENTO[1] ,
            'fecha_hora_completado' => now(),
        ]);

        $this->view = 'table';
    }

    public function render()
    {
        $this->chofers = Empleado::where('cargo', 'chofer')->get();

        $transportesIdList = collect(Pedido::with('transportes')->get())->map(function($pedido){
            return isset($pedido->transportes[1]) ? $pedido->transportes[1]['id'] : $pedido->transportes[0]['id'];
        })->toArray();


        $transportes = ModelsTransporte::whereIn('id', $transportesIdList)->buscarCliente($this->cliente)
            ->filtrarRuta($this->ruta)
            ->filtrarFecha($this->fechaIni , $this->fechaFin)
            ->choferSession()
            ->filtrarChofer($this->chofer)
            ->whereHas('pedido', function($q){

                $q->where('confirmacion', '=', 'ACEPTADO');
    
            })
            ->orderBy('created_at', 'asc')->get();

            $this->transportes = $transportes->where('check', false);
        
        return view('livewire.transporte.transporte')
        ->extends('layouts.app')
        ->section('content');
    }
}
