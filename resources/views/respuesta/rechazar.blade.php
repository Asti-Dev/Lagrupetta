@extends('layouts.simple')
@section('content')

@switch($etapa ?? '')
    @case('solicitud')

    <h1> El recojo de su bicicleta ha sido rechazado</h1>

        @break
    @case('cotizacion')

    <h1> Su pedido ha sido rechazado</h1>

        @break
    @default
    <h1> El tiempo de respuesta a expirado. </h1>
@endswitch

@endsection