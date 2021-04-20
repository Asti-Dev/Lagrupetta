<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle;

use Livewire\Component;
use App\Models\Paquete;
use App\Models\Pedido;
use App\Models\PedidoDetalle as ModelsPedidoDetalle;
use App\Models\PedidoEstado;
use App\Models\Prueba;
use App\Models\Revision;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PedidoDetalle extends Component
{
    public ModelsPedidoDetalle $pedidoDetalleId;
    public $pedido;
    public $paquetes =[];
    public $servicios =[];
    public $status;
    public $totalServicios;
    public $serviciosCompletados;



    public function mount(){
        $this->pedido = Pedido::find($this->pedidoDetalleId->pedido->id);
        
        if($this->pedido->pedidoEstado->nombre === 'EN PROCESO' ){
            $this->status = true;
        }else{
            $this->status = false;
        }
    }

    public function revisar(Pedido $pedido)
    {
        $pruebas = Prueba::all();

        $revision = Revision::create();

        foreach ($pruebas as $prueba) {
            $revision->pruebas()->attach($prueba->id);
        }

        $pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre','=','REVISAR')->first()->id,
            'revision_id' => $revision->id
        ]);

        return Redirect::route('taller.index');
    }

    public function addCantPaquete(Pedido $pedido, Servicio $servicio, Paquete $paquete){

            DB::table('pedido_detalle_servicio')
            ->where( 'pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where( 'paquete_id', $paquete->id)
            ->where( 'servicio_id', $servicio->id)
            ->increment('cantidad_pendiente',1);

            $check = DB::table('pedido_detalle_servicio')
            ->where( 'pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where( 'paquete_id', $paquete->id)
            ->where( 'servicio_id', $servicio->id)
            ->first();

            if ($check->cantidad_pendiente === 0) {
                
                DB::table('pedido_detalle_servicio')
                ->where( 'pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where( 'paquete_id', $paquete->id)
                ->where( 'servicio_id', $servicio->id)
                ->update([
                    'checked' => 1
                ]);

            } else {
                
                DB::table('pedido_detalle_servicio')
                ->where( 'pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where( 'paquete_id', $paquete->id)
                ->where( 'servicio_id', $servicio->id)
                ->update([
                    'checked' => 0
                ]);
            }

    }

    public function removeCantPaquete(Pedido $pedido, Servicio $servicio, Paquete $paquete){

            DB::table('pedido_detalle_servicio')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('paquete_id', $paquete->id)
            ->where('servicio_id', $servicio->id)
            ->decrement('cantidad_pendiente',1);

            $check = DB::table('pedido_detalle_servicio')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('paquete_id', $paquete->id)
            ->where('servicio_id', $servicio->id)
            ->first();

            if ($check->cantidad_pendiente === 0) {
                
                DB::table('pedido_detalle_servicio')
                ->where( 'pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where( 'paquete_id', $paquete->id)
                ->where( 'servicio_id', $servicio->id)
                ->update([
                    'checked' => 1
                ]);

            } else {
                
                DB::table('pedido_detalle_servicio')
                ->where( 'pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where( 'paquete_id', $paquete->id)
                ->where( 'servicio_id', $servicio->id)
                ->update([
                    'checked' => 0
                ]);
            }

    }
    public function addCantServicio(Pedido $pedido, Servicio $servicio){

            DB::table('pedido_detalle_servicio')
            ->where( 'pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where( 'paquete_id', null)
            ->where( 'servicio_id', $servicio->id)
            ->increment('cantidad_pendiente',1);

            $check = DB::table('pedido_detalle_servicio')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('paquete_id', null)
            ->where('servicio_id', $servicio->id)
            ->first();

            if ($check->cantidad_pendiente === 0) {
                
                DB::table('pedido_detalle_servicio')
                ->where( 'pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where( 'paquete_id', null)
                ->where( 'servicio_id', $servicio->id)
                ->update([
                    'checked' => 1
                ]);

            } else {

                DB::table('pedido_detalle_servicio')
                ->where( 'pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where( 'paquete_id', null)
                ->where( 'servicio_id', $servicio->id)
                ->update([
                    'checked' => 0
                ]);
            }
            
    }
    public function removeCantServicio(Pedido $pedido, Servicio $servicio){

             DB::table('pedido_detalle_servicio')
            ->where( 'pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where( 'paquete_id', null)
            ->where( 'servicio_id', $servicio->id)
            ->decrement('cantidad_pendiente',1);

            $check = DB::table('pedido_detalle_servicio')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('paquete_id', null)
            ->where('servicio_id', $servicio->id)
            ->first();

            if ($check->cantidad_pendiente === 0) {
                
                DB::table('pedido_detalle_servicio')
                ->where( 'pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where( 'paquete_id', null)
                ->where( 'servicio_id', $servicio->id)
                ->update([
                    'checked' => 1
                ]);

            } else {
                
                DB::table('pedido_detalle_servicio')
                ->where( 'pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where( 'paquete_id', null)
                ->where( 'servicio_id', $servicio->id)
                ->update([
                    'checked' => 0
                ]);
            }

    }
    public function render()
    {
        if ($this->status) {
            $this->pedido->update([
                'pedido_estado_id' => PedidoEstado::where('nombre','=','EN PROCESO')->first()->id,
            ]);
        } else {
            $this->pedido->update([
                'pedido_estado_id' => PedidoEstado::where('nombre','=','EN ESPERA')->first()->id,
            ]);
        }

        $this->servicios = $this->pedido->pedidoDetalle->servicios()
            ->wherePivot('paquete_id', null)->get();

        $this->paquetes = $this->pedido->pedidoDetalle->paquetes->unique();

        $this->totalServicios = $this->pedido->pedidoDetalle->servicios->count();

        $this->serviciosCompletados = $this->pedido->pedidoDetalle
            ->servicios()->wherePivot('checked',1)->count();

        return view('livewire.pedido.pedido-detalle.pedido-detalle')
        ->extends('layouts.app')
        ->section('content');
    }
}
