@extends('layouts.simple')
@section('content')
@switch($etapa)
    @case('solicitud')

    <h1> El recojo de su bicicleta ha sido confirmado</h1>

        @break
    @case('cotizacion')

    <h1> Su pedido ha sido confirmado</h1>

        @break
    @default
    <h1> Error</h1>
@endswitch
@endsection