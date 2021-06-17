<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function sendMessage(Pedido $pedido){

        $whatsappUrl1= 'https://api.whatsapp.com/send?phone=51NUMBER&text=Hola%2C%20CLIENTE%0AHemos%20realizado%20el%20diagnostico%20a%20tu%20bicicleta%20%2ABICI%2A%20y%20estos%20son%20los%20servicios%20que%20te%20recomendamos.';
        
        $whatsappUrl2 = '%0A%0APrecio%20Total%3A%20%2APRECIOTOTAL%2A%0A%0AExplicacion%20del%20Mecanico%3A%20%2AEXPLICACION%2A%0A%0AAdjunto%20el%20diagnostico%20que%20se%20le%20hizo%20a%20tu%20bicicleta.%0A%0APor%20Favor%20confirmame%20lo%20antes%20posible.%20%F0%9F%98%81';

        $PaqueteUrlTitulo = '%0A%0A%2APaquetes%2A';
        $PaqueteUrlItem = '%0A%E2%9C%85%20NOMBREPAQUETE%20x%20CANTIDADPAQUETE%0APrecio%3A%20%2APRECIOPAQUETE%2A';
        $PaqueteUrlTotal = '';
        $ServicioUrlTitulo = '%0A%0A%2AServicios%20adicionales%2A';
        $ServicioUrlItem = '%0A%E2%9C%85%20NOMBRESERVICIO%20x%20CANTIDADSERVICIO%0APrecio%3A%2APRECIOSERVICIO%2A';
        $ServicioUrlTotal = '';
        $RepuestoUrlTitulo = '%0A%0A%2ARepuestos%2A';
        $RepuestoUrlItem = '%0A%E2%9C%85%20NOMBREREPUESTO%20x%20CANTIDADREPUESTO%0APrecio%3A%2APRECIOREPUESTO%2A';
        $RepuestoUrlTotal = '';

        $whatsappArray = [
            'NUMBER',
            'CLIENTE',
            'BICI',
            'PRECIOTOTAL',
            'EXPLICACION'
        ];

        $whatsappArrayPaquete =[
            'NOMBREPAQUETE',
            'CANTIDADPAQUETE',
            'PRECIOPAQUETE',
        ];
        $whatsappArrayServicio =[
            'NOMBRESERVICIO',
            'CANTIDADSERVICIO',
            'PRECIOSERVICIO',
        ];
        $whatsappArrayRepuesto =[
            'NOMBREREPUESTO',
            'CANTIDADREPUESTO',
            'PRECIOREPUESTO',
        ];

        $whatsappArrayRemplazo = [
            rawurlencode($pedido->cliente->telefono),
            rawurlencode($pedido->cliente->nombre),
            rawurlencode($pedido->bicicleta->marca . ' ' . $pedido->bicicleta->modelo),
            rawurlencode($pedido->pedidoDetalle->precio_total),
            rawurlencode($pedido->pedidoDetalle->explicacion),
        ];

        foreach ($pedido->pedidoDetalle->paquetes->unique() as $paquete) {
            $whatsappArrayPaqueteRemplazo = [
                rawurldecode($paquete->nombre),
                rawurldecode($paquete->pivot->cantidad),
                rawurldecode($paquete->pivot->precio_total)
            ];
            $PaqueteUrlTotal .= str_replace($whatsappArrayPaquete, $whatsappArrayPaqueteRemplazo, $PaqueteUrlItem);
        }
        foreach ($pedido->pedidoDetalle->servicios()->wherePivot('paquete_id', null)->get() as $servicio) {
            $whatsappArrayServicioRemplazo = [
                rawurldecode($servicio->nombre),
                rawurldecode($servicio->pivot->cantidad),
                rawurldecode($servicio->pivot->precio_total)
            ];
            $ServicioUrlTotal .= str_replace($whatsappArrayServicio, $whatsappArrayServicioRemplazo, $ServicioUrlItem);
        }

        foreach ($pedido->pedidoDetalle->repuestos as $repuesto) {
            $whatsappArrayRepuestoRemplazo = [
                rawurldecode($repuesto->nombre),
                rawurldecode($repuesto->pivot->cantidad),
                rawurldecode($repuesto->pivot->precio_total)
            ];
            $RepuestoUrlTotal .= str_replace($whatsappArrayRepuesto, $whatsappArrayRepuestoRemplazo, $RepuestoUrlItem);
        }

        $whatsappUrl = $whatsappUrl1 . $PaqueteUrlTitulo . $PaqueteUrlTotal . $ServicioUrlTitulo . $ServicioUrlTotal . $RepuestoUrlTitulo . $RepuestoUrlTotal . $whatsappUrl2;

        $linkUrl = str_replace($whatsappArray, $whatsappArrayRemplazo, $whatsappUrl);

        return redirect()->away($linkUrl);
    }
}
