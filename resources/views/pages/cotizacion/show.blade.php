@extends('layouts.app')

@section('content')
<div class="row">
    <div class="">
        <a class="btn btn-primary" href="{{ route('pedidos.index') }}" title="Go back"> <i class="fas fa-backward "></i>
        </a>
    </div>
    <div class="col">
        <h2> Pedido #{{ $pedido->id }}</h2>
    </div>
</div>

<div class="row p-3 my-3">
    <div class="col-sm-6">
        <div class="col px-5 py-3" style="background: lightblue">
            <div class="form-group d-flex justify-content-between">
                <strong>Cliente:</strong>
                <p class="text-right">{{ ($pedido->cliente->nombre .' '. $pedido->cliente->apellido) ?? '' }}</p>
            </div>
            <div class="form-group d-flex justify-content-between">
                <strong>Bicicleta:</strong>
                <p class="text-right">{{ ($pedido->bicicleta->marca . ' ' . $pedido->bicicleta->modelo) ?? ''}}</p>
            </div>
            <div class="form-group d-flex justify-content-between">
                <strong>Chofer:</strong>
                <p class="text-right">{{$pedido->transporteRecojo()->choferTransporte->nombre_apellido ?? ''}}</p>
            </div>
            <div class="form-group d-flex justify-content-between">
                <strong>Telefono:</strong>
                <p class="text-right">{{ $pedido->cliente->telefono ?? ''  }}</p>
            </div>
            <div class="form-group d-flex justify-content-between">
                <strong>Direccion:</strong>
                <p class="text-right">{{ $pedido->cliente->direccion ?? ''  }}</p>
            </div>
            <div class="form-group d-flex justify-content-between">
                <strong>Fecha de Recojo:</strong>
                <p class="text-right">{{ $pedido->transporteRecojo()->fecha_hora_completado ?? ''  }}</p>
            </div>
            <div class="form-group d-flex justify-content-between">
                <strong>LLegada al Taller:</strong>
                <p class="text-right">{{ $pedido->transporteRecojo()->fecha_hora_local ?? ''  }}</p>
            </div>
            <div class="form-group d-flex justify-content-between">
                <strong>Mecanico:</strong>
                <p class="text-right"> {{ $pedido->pedidoDetalle->mecanicoUno->nombre_apellido ?? ''  }} </p>
            </div>
            <div class="form-group d-flex justify-content-between">
                <strong>Direccion:</strong>
                <p class="text-right">{{ $pedido->cliente->direccion ?? ''  }}</p>
            </div>
            <div class="form-group d-flex justify-content-between">
                <strong>Fecha de Entrega:</strong>
                <p class="text-right">{{ $pedido->pedidoDetalle->fecha_entrega_aprox ?? ''  }}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="d-flex flex-column">
            <a href="{{route('pedido.aceptarCotizacionManual', ['pedido' => $pedido->id])}}"
                class="mx-4 mb-1 btn btn-success btn-sm">Aceptar Cotizacion</a>

            <a href="{{route('pedido.rechazarCotizacionManual', ['pedido' => $pedido->id])}}"
                class="mx-4 mb-1 btn btn-danger btn-sm">Rechazar Cotizacion</a>

            <a href="{{route('cotizacion.edit', $pedido->pedidoDetalle->id)}}"
                class="mx-4 mb-1 btn btn-primary btn-sm">Reenviar Cotizacion</a>

            <a target="_blank" href="{{route('whatsapp.sendMessage', ['pedido' => $pedido->id])}}"
                    class="mx-4 mb-1 btn btn-success btn-sm">Enviar Whatsapp</a>
            
        </div>
        @if ($pedido->pedidoDetalle->paquetes)
        <div class="card w-100">
            <div class="card-header">
                Paquetes
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($pedido->pedidoDetalle->paquetes->unique() as $paquete)
                <li class="list-group-item"> {{$paquete->nombre}}
                    <ul class="list-group list-group-flush">
                        @foreach ($paquete->servicios as $paquete_servicio)
                        <li class="list-group-item">
                            <div class="d-flex row w-100 justify-content-between align-items-center">
                                <div class="col-9">
                                    <label class="m-1">{{ $paquete_servicio->nombre }}  x 
                                        {{$paquete_servicio->pedidoDetalles
                                            ->where('id',$pedido->pedidoDetalle->id)
                                            ->where('pivot.paquete_id',$paquete->id)
                                            ->first()->pivot->cantidad}}
                                    </label>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        @if ($pedido->pedidoDetalle->servicios)
        <div class="card w-100">
            <div class="card-header">
                Servicios Adicionales
            </div>
            <ul class="list-group list-group-flush">
                @foreach($pedido->pedidoDetalle->servicios()
                ->wherePivot('paquete_id', null)->get() as $key => $servicio)
                <li class="list-group-item">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="col-9">
                            <label class="m-1">{{ $servicio->nombre }} x {{$servicio->pivot->cantidad}}
                            </label>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>


@endsection