<?php

namespace App\Http\Controllers;

use App\Events\ProcesarNotificacion;
use App\Mail\MailCotizacion;
use App\Mail\ServicioTerminado;
use App\Models\Bicicleta;
use App\Models\Cliente;
use App\Models\Diagnostico;
use App\Models\Empleado;
use App\Models\Paquete;
use App\Models\Parte;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\PedidoDetalleServicio;
use App\Models\PedidoEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class CotizacionController extends Controller
{
    public function show($pedidoId)
    {
        //mostrar Cotizacion en Pedidos
        $data = [];
        $data['pedido'] = Pedido::find($pedidoId);

        return view('pages.cotizacion.show', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PedidoDetalle  $pedidoDetalle
     * @return \Illuminate\Http\Response
     */
    public function edit($pedidoDetalleId)
    {
        //Reenviar Correo Cotizacion
        $empleado = Empleado::find(session()->get('empleado_id'));
        $pedidoDetalle = PedidoDetalle::find($pedidoDetalleId);
        $pedido = Pedido::find($pedidoDetalle->pedido->id);
        $diagnostico = Diagnostico::find($pedidoDetalle->diagnostico->id);


        $url['aceptar'] = URL::temporarySignedRoute(
            'pedido.aceptarCotizacion',
            now()->addMinutes(1440),
            ['pedido' => $pedido->id]
        );

        $url['rechazar'] = URL::temporarySignedRoute(
            'pedido.rechazarCotizacion',
            now()->addMinutes(1440),
            ['pedido' => $pedido->id]
        );

        try{
            Mail::to($pedido->cliente->email)
            ->send(new MailCotizacion($pedido, $url, $diagnostico->serial));
        }
        catch(\Exception $e){ // Using a generic exception
            session()->flash('danger', 'Email no enviado!');

            if($this->findUserRole($empleado)){
                return redirect()->route('pedidos.index');
            }

            return redirect()->route('taller.index');
        }

        if($this->findUserRole($empleado)){
            return redirect()->route('pedidos.index')
            ->with('success', 'Cotizacion reenviada!');
        }
        return redirect()->route('taller.index')
            ->with('success', 'Cotizacion reenviada!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PedidoDetalle  $pedidoDetalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pedidoDetalleId)
    {
        //crear cotizacion y diagnostico
        $pedidoDetalle = PedidoDetalle::find($pedidoDetalleId);

        $request->validate([
            'fecha_entrega' => 'required',
            'explicacion' => 'required',
        ]);
        $pedido = Pedido::find($pedidoDetalle->pedido->id);

        $diagnostico = $this->createDiagnostico($request, $pedidoDetalle, $salida = 0);

        $this->insertarRepuestos($request, $pedidoDetalle);

        $this->insertarServicios($request, $pedidoDetalle);

        $this->insertarPaquetes($request, $pedidoDetalle);

        $pedido->pedidoDetalle->update([
            'explicacion' => $request->input('explicacion'),
            'diagnostico_id' => $diagnostico->id,
            'fecha_entrega_aprox' => $request->input('fecha_entrega'),
            'precio_total' => $request->input('total_precio'),
            'precio_final' => $request->input('total_precio'),
            'confirmacion' => PedidoDetalle::ESTADOS[1],
        ]);

        $pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre', 'COTIZADO')->first()->id,
        ]);

        event(new ProcesarNotificacion($pedido, false, PedidoDetalle::ESTADOS[1]));

        $url['aceptar'] = URL::temporarySignedRoute(
            'pedido.aceptarCotizacion',
            now()->addMinutes(1440),
            ['pedido' => $pedido->id]
        );

        $url['rechazar'] = URL::temporarySignedRoute(
            'pedido.rechazarCotizacion',
            now()->addMinutes(1440),
            ['pedido' => $pedido->id]
        );

            try{
                Mail::to($pedido->cliente->email)
            ->send(new MailCotizacion($pedido, $url, $diagnostico->serial));
            }
            catch(\Exception $e){ // Using a generic exception
                session()->flash('danger', 'Email no enviado!');
            }

        return redirect()->route('taller.index')
            ->with('success', 'Cotizacion realizada!');
    }

    public function updateCotizacion(Request $request, $pedidoDetalleId)
    {
        //actualizar cotizacion
        $pedidoDetalle = PedidoDetalle::find($pedidoDetalleId);

        $request->validate([
            'fecha_entrega' => 'required',
            'explicacion' => 'required',
        ]);
        $pedido = Pedido::find($pedidoDetalle->pedido->id);

        $this->insertarRepuestos($request, $pedidoDetalle);

        $this->insertarServicios($request, $pedidoDetalle);

        $this->insertarPaquetes($request, $pedidoDetalle);

        $pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre', '=', 'COTIZADO')->first()->id,
        ]);

        $pedido->pedidoDetalle->update([
            'explicacion' => $request->input('explicacion'),
            'fecha_entrega_aprox' => $request->input('fecha_entrega'),
            'precio_total' => $request->input('total_precio'),
            'precio_final' => $request->input('total_precio'),
            'confirmacion' => PedidoDetalle::ESTADOS[1],
        ]);

        event(new ProcesarNotificacion($pedido, false, PedidoDetalle::ESTADOS[1]));

        $url['aceptar'] = URL::temporarySignedRoute(
            'pedido.aceptarCotizacion',
            now()->addMinutes(1440),
            ['pedido' => $pedido->id]
        );

        $url['rechazar'] = URL::temporarySignedRoute(
            'pedido.rechazarCotizacion',
            now()->addMinutes(1440),
            ['pedido' => $pedido->id]
        );

        try{
            Mail::to($pedido->cliente->email)
            ->send(new MailCotizacion($pedido, $url, $pedido->pedidoDetalle->diagnostico->serial));
        }
        catch(\Exception $e){ // Using a generic exception
            session()->flash('danger', 'Email no enviado!');
        }
        
        return redirect()->route('taller.index')
            ->with('success', 'Cotizacion actualizada!');

    }

    public function diagnosticoSalida(Request $request, $id)
    {
        //Hacer Informe Final

        $pedido = Pedido::find($id);

        $pedidoDetalle = $pedido->pedidoDetalle;

        $diagnostico = $this->createDiagnostico($request, $pedidoDetalle, $salida= 1);

        $pedido->revision->update([
            'diagnostico_id' => $diagnostico->id,
            'completado' => 1,
        ]);

        $pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre', 'TERMINADO')->first()->id,
        ]);

        event(new ProcesarNotificacion($pedido));

        try{
            Mail::to($pedido->cliente->email)
            ->send(new ServicioTerminado($pedido, $pedido->revision->diagnostico->serial, $nombre = 'Informe Final #'));
        }
        catch(\Exception $e){ // Using a generic exception
            session()->flash('danger', 'Email no enviado!');
        }

        return redirect()->route('taller.index')
            ->with('success', 'Pedido Terminado!');
    }

    public function createDiagnostico(Request $request, PedidoDetalle $pedidoDetalle, $salida){

        $cliente = Cliente::find($pedidoDetalle->pedido->cliente->id);
        $bicicleta = Bicicleta::find($pedidoDetalle->pedido->bicicleta->id);
        $mecanico = Empleado::find($pedidoDetalle->mecanico);
        $comentarioDiag = $request->input('comentarioMecanicoDiag');
        $color = $request->input('color');
        $inventario = $request->input('inventario');
        $partes = [];
        $partes2 = [];
        $parteId = $request->input('parteId', []);
        $parteNombre = $request->input('parteNombre', []);
        $porcentaje = $request->input('porcentaje', []);
        $comentario = $request->input('comentario', []);
        $parteId2 = $request->input('parteId2', []);
        $parteNombre2 = $request->input('parteNombre2', []);
        $detalle2 = $request->input('detalle2', []);
        $comentario2 = $request->input('comentario2', []);
        $diagnosticoCount = 1 + (count(Diagnostico::all()) ?? 0);
        $serial = 'DC-'. $diagnosticoCount . $cliente->id;
        $salida = $salida;
        $nombre = 'Diagnostico #';
        if ($salida == 1) {
            $nombre = 'Informe Final #';
        }



        for ($parteIndex = 0; $parteIndex < count($parteNombre); $parteIndex++) {
                $partes[$parteIndex] =
                    [
                        'nombre' => $parteNombre[$parteIndex] ?? '',
                        'porcentaje' => $porcentaje[$parteIndex] ?? '',
                        'comentario' => $comentario[$parteIndex] ?? '',
                    ];
        }
        for ($parteIndex = 0; $parteIndex < count($parteNombre2); $parteIndex++) {
            $partes2[$parteIndex] =
                [
                    'nombre' => $parteNombre2[$parteIndex] ?? '',
                    'detalle' => $detalle2[$parteIndex] ?? '',
                    'comentario' => $comentario2[$parteIndex] ?? '',
                ];
        }

        $data = array(
            'cliente' =>  ($cliente->nombre_apellido ?? ''),
            'bicicleta'=> ($bicicleta->marca ?? '') . ' ' . ($bicicleta->modelo ?? '') . ' ' . ($bicicleta->codigo ?? ''),
            'mecanico' => ($mecanico->nombre_apellido ?? ''),
            'color' => ($color ?? ''),
            'inventario' => ($inventario ?? ''),
            'comentarioDiag' => ($comentarioDiag ?? ''),
            'partes' => ($partes ?? ''),
            'partes2' => ($partes2 ?? ''),
            'vencimiento' => Carbon::tomorrow()->format('d/m/Y'),
            'serial' => $serial,
            'salida' => $salida
        );
        
        $diagnostico = Diagnostico::create([
            'mecanico' => $mecanico->id,
            'serial' => $serial,
            'bicicleta_id' => $bicicleta->id,
            'comentario' => $comentarioDiag,
            'data' => json_encode($data),
            'salida' => $salida
        ]);
        
        $pdf = PDF::loadView('PDF.diagnostico', $data)->setOptions(['defaultFont' => 'sans-serif','isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]) ;
        Storage::disk('local')->put('pdf/'. $nombre . $serial. '.pdf' ,$pdf->output());

        

        for ($parteIndex = 0; $parteIndex < count($parteId); $parteIndex++) {
            $parte = Parte::find($parteId[$parteIndex]);
                $parte->update(
                    [
                        'porcentaje' => $porcentaje[$parteIndex] ?? '',
                        'comentario' => $comentario[$parteIndex] ?? '',
                    ]
                );
        }

        for ($parteIndex = 0; $parteIndex < count($parteId2); $parteIndex++) {
            $parte = Parte::find($parteId2[$parteIndex]);
                $parte->update(
                    [
                        'detalle' => $detalle2[$parteIndex] ?? '',
                        'comentario' => $comentario2[$parteIndex] ?? '',
                    ]
                );
        }

        return $diagnostico;

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
                            'cantidad_pendiente' => $cantidad[$repuesto],
                            'cantidad' => $cantidad[$repuesto],
                            'precio_total' => $precio[$repuesto],
                            'precio_final' => $precio[$repuesto],
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
                $updateRepuestos[$repuesto_id];

                $cantidad = DB::table('pedido_detalle_repuesto')
                ->where('id',$updateID)->pluck('cantidad');

                $cantidad_pendiente = DB::table('pedido_detalle_repuesto')
                ->where('id',$updateID)->pluck('cantidad_pendiente');

                $cantidad_pendiente_final = $cantidad_pendiente[0] + ($updateRepuestos[$repuesto_id]['cantidad'] - $cantidad[0]);

                DB::table('pedido_detalle_repuesto')
                ->where('id',$updateID)->update([
                    'cantidad_pendiente' => $cantidad_pendiente_final,
                    'cantidad' => $updateRepuestos[$repuesto_id]['cantidad'],
                    'precio_total' => $updateRepuestos[$repuesto_id]['precio_total'],
                    'precio_final' => $updateRepuestos[$repuesto_id]['precio_final'],
                    'checked' => ($cantidad_pendiente_final === 0 ) ? true : false,
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
                            'cantidad_pendiente' => $cantidad[$servicio],
                            'cantidad' => $cantidad[$servicio],
                            'precio_total' => $precio[$servicio],
                            'precio_final' => $precio[$servicio],
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
                $updateServicios[$servicio_id];

                $cantidad = DB::table('pedido_detalle_servicio')
                ->where('id',$updateID)->pluck('cantidad');

                $cantidad_pendiente = DB::table('pedido_detalle_servicio')
                ->where('id',$updateID)->pluck('cantidad_pendiente');

                $cantidad_pendiente_final = $cantidad_pendiente[0] + ($updateServicios[$servicio_id]['cantidad'] - $cantidad[0]);

                DB::table('pedido_detalle_servicio')
                ->where('id',$updateID)->update([
                    'cantidad_pendiente' => $cantidad_pendiente_final,
                    'cantidad' => $updateServicios[$servicio_id]['cantidad'],
                    'precio_total' => $updateServicios[$servicio_id]['precio_total'],
                    'precio_final' => $updateServicios[$servicio_id]['precio_final'],
                    'checked' => ($cantidad_pendiente_final === 0 ) ? true : false,
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
                    $cantidad_final = $value->cantidad_pendiente + ($cantidad[$i] - $value->cantidad);
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
                        $item->cantidad_pendiente = $cantidad[$i];
                        $item->cantidad = $cantidad[$i];
                        $item->precio_total = $precio[$i];
                        $item->precio_final = $precio[$i];
                        $item->pedido_detalle_id = $pedidoDetalle->id;
                        $item->checked = false;
                        $result->push($item);
                    } else {
                        foreach ($paqueteObj->servicios as $key => $servicio) {
                            $item = new PedidoDetalleServicio();
                            $item->paquete_id = $idpaquetes[$i];
                            $item->servicio_id = $servicio->id;
                            $item->cantidad_pendiente = $cantidad[$i];
                            $item->cantidad = $cantidad[$i];
                            $item->precio_total = $precio[$i];
                            $item->precio_final = $precio[$i];
                            $item->pedido_detalle_id = $pedidoDetalle->id;
                            $item->checked = false;
                            $result->push($item);
                        }
                    }
                    
                }
            }
            
            PedidoDetalleServicio::where('pedido_detalle_id',$pedidoDetalle->id)->where('paquete_id','!=', null)->delete();
            
            if($result->isNotEmpty()){
                $result->each(function ($item, $key) {
                    $item->save();
                });
            }
            
            
        } else {
            PedidoDetalleServicio::where('pedido_detalle_id',$pedidoDetalle->id)->where('paquete_id','!=', null)->delete();
        }
    }

    public function findUserRole($empleado){
        if (empty($empleado)) {
            return true;
        } elseif ($empleado->user->hasRole('administrador')) {
            return true;
        } else {
            return false;
        }
    }
}
