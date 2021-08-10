<?php

namespace App\Http\Controllers;

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
use App\Models\PedidoEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class CotizacionController extends Controller
{
    public function show($pedidoId)
    {
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
        $pedidoDetalle = PedidoDetalle::find($pedidoDetalleId);
        $pedido = Pedido::find($pedidoDetalle->pedido->id);
        $diagnostico = Diagnostico::find($pedidoDetalle->diagnostico->id);


        $url['aceptar'] = URL::temporarySignedRoute(
            'pedido.aceptarCotizacion',
            now()->addMinutes(300),
            ['pedido' => $pedido->id]
        );

        $url['rechazar'] = URL::temporarySignedRoute(
            'pedido.rechazarCotizacion',
            now()->addMinutes(300),
            ['pedido' => $pedido->id]
        );

        try{
            Mail::to($pedido->cliente->email)
            ->send(new MailCotizacion($pedido, $url, $diagnostico->serial));
        }
        catch(\Exception $e){ // Using a generic exception
            session()->flash('danger', 'Email no enviado!');
        }


        return redirect()->route('pedidos.index')
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

        $url['aceptar'] = URL::temporarySignedRoute(
            'pedido.aceptarCotizacion',
            now()->addMinutes(300),
            ['pedido' => $pedido->id]
        );

        $url['rechazar'] = URL::temporarySignedRoute(
            'pedido.rechazarCotizacion',
            now()->addMinutes(300),
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
        $pedidoDetalle = PedidoDetalle::find($pedidoDetalleId);

        $request->validate([
            'fecha_entrega' => 'required',
            'explicacion' => 'required',
        ]);
        $pedido = Pedido::find($pedidoDetalle->pedido->id);

        $pedidoDetalle->paquetes()->detach();

        $pedidoDetalle->servicios()->detach();

        $pedidoDetalle->repuestos()->detach();

        $this->insertarRepuestos($request, $pedidoDetalle);

        $this->insertarServicios($request, $pedidoDetalle);

        $this->insertarPaquetes($request, $pedidoDetalle);

        $pedido->pedidoDetalle->update([
            'explicacion' => $request->input('explicacion'),
            'fecha_entrega_aprox' => $request->input('fecha_entrega'),
            'precio_total' => $request->input('total_precio'),
            'precio_final' => $request->input('total_precio'),
            'confirmacion' => PedidoDetalle::ESTADOS[1],
        ]);

        $url['aceptar'] = URL::temporarySignedRoute(
            'pedido.aceptarCotizacion',
            now()->addMinutes(300),
            ['pedido' => $pedido->id]
        );

        $url['rechazar'] = URL::temporarySignedRoute(
            'pedido.rechazarCotizacion',
            now()->addMinutes(300),
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

    public function diagnosticoSalida(Request $request, $id){

        $pedidoDetalle = PedidoDetalle::find($id);

        $pedido = Pedido::find($pedidoDetalle->pedido->id);

        $diagnostico = $this->createDiagnostico($request, $pedidoDetalle, $salida= 1);

        $diagnostico->update([
            'salida' => 1
        ]);

        $pedido->revision->update([
            'diagnostico_id' => $diagnostico->id,
            'completado' => 1,
        ]);

        $pedido->update([
            'pedido_estado_id' => PedidoEstado::where('nombre', 'TERMINADO')->first()->id,
        ]);

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
        
        $pdf = PDF::loadView('PDF.diagnostico', $data)->setOptions(['defaultFont' => 'sans-serif']);
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

            for ($repuesto = 0; $repuesto < count($idrepuestos); $repuesto++) {
                if ($idrepuestos[$repuesto] != '') {
                    $pedidoDetalle->repuestos()->attach(
                        $idrepuestos[$repuesto],
                        [
                            'cantidad_pendiente' => $cantidad[$repuesto],
                            'cantidad' => $cantidad[$repuesto],
                            'precio_total' => $precio[$repuesto],
                            'precio_final' => $precio[$repuesto],

                        ]
                    );
                }
            }
        }
    }

    public function insertarServicios(Request $request, PedidoDetalle $pedidoDetalle)
    {
        if ($request->input('idservicios', [])) {
            $idservicios = $request->input('idservicios', []);
            $cantidad = $request->input('cantidadservicio', []);
            $precio = $request->input('precioservicio', []);

            for ($servicio = 0; $servicio < count($idservicios); $servicio++) {
                if ($idservicios[$servicio] != '') {
                    $pedidoDetalle->servicios()->attach(
                        $idservicios[$servicio],
                        [
                            'cantidad_pendiente' => $cantidad[$servicio],
                            'cantidad' => $cantidad[$servicio],
                            'precio_total' => $precio[$servicio],
                            'precio_final' => $precio[$servicio],

                        ]
                    );
                }
            }
        }
    }

    public function insertarPaquetes(Request $request, PedidoDetalle $pedidoDetalle)
    {
        if ($request->input('idpaquetes', [])) {
            $idpaquetes = $request->input('idpaquetes', []);
            $cantidad = $request->input('cantidadpaquete', []);
            $precio = $request->input('preciopaquete', []);

            for ($paquete = 0; $paquete < count($idpaquetes); $paquete++) {
                if ($idpaquetes[$paquete] != '') {
                    $paqueteObj = Paquete::find($idpaquetes[$paquete]);
                    if (!empty($paqueteObj->servicios()->get()[0])) {
                        foreach ($paqueteObj->servicios()->get() as $servicio) {
                            $pedidoDetalle->paquetes()->attach(
                                $idpaquetes[$paquete],
                                [
                                    'servicio_id' => $servicio->id,
                                    'cantidad_pendiente' => $cantidad[$paquete],
                                    'cantidad' => $cantidad[$paquete],
                                    'precio_total' => $precio[$paquete],
                                    'precio_final' => $precio[$paquete],

                                ]
                            );
                        }
                    } else {
                        $pedidoDetalle->paquetes()->attach(
                            $idpaquetes[$paquete],
                            [
                                'cantidad_pendiente' => $cantidad[$paquete],
                                'cantidad' => $cantidad[$paquete],
                                'precio_total' => $precio[$paquete],
                                'precio_final' => $precio[$paquete],
                            ]
                        );
                    }
                }
            }
        }
    }
}
