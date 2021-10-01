<?php

namespace App\Http\Livewire\Widget\Charts;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Transporte;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class Chart3 extends Component
{
    public $distritos = Cliente::DISTRITOS;
    public Collection $pedidosPorDistrito;
    public $fechaIni;
    public $fechaFin;

    public function mount(){
    }

    public function render()
    {
        $transportesIdList = collect(Pedido::with('transportes')->get())->map(function($pedido){
            return isset($pedido->transportes[1]) ? $pedido->transportes[1]['id'] : $pedido->transportes[0]['id'];
        })->toArray();

        $transportes = Transporte::whereIn('id', $transportesIdList)->filtrarFecha($this->fechaIni,$this->fechaFin)->get();
    
        $this->pedidosPorDistrito = collect($this->distritos)->map(function($distrito) use ($transportes){
           
            return $transportes->where('distrito', $distrito)->count();
        });

        $this->emit('refreshChart3', ['pedidosPorDistrito' => $this->pedidosPorDistrito]);
        
        return view('livewire.widget.charts.chart3');
    }
}
