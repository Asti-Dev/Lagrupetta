<?php

namespace App\Http\Livewire\Pedido\PedidoDetalle;

use App\Events\ProcesarNotificacion;
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
use Maatwebsite\Excel\Concerns\ToArray;

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
            'pedido_estado_id' => PedidoEstado::where('nombre', '=', 'EN CALIDAD')->first()->id,
            'revision_id' => $revision->id
        ]);

        event(new ProcesarNotificacion($pedido->pedidoLog));

        return Redirect::route('taller.index');
    }

    public function addCantPaquete($id)
    {

        DB::table('pedido_detalle_servicio')
            ->where('id', $id)
            ->increment('cantidad_pendiente', 1);

        $check = DB::table('pedido_detalle_servicio')
            ->where('id', $id)
            ->first();
        
        if ($check->cantidad_pendiente === 0) {

            DB::table('pedido_detalle_servicio')
                ->where('id', $id)
                ->update([
                    'checked' => 1
                ]);
        } else {

            DB::table('pedido_detalle_servicio')
                ->where('id', $id)
                ->update([
                    'checked' => 0
                ]);
        }
    }

    public function removeCantPaquete($id)
    {

        DB::table('pedido_detalle_servicio')
            ->where('id', $id)
            ->decrement('cantidad_pendiente', 1);

        $check = DB::table('pedido_detalle_servicio')
            ->where('id', $id)
            ->first();

        if ($check->cantidad_pendiente === 0) {

            DB::table('pedido_detalle_servicio')
                ->where('id', $id)
                ->update([
                    'checked' => 1
                ]);
        } else {

            DB::table('pedido_detalle_servicio')
                ->where('id', $id)
                ->update([
                    'checked' => 0
                ]);
        }
    }
    public function addCantServicio($id)
    {

        DB::table('pedido_detalle_servicio')
            ->where('id', $id)
            ->increment('cantidad_pendiente', 1);

        $check = DB::table('pedido_detalle_servicio')
            ->where('id', $id)
            ->first();

        if ($check->cantidad_pendiente === 0) {

            DB::table('pedido_detalle_servicio')
                ->where('id', $id)
                ->update([
                    'checked' => 1
                ]);
        } else {

            DB::table('pedido_detalle_servicio')
                ->where('id', $id)
                ->update([
                    'checked' => 0
                ]);
        }
    }
    public function removeCantServicio($id)
    {

        DB::table('pedido_detalle_servicio')
            ->where('id', $id)
            ->decrement('cantidad_pendiente', 1);

        $check = DB::table('pedido_detalle_servicio')
            ->where('id', $id)
            ->first();

        if ($check->cantidad_pendiente === 0) {

            DB::table('pedido_detalle_servicio')
                ->where('id', $id)
                ->update([
                    'checked' => 1
                ]);
        } else {

            DB::table('pedido_detalle_servicio')
                ->where('id', $id)
                ->update([
                    'checked' => 0
                ]);
        }
    }
    public function addCantRepuesto($id)
    {

        DB::table('pedido_detalle_repuesto')
            ->where('id', $id)
            ->increment('cantidad_pendiente', 1);

        $check = DB::table('pedido_detalle_repuesto')
            ->where('id', $id)
            ->first();

        if ($check->cantidad_pendiente === 0) {

            DB::table('pedido_detalle_repuesto')
                ->where('id', $id)
                ->update([
                    'checked' => 1
                ]);
        } else {

            DB::table('pedido_detalle_repuesto')
                ->where('id', $id)
                ->update([
                    'checked' => 0
                ]);
        }
    }
    public function removeCantRepuesto($id)
    {

        DB::table('pedido_detalle_repuesto')
            ->where('id', $id)
            ->decrement('cantidad_pendiente', 1);

        $check = DB::table('pedido_detalle_repuesto')
            ->where('id', $id)
            ->first();

        if ($check->cantidad_pendiente === 0) {

            DB::table('pedido_detalle_repuesto')
                ->where('id', $id)
                ->update([
                    'checked' => 1
                ]);
        } else {

            DB::table('pedido_detalle_repuesto')
                ->where('id', $id)
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
                event(new ProcesarNotificacion($this->pedido->pedidoLog));
            } else {
                $this->pedido->update([
                    'pedido_estado_id' => PedidoEstado::where('nombre', '=', 'EN ESPERA')->first()->id,
                ]);
                event(new ProcesarNotificacion($this->pedido->pedidoLog));
            }
        } else {
             redirect()->route('taller.index');
        }

        $this->servicios = $this->pedido->pedidoDetalle->servicios()
            ->wherePivot('paquete_id', null)->get();

        $paquetes = $this->pedido->pedidoDetalle->paquetes->unique();

        foreach ($paquetes as $paquete) {
            $this->paquetes[$paquete->nombre] = $this->pedido->pedidoDetalle->servicios()->wherePivot('paquete_id', $paquete->id)->get();
        }

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
