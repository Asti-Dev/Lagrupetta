<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle;

use Livewire\Component;
use App\Models\Paquete;
use App\Models\Pedido;
use App\Models\PedidoDetalle as ModelsPedidoDetalle;
use App\Models\PedidoEstado;
use App\Models\Prueba;
use App\Models\Repuesto;
use App\Models\Revision;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PedidoDetalle extends Component
{
    public ModelsPedidoDetalle $pedidoDetalleId;
    public $pedido;
    public $paquetes = [];
    public $servicios = [];
    public $repuestos = [];
    public $status;
    public $totalServicios;
    public $serviciosCompletados;
    public $totalRepuestos;
    public $repuestosCompletados;
    public $checkTotal;
    public $checkCompletos;




    public function mount()
    {
        $this->pedido = Pedido::find($this->pedidoDetalleId->pedido->id);
            if ($this->pedido->pedidoEstado->nombre === 'EN PROCESO') {
                $this->status = true;
            } else {
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
            'pedido_estado_id' => PedidoEstado::where('nombre', '=', 'REVISAR')->first()->id,
            'revision_id' => $revision->id
        ]);

        return Redirect::route('taller.index');
    }

    public function addCantPaquete(Pedido $pedido, Servicio $servicio, Paquete $paquete)
    {

        DB::table('pedido_detalle_servicio')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('paquete_id', $paquete->id)
            ->where('servicio_id', $servicio->id)
            ->increment('cantidad_pendiente', 1);

        $check = DB::table('pedido_detalle_servicio')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('paquete_id', $paquete->id)
            ->where('servicio_id', $servicio->id)
            ->first();

        if ($check->cantidad_pendiente === 0) {

            DB::table('pedido_detalle_servicio')
                ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where('paquete_id', $paquete->id)
                ->where('servicio_id', $servicio->id)
                ->update([
                    'checked' => 1
                ]);
        } else {

            DB::table('pedido_detalle_servicio')
                ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where('paquete_id', $paquete->id)
                ->where('servicio_id', $servicio->id)
                ->update([
                    'checked' => 0
                ]);
        }
    }

    public function removeCantPaquete(Pedido $pedido, Servicio $servicio, Paquete $paquete)
    {

        DB::table('pedido_detalle_servicio')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('paquete_id', $paquete->id)
            ->where('servicio_id', $servicio->id)
            ->decrement('cantidad_pendiente', 1);

        $check = DB::table('pedido_detalle_servicio')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('paquete_id', $paquete->id)
            ->where('servicio_id', $servicio->id)
            ->first();

        if ($check->cantidad_pendiente === 0) {

            DB::table('pedido_detalle_servicio')
                ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where('paquete_id', $paquete->id)
                ->where('servicio_id', $servicio->id)
                ->update([
                    'checked' => 1
                ]);
        } else {

            DB::table('pedido_detalle_servicio')
                ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where('paquete_id', $paquete->id)
                ->where('servicio_id', $servicio->id)
                ->update([
                    'checked' => 0
                ]);
        }
    }
    public function addCantServicio(Pedido $pedido, Servicio $servicio)
    {

        DB::table('pedido_detalle_servicio')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('paquete_id', null)
            ->where('servicio_id', $servicio->id)
            ->increment('cantidad_pendiente', 1);

        $check = DB::table('pedido_detalle_servicio')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('paquete_id', null)
            ->where('servicio_id', $servicio->id)
            ->first();

        if ($check->cantidad_pendiente === 0) {

            DB::table('pedido_detalle_servicio')
                ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where('paquete_id', null)
                ->where('servicio_id', $servicio->id)
                ->update([
                    'checked' => 1
                ]);
        } else {

            DB::table('pedido_detalle_servicio')
                ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where('paquete_id', null)
                ->where('servicio_id', $servicio->id)
                ->update([
                    'checked' => 0
                ]);
        }
    }
    public function removeCantServicio(Pedido $pedido, Servicio $servicio)
    {

        DB::table('pedido_detalle_servicio')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('paquete_id', null)
            ->where('servicio_id', $servicio->id)
            ->decrement('cantidad_pendiente', 1);

        $check = DB::table('pedido_detalle_servicio')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('paquete_id', null)
            ->where('servicio_id', $servicio->id)
            ->first();

        if ($check->cantidad_pendiente === 0) {

            DB::table('pedido_detalle_servicio')
                ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where('paquete_id', null)
                ->where('servicio_id', $servicio->id)
                ->update([
                    'checked' => 1
                ]);
        } else {

            DB::table('pedido_detalle_servicio')
                ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where('paquete_id', null)
                ->where('servicio_id', $servicio->id)
                ->update([
                    'checked' => 0
                ]);
        }
    }
    public function addCantRepuesto(Pedido $pedido, Repuesto $repuesto)
    {

        DB::table('pedido_detalle_repuesto')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('repuesto_id', $repuesto->id)
            ->increment('cantidad_pendiente', 1);

        $check = DB::table('pedido_detalle_repuesto')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('repuesto_id', $repuesto->id)
            ->first();

        if ($check->cantidad_pendiente === 0) {

            DB::table('pedido_detalle_repuesto')
                ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where('repuesto_id', $repuesto->id)
                ->update([
                    'checked' => 1
                ]);
        } else {

            DB::table('pedido_detalle_repuesto')
                ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where('repuesto_id', $repuesto->id)
                ->update([
                    'checked' => 0
                ]);
        }
    }
    public function removeCantRepuesto(Pedido $pedido, Repuesto $repuesto)
    {

        DB::table('pedido_detalle_repuesto')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('repuesto_id', $repuesto->id)
            ->decrement('cantidad_pendiente', 1);

        $check = DB::table('pedido_detalle_repuesto')
            ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
            ->where('repuesto_id', $repuesto->id)
            ->first();

        if ($check->cantidad_pendiente === 0) {

            DB::table('pedido_detalle_repuesto')
                ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where('repuesto_id', $repuesto->id)
                ->update([
                    'checked' => 1
                ]);
        } else {

            DB::table('pedido_detalle_repuesto')
                ->where('pedido_detalle_id', $pedido->pedidoDetalle->id)
                ->where('repuesto_id', $repuesto->id)
                ->update([
                    'checked' => 0
                ]);
        }
    }
    public function render()
    {
        if (
            $this->pedido->pedidoEstado->nombre === 'EN PROCESO'
            || $this->pedido->pedidoEstado->nombre === 'EN ESPERA'
            || $this->pedido->pedidoEstado->nombre === 'COTIZADO'
        ) {
            if ($this->status) {
                $this->pedido->update([
                    'pedido_estado_id' => PedidoEstado::where('nombre', '=', 'EN PROCESO')->first()->id,
                ]);
            } else {
                $this->pedido->update([
                    'pedido_estado_id' => PedidoEstado::where('nombre', '=', 'EN ESPERA')->first()->id,
                ]);
            }
        } else {
             redirect()->route('taller.index');
        }

        $this->servicios = $this->pedido->pedidoDetalle->servicios()
            ->wherePivot('paquete_id', null)->get();

        $this->paquetes = $this->pedido->pedidoDetalle->paquetes->unique();

        $this->repuestos = $this->pedido->pedidoDetalle->repuestos;

        $this->totalServicios = $this->pedido->pedidoDetalle->servicios->count();

        $this->serviciosCompletados = $this->pedido->pedidoDetalle
            ->servicios()->wherePivot('checked', 1)->count();

        $totalRepuestos = $this->pedido->pedidoDetalle->repuestos->count();

        $repuestosCompletados = $this->pedido->pedidoDetalle
            ->repuestos()->wherePivot('checked', 1)->count();

        $this->checkTotal = $totalRepuestos + $this->totalServicios;
        $this->checkCompletos = $this->serviciosCompletados + $repuestosCompletados;

        return view('livewire.pedido.pedido-detalle.pedido-detalle')
            ->extends('layouts.app')
            ->section('content');
    }
}
