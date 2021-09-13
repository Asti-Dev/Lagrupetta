<?php

namespace App\Http\Livewire\Transporte;

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
    public $fecha;
    public $fecha2;
    public $selectFecha;
    public $ruta;
    public $cliente;
    public $nroPedido;



    public function rules()
    {
        return [
            'completado' => Rule::in(ModelsTransporte::CUMPLIMIENTO),
        ];
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

    public function updatedSelectFecha($value)
    {
        switch ($value) {
            case 'HOY':
                $this->fecha = today();
                $this->fecha2 = '';
                break;
            
            case 'SEMANA':
                $this->fecha = today()->subDays(3);
                $this->fecha2 = today()->addDays(7);
                break;

            case 'MES':
                $this->fecha = today()->subDays(7);
                $this->fecha2 = today()->addDays(30);
                break;

            default:
                $this->fecha = '';
                $this->fecha2 = '';
                break;
        }
    }

    public function render()
    {
        $transportesIdList = collect(Pedido::with('transportes')->get())->map(function($pedido){
            return isset($pedido->transportes[1]) ? $pedido->transportes[1]['id'] : $pedido->transportes[0]['id'];
        })->toArray();


        $transportes = ModelsTransporte::whereIn('id', $transportesIdList)->buscarCliente($this->cliente)
            ->buscarPedido($this->nroPedido)
            ->filtrarRuta($this->ruta)
            ->filtrarFecha($this->fecha , $this->fecha2)
            ->choferSession()
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
