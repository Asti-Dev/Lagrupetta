<?php

namespace App\Http\Livewire\Taller\Ingreso;

use App\Events\ProcesarNotificacion;
use App\Models\Empleado;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\PedidoEstado;
use App\Models\Transporte;
use Livewire\Component;

class Form extends Component
{
    public $mecanico;
    public $mecanicos = [];
    public Pedido $pedido;


    protected $rules = [
        'mecanico' => 'required',
    ];
    
    public function updatedMecanico()
    {
        if($this->mecanico != ""){
        $this->mecanicos = Empleado::where('cargo','=','mecanico')->orWhere('cargo','=','jefe mecanicos')->where([
            ["nombre_apellido", "like","%" . trim($this->mecanico) . "%"]
            ])->take(10)
            ->get();
        }else{
            $this->mecanicos = [];
        }

    }

    public function asignar(){
        $mecanico = Empleado::where('nombre_apellido','=', $this->mecanico)->first();

        $transporte = Transporte::find($this->pedido->transporteRecojo->id); 

        $transporte->update(
            ['fecha_hora_local' => now()]
        );

        $pedidoDetalle = PedidoDetalle::create([
            'mecanico' => $mecanico->id
        ]);

        $this->pedido->update([
            'pedido_detalle_id' => $pedidoDetalle->id,
            'pedido_estado_id' => PedidoEstado::where('nombre','EN TALLER')->first()->id
        ]);

        event(new ProcesarNotificacion($this->pedido));

        session()->flash('success', 'Mecanico asignado!');

        return redirect()->route('taller.index');
    }
    
    public function render()
    {
        return view('livewire.taller.ingreso.form');
    }
}
