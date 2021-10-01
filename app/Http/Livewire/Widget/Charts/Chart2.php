<?php

namespace App\Http\Livewire\Widget\Charts;

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Transporte;
use Illuminate\Support\Collection;
use Livewire\Component;

class Chart2 extends Component
{
    public $areas = array("Transporte","Almacen","Taller","Calidad","Cobranza");
    public Collection $pedidosPorArea;
    public $transporte = array('EN RUTA RECOJO','EN RUTA ENTREGA');
    public $almacen = array('DEPOSITADO','EN ALMACEN', 'DEPOSITADO MECANICO','EN ALMACEN TERMINADO');
    public $taller = array('EN TALLER','COTIZADO','EN PROCESO','EN ESPERA','CORREGIR','TERMINADO');
    public $calidad = array('EN CALIDAD');
    public $cobranza = array('TERMINADO','EN RUTA ENTREGA','EN ALMACEN TERMINADO','PAGO PENDIENTE');
    public $facturados;

    public function mount(){
    }

    public function render()
    {
        $transportesIdList = collect(Pedido::with('transportes')->get())->map(function($pedido){
            return isset($pedido->transportes[1]) ? $pedido->transportes[1]['id'] : $pedido->transportes[0]['id'];
        })->toArray();

        $transporteCount = Transporte::whereIn('id', $transportesIdList)->where('check', false)->count();

        $tallerCount = PedidoDetalle::whereHas('pedido.pedidoEstado', function($q){

            $q->whereIn('nombre', $this->taller);

        })->count();

        $calidadCount = PedidoDetalle::whereHas('pedido.pedidoEstado', function($q){

            $q->whereIn('nombre',$this->calidad);

        })->count();

        $almacenCount = Pedido::whereHas('pedidoEstado', function($q){

            $q->whereIn('nombre', $this->almacen);
        
        })->count();

        $cobranzaCount = Pedido::whereHas('pedidoEstado', function($q){

            $q->whereIn('nombre',$this->cobranza);

        })->count();
    
        $this->pedidosPorArea = collect([$transporteCount, $almacenCount,$tallerCount, $calidadCount, $cobranzaCount]);
        $this->emit('refreshChart2', ['pedidosPorArea' => $this->pedidosPorArea]);

        $this->facturados = Pedido::whereHas('pedidoEstado', function($q){

            $q->where('nombre','FACTURADO');

        })->whereMonth('created_at', now()->month)->count();

        return view('livewire.widget.charts.chart2');
    }
}
