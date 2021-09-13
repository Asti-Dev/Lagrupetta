<?php

namespace App\Http\Controllers;

use App\Mail\CotizacionRechazo;
use App\Mail\SolicitudRechazo;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\PedidoEstado;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class ConfirmationsController extends Controller
{

    public function aceptarSolicitud(Pedido $pedido, Request $request) 
    {
        if (! $request->hasValidSignature()) {
            return view('respuesta.aceptar');
        }

        $pedido->update(
            ['pedido_estado_id' => PedidoEstado::where('nombre', 'EN RUTA RECOJO')->first()->id] +
            ['confirmacion' => Pedido::ESTADOS[0]] +
            ['fecha_hora_confirmacion' => Carbon::now()->setTimezone('America/Lima')]
        );

        $data['etapa'] = 'solicitud';

        return view('respuesta.aceptar', $data);
    }

    public function rechazarSolicitud(Pedido $pedido, Request $request) 
    {
        if (! $request->hasValidSignature()) {
            return view('respuesta.rechazar');
        }

        $data['etapa'] = 'solicitud';

        if($pedido->confirmacion == Pedido::ESTADOS[0]){
            $data['fecha_confirmacion'] = $pedido->fecha_hora_confirmacion;
            return view('respuesta.info', $data);
        }

        $pedido->update(
            ['confirmacion' => Pedido::ESTADOS[2]] +
            ['fecha_hora_confirmacion' => Carbon::now()->setTimezone('America/Lima')]
        );

        Mail::to($pedido->cliente->user->email)
            ->send(new SolicitudRechazo($pedido));

        

        return view('respuesta.rechazar', $data);

    }

    public function aceptarCotizacion(Pedido $pedido, Request $request) 
    {
        if (! $request->hasValidSignature()) {
            return view('respuesta.aceptar');
        }
        
        
        if($pedido->pedidoDetalle->confirmacion == PedidoDetalle::ESTADOS[2]){
            $data['fecha_confirmacion'] = $pedido->pedidoDetalle->updated_at;
            return view('respuesta.info', $data);
        }

        $data['etapa'] = 'cotizacion';

        $pedido->pedidoDetalle->update(
            ['confirmacion' => PedidoDetalle::ESTADOS[0]] +
            ['fecha_confirmacion' => Carbon::now()->setTimezone('America/Lima')]
        );

        
        return view('respuesta.aceptar', $data);
    }

    public function aceptarCotizacionManual(Pedido $pedido)
    {
        $pedido->pedidoDetalle->update(
            ['confirmacion' => PedidoDetalle::ESTADOS[0]] +
            ['fecha_confirmacion' => Carbon::now()->setTimezone('America/Lima')]
        );

        return redirect()->route('pedidos.index')
            ->with('success', 'Cotizacion Aceptada!');
    }

    public function rechazarCotizacion(Pedido $pedido, Request $request) 
    {
        if (! $request->hasValidSignature()) {
            return view('respuesta.rechazar');
        }

        $data['etapa'] = 'cotizacion';

        if($pedido->pedidoDetalle->confirmacion == PedidoDetalle::ESTADOS[0]){
            $data['fecha_confirmacion'] = $pedido->pedidoDetalle->fecha_confirmacion;
            return view('respuesta.info', $data);
        }

        $servicioDiagnostico = Servicio::where('nombre', '=','Diagnostico de bicicleta')->first();
        $pedido->pedidoDetalle->paquetes()->detach();
        $pedido->pedidoDetalle->servicios()->detach();
        $pedido->pedidoDetalle->repuestos()->detach();

        $pedido->pedidoDetalle->servicios()->attach($servicioDiagnostico->id,
        [
            'cantidad_pendiente' => 0,
            'cantidad' => 1,
            'precio_total' => $servicioDiagnostico->precio,
            'precio_final' => $servicioDiagnostico->precio,

        ]
        );
        $pedido->pedidoDetalle->update([
            'precio_total' => $servicioDiagnostico->precio,
            'precio_final' => $servicioDiagnostico->precio,
            'confirmacion' => PedidoDetalle::ESTADOS[2],
            ['fecha_confirmacion' => Carbon::now()->setTimezone('America/Lima')]

        ]);
        
        Mail::to($pedido->cliente->user->email)
            ->send(new CotizacionRechazo($pedido));

        

        return view('respuesta.rechazar', $data);

    }

    public function rechazarCotizacionManual(Pedido $pedido)
    {
        $servicioDiagnostico = Servicio::where('nombre', '=','Diagnostico de bicicleta')->first();
        $pedido->pedidoDetalle->paquetes()->detach();
        $pedido->pedidoDetalle->servicios()->detach();
        $pedido->pedidoDetalle->repuestos()->detach();

        $pedido->pedidoDetalle->servicios()->attach($servicioDiagnostico->id,
        [
            'cantidad_pendiente' => 0,
            'cantidad' => 1,
            'precio_total' => $servicioDiagnostico->precio,
            'precio_final' => $servicioDiagnostico->precio,

        ]
        );
        $pedido->pedidoDetalle->update([
            'precio_total' => $servicioDiagnostico->precio,
            'precio_final' => $servicioDiagnostico->precio,
            'confirmacion' => PedidoDetalle::ESTADOS[2],
            'fecha_confirmacion' => Carbon::now()->setTimezone('America/Lima')

        ]);
        try {
            Mail::to($pedido->cliente->user->email)
            ->send(new CotizacionRechazo($pedido));
        } catch (\Exception $e) {
            session()->flash('danger', 'Email no enviado!');
        }


        return redirect()->route('pedidos.index')
            ->with('success', 'Cotizacion Rechazada!');
    }
}
