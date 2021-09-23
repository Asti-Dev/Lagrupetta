@extends('layouts.app')

@section('content')
<div class="row">
    <div class="">
        <a class="btn btn-primary" href="{{ route('cobranza.index') }}" title="Go back"> <i class="fas fa-backward "></i>
        </a>
    </div>
    <div class="col">
        <h2> Pedido #{{ $pedido->id }}</h2>
    </div>
</div>

<div class="row p-3 my-3">
    <div class="col-sm-6">
        <livewire:pedido.pedido-detalle.cotizacion.cotizacion-edit2 :pedido="$pedido->id">
    </div>
    <div class="col-sm-6">
        <div class="d-flex flex-column">
            <a target="_blank" href="{{route('whatsapp.sendMessage', ['pedido' => $pedido->id])}}"
                    class="mx-4 mb-1 btn btn-success btn-sm">Enviar Whatsapp</a>
            
        </div>
        <div class="px-3 pt-3"><h5> Precio total : S/. {{$pedido->pedidoDetalle->precio_total}}</h3></div>
        @if ($pedido->pedidoDetalle->paquetes)
        <div class="card w-100">
            <div class="card-header">
                Paquetes 
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($pedido->pedidoDetalle->paquetes->unique() as $paquete)
                <li class="list-group-item"> {{$paquete->nombre}} x {{$paquete->pivot->cantidad}} <b>Precio: S/. {{$paquete->pivot->precio_total}}</b>
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
                            <label class="m-1">{{ $servicio->nombre }} x {{$servicio->pivot->cantidad}} <b>Precio: S/. {{$servicio->pivot->precio_total}}</b>
                            </label>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        @if ($pedido->pedidoDetalle->repuestos)
        <div class="card w-100">
            <div class="card-header">
                Repuestos
            </div>
            <ul class="list-group list-group-flush">
                @foreach($pedido->pedidoDetalle->repuestos as $key => $repuesto)
                <li class="list-group-item">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="col-9">
                            <label class="m-1">{{ $repuesto->nombre }} x {{$repuesto->pivot->cantidad}} <b>Precio: S/. {{$repuesto->pivot->precio_total}}</b>
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