@extends('layouts.simple')
@section('content')
@switch($etapa ?? '')
    @case('solicitud')
    <div class="col text-center">
    <h1> El recojo de su bicicleta ya fue confirmado a las {{date('d/m/Y h:i A' ,strtotime( $fecha_confirmacion))}}</h1>
    <h2> Contacte a La Grupetta para poder modificar su pedido</h2>
    </div>

        @break
    @case('cotizacion')
    <div class="col text-center">
    <h1> Su pedido ya fue confirmado a las {{date('d/m/Y h:i A' ,strtotime( $fecha_confirmacion))}}</h1>
    <h2> Contacte a La Grupetta para poder modificar su pedido</h2>
    </div>
        @break
    @default
    <div class="col text-center">
    <h1> Su pedido fue rechazado a las {{date('d/m/Y h:i A' ,strtotime( $fecha_confirmacion))}}</h1>
    <h2> Contacte a La Grupetta para poder modificar su pedido</h2>
    </div>
@endswitch
@endsection