<?php

namespace App\Http\Livewire\Widget\Charts;

use App\Models\Pedido;
use Illuminate\Support\Collection;
use Livewire\Component;

class Chart1 extends Component
{
    public $year;
    public $months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    public Collection $pedidosPorMes;

    public function mount(){
        $this->year = now()->year;
    }

    public function render()
    {
        $pedidos = Pedido::whereYear('created_at', $this->year)->get();
        $this->pedidosPorMes = collect(range(01,12))->map(function($mes) use ($pedidos) {
            return $pedidos->filter(function ($pedido) use($mes) {
                return $pedido->created_at->format('m') == $mes;
            })->count();
        });

        $this->emit('refreshChart', ['pedidosPorMes' => $this->pedidosPorMes]);

        return view('livewire.widget.charts.chart1');
    }
}
