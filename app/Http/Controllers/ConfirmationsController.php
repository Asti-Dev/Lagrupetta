<?php

namespace App\Http\Controllers;

use App\Mail\CotizacionRechazo;
use App\Mail\SolicitudRechazo;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class ConfirmationsController extends Controller
{
    public function generatePDF()
    {
          
        $pdf = PDF::loadView('pdf')->setOptions(['defaultFont' => 'sans-serif']);

        Storage::disk('local')->put('pdf/myfile2.pdf' ,$pdf->output());

        return 'hi';
        // return $pdf->download( 'Pedido #'. '.pdf');
    }

    public function aceptarSolicitud(Pedido $pedido, Request $request) 
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $pedido->update(
            ['confirmacion' => Pedido::ESTADOS[0]] +
            ['fecha_hora_confirmacion' => Carbon::now()->setTimezone('America/Lima')]
        );

        $data['etapa'] = 'solicitud';

        return view('respuesta.aceptar', $data);
    }

    public function rechazarSolicitud(Pedido $pedido, Request $request) 
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $pedido->update(
            ['confirmacion' => Pedido::ESTADOS[2]] +
            ['fecha_hora_confirmacion' => Carbon::now()->setTimezone('America/Lima')]
        );

        Mail::to($pedido->cliente->user->email)
            ->send(new SolicitudRechazo($pedido));

        $data['etapa'] = 'solicitud';

        return view('respuesta.rechazar', $data);

    }

    public function aceptarCotizacion(Pedido $pedido, Request $request) 
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $pedido->pedidoDetalle->update(
            ['confirmacion' => PedidoDetalle::ESTADOS[0]] +
            ['fecha_confirmacion' => Carbon::now()->setTimezone('America/Lima')]
        );

        $data['etapa'] = 'cotizacion';

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
            abort(401);
        }

        $servicioDiagnostico = Servicio::where('nombre', '=','Diagnostico de bicicleta')->first();
        $pedido->pedidoDetalle->paquetes()->detach();
        $pedido->pedidoDetalle->servicios()->detach();
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

        $data['etapa'] = 'cotizacion';

        return view('respuesta.rechazar', $data);

    }

    public function rechazarCotizacionManual(Pedido $pedido)
    {
        $servicioDiagnostico = Servicio::where('nombre', '=','Diagnostico de bicicleta')->first();
        $pedido->pedidoDetalle->paquetes()->detach();
        $pedido->pedidoDetalle->servicios()->detach();
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
