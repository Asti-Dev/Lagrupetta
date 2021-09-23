<?php

namespace App\Http\Controllers;

use App\Mail\MailCotizacion;
use App\Models\Paquete;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\PedidoDetalleServicio;
use App\Models\PedidoEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class CobranzaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {

        return view('pages.cobranza.show',compact('pedido'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pedidoDetalleId)
    {
        $pedidoDetalle = PedidoDetalle::find($pedidoDetalleId);

        $request->validate([
            'fecha_entrega' => 'required',
            'explicacion' => 'required',
        ]);
        $pedido = Pedido::find($pedidoDetalle->pedido->id);

        $this->insertarRepuestos($request, $pedidoDetalle);

        $this->insertarServicios($request, $pedidoDetalle);

        $this->insertarPaquetes($request, $pedidoDetalle);

        $pedido->pedidoDetalle->update([
            'explicacion' => $request->input('explicacion'),
            'fecha_entrega_aprox' => $request->input('fecha_entrega'),
            'precio_total' => $request->input('total_precio'),
            'precio_final' => $request->input('total_precio'),
        ]);

        try{
            Mail::to($pedido->cliente->email)
            ->send(new MailCotizacion($pedido, $url= [], $pedido->pedidoDetalle->diagnostico->serial));
        }
        catch(\Exception $e){ // Using a generic exception
            session()->flash('danger', 'Email no enviado!');
        }
        
        return redirect()->route('cobranza.show', compact('pedido'))
            ->with('success', 'Cotizacion actualizada!');

    }
    public function insertarRepuestos(Request $request, PedidoDetalle $pedidoDetalle)
    {
        if ($request->input('idrepuestos', [])) {
            $idrepuestos = $request->input('idrepuestos', []);
            $cantidad = $request->input('cantidadrepuesto', []);
            $precio = $request->input('preciorepuesto', []);

            $arrayRepuestos = [];

            for ($repuesto = 0; $repuesto < count($idrepuestos); $repuesto++) {
                if ($idrepuestos[$repuesto] != '') {

                    $arrayRepuestos[$idrepuestos[$repuesto]] = [
                            'cantidad_pendiente' => 0,
                            'cantidad' => $cantidad[$repuesto],
                            'precio_total' => $precio[$repuesto],
                            'precio_final' => $precio[$repuesto],
                            'checked' => true
                    ];
                }
            }

            $repuestoIDs = array_keys($arrayRepuestos);

            $updateIDs = DB::table('pedido_detalle_repuesto')
                ->where('pedido_detalle_id',$pedidoDetalle->id)
                ->whereIn('repuesto_id',$repuestoIDs)
                ->pluck('id','repuesto_id')->toArray();

                DB::table('pedido_detalle_repuesto')
                ->where('pedido_detalle_id',$pedidoDetalle->id)
                ->whereNotIn('repuesto_id',$repuestoIDs)
                ->delete();

            $createRepuestos = array_diff_key($arrayRepuestos, $updateIDs);
            $updateRepuestos = array_intersect_key($arrayRepuestos, $updateIDs);

            foreach ($updateIDs as $repuesto_id => $updateID) {

                DB::table('pedido_detalle_repuesto')
                ->where('id',$updateID)->update([
                    'cantidad_pendiente' => 0,
                    'cantidad' => $updateRepuestos[$repuesto_id]['cantidad'],
                    'precio_total' => $updateRepuestos[$repuesto_id]['precio_total'],
                    'precio_final' => $updateRepuestos[$repuesto_id]['precio_final'],
                    'checked' => true,
                ]);
            }

            $pedidoDetalle->repuestos()->attach($createRepuestos);

        }
    }

    public function insertarServicios(Request $request, PedidoDetalle $pedidoDetalle)
    {
        if ($request->input('idservicios', [])) {
            $idservicios = $request->input('idservicios', []);
            $cantidad = $request->input('cantidadservicio', []);
            $precio = $request->input('precioservicio', []);
            $arrayServicios = [];

            for ($servicio = 0; $servicio < count($idservicios); $servicio++) {
                if ($idservicios[$servicio] != '') {

                    $arrayServicios[$idservicios[$servicio]] = [
                            'cantidad_pendiente' => 0,
                            'cantidad' => $cantidad[$servicio],
                            'precio_total' => $precio[$servicio],
                            'precio_final' => $precio[$servicio],
                            'checked' => true,
                    ];
                }
            }

            $servicioIDs = array_keys($arrayServicios);

            $updateIDs = DB::table('pedido_detalle_servicio')
                ->where('pedido_detalle_id',$pedidoDetalle->id)
                ->where('paquete_id', null)
                ->whereIn('servicio_id',$servicioIDs)
                ->pluck('id','servicio_id')->toArray();

                DB::table('pedido_detalle_servicio')
                ->where('pedido_detalle_id',$pedidoDetalle->id)
                ->where('paquete_id', null)
                ->whereNotIn('servicio_id',$servicioIDs)
                ->delete();
            
            $createServicios = array_diff_key($arrayServicios, $updateIDs);
            $updateServicios = array_intersect_key($arrayServicios, $updateIDs);

            foreach ($updateIDs as $servicio_id => $updateID) {

                DB::table('pedido_detalle_servicio')
                ->where('id',$updateID)->update([
                    'cantidad_pendiente' => $updateServicios[$servicio_id]['cantidad_pendiente'],
                    'cantidad' => $updateServicios[$servicio_id]['cantidad'],
                    'precio_total' => $updateServicios[$servicio_id]['precio_total'],
                    'precio_final' => $updateServicios[$servicio_id]['precio_final'],
                    'checked' => $updateServicios[$servicio_id]['checked'],
                ]);
            }
            

            $pedidoDetalle->servicios()->attach($createServicios);
        }
    }

    public function insertarPaquetes(Request $request, PedidoDetalle $pedidoDetalle)
    {
        if ($request->input('idpaquetes', [])) {
            $idpaquetes = $request->input('idpaquetes', []);
            $cantidad = $request->input('cantidadpaquete', []);
            $precio = $request->input('preciopaquete', []);

            $BD = PedidoDetalleServicio::where('pedido_detalle_id',$pedidoDetalle->id)
            ->where('paquete_id', '!=', null)
            ->get();
            $test = $BD->whereIn('paquete_id',$idpaquetes);
            $result = collect();
          

            //eliminar
            for ($i=0; $i < count($idpaquetes); $i++) { 
                $listaIDsPaqueteServiciosEnVenta = Paquete::find($idpaquetes[$i])->servicios->pluck('id')->isEmpty() ? [null] : 
                Paquete::find($idpaquetes[$i])->servicios->pluck('id')->toArray();

                $listaIDsPaqueteServiciosBD = $test->where('paquete_id', $idpaquetes[$i])->pluck('servicio_id')->toArray();

                $serviciosEliminar = array_diff($listaIDsPaqueteServiciosBD, $listaIDsPaqueteServiciosEnVenta);
            
                if (!empty($serviciosEliminar)) {
                    foreach ($test->where('paquete_id', $idpaquetes[$i]) as $key => $value) {
                        if (in_array($value->servicio_id, $serviciosEliminar)) {
                            $test->forget($key);
                        }
                    }
                }
            }

            //actualizar
            for ($i=0; $i < count($idpaquetes); $i++) { 
                foreach ($test->where('paquete_id', $idpaquetes[$i]) as $key => $value) {
                    $cantidad_final = 0;
                    $item = new PedidoDetalleServicio();
                    $item->paquete_id = $idpaquetes[$i];
                    $item->servicio_id = $value->servicio_id;
                    $item->cantidad_pendiente = $cantidad_final;
                    $item->cantidad = $cantidad[$i];
                    $item->precio_total = $precio[$i];
                    $item->precio_final = $precio[$i];
                    $item->pedido_detalle_id = $pedidoDetalle->id;
                    $item->checked = ($cantidad_final === 0 ) ? true : false;
                    $result->push($item);
                }
            }

            //crear
            for ($i=0; $i < count($idpaquetes); $i++) { 
                if($test->where('paquete_id', $idpaquetes[$i])->isEmpty()){
                    $paqueteObj = Paquete::find($idpaquetes[$i]);
                    if($paqueteObj->servicios->isEmpty()){
                        $item = new PedidoDetalleServicio();
                        $item->paquete_id = $idpaquetes[$i];
                        $item->cantidad_pendiente = 0;
                        $item->cantidad = $cantidad[$i];
                        $item->precio_total = $precio[$i];
                        $item->precio_final = $precio[$i];
                        $item->pedido_detalle_id = $pedidoDetalle->id;
                        $item->checked = true;
                        $result->push($item);
                    } else {
                        foreach ($paqueteObj->servicios as $key => $servicio) {
                            $item = new PedidoDetalleServicio();
                            $item->paquete_id = $idpaquetes[$i];
                            $item->servicio_id = $servicio->id;
                            $item->cantidad_pendiente = 0;
                            $item->cantidad = $cantidad[$i];
                            $item->precio_total = $precio[$i];
                            $item->precio_final = $precio[$i];
                            $item->pedido_detalle_id = $pedidoDetalle->id;
                            $item->checked = true;
                            $result->push($item);
                        }
                    }
                    
                }
            }
            
            PedidoDetalleServicio::where('pedido_detalle_id',$pedidoDetalle->id)->where('paquete_id','!=', null)->delete();
            
            $result?->each(function ($item, $key) {
                $item->save();
            });
            
        } else {
            PedidoDetalleServicio::where('pedido_detalle_id',$pedidoDetalle->id)->where('paquete_id','!=', null)->delete();
        }
    }
}
