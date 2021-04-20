@extends('layouts.app')


@section('content')
    <div class="row">
            <div class="">
                <a class="btn btn-primary" href="{{ route('pedidos.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
            </div>
            <div class="col">
                <h2> Pedido #{{ $pedido->id }}</h2>
            </div>
    </div>

    <div class="row p-3 my-3" >
        <div class="col-sm-6" >
            <div class="col px-5 py-3" style="background: lightblue">
                <div class="form-group d-flex justify-content-between">
                    <strong>Cliente:</strong>
                    <p class="text-right">{{ $pedido->solicitud->cliente->nombre_apellido ?? '' }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Bicicleta:</strong>
                    <p class="text-right">{{$pedido->solicitud->bicicleta->marca . ' ' . $pedido->solicitud->bicicleta->modelo ?? ''}}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Chofer:</strong>
                    <p class="text-right">{{ $pedido->solicitud->elchofer->nombre_apellido ?? ''  }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Telefono:</strong>
                    <p class="text-right">{{ $pedido->solicitud->cliente->telefono ?? ''  }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Direccion:</strong>
                    <p class="text-right">{{ $pedido->solicitud->cliente->direccion ?? ''  }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Fecha de Recojo:</strong>
                    <p class="text-right">{{ $pedido->solicitud->fecha_recojo ?? ''  }}</p>
                </div>
                @if(!empty($pedido->fecha_entaller))
                <div class="form-group d-flex justify-content-between">
                    <strong>LLegada al Taller:</strong>
                    <p class="text-right">{{ $pedido->fecha_entaller ?? ''  }}</p>
                </div>
                @endif
                @if(!empty($pedido->pedidodetalle->mecanico()->first()->nombre_apellido))
                <div class="form-group d-flex justify-content-between">
                    <strong>Mecanico:</strong>
                    <p class="text-right">{{ $pedido->pedidodetalle->mecanico()->first()->nombre_apellido ?? ''  }}</p>
                </div>
                @endif
                @if(!empty($pedido->choferEntrega()->first()->nombre_apellido))
                <div class="form-group d-flex justify-content-between">
                    <strong>Chofer Entrega:</strong>
                    <p class="text-right">{{ $pedido->choferEntrega()->first()->nombre_apellido ?? ''  }}</p>
                </div>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Hubo un problema con los datos ingresados<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <livewire:pedido.update-entrega-form :pedido='$pedido'>

        </div>
    </div>


@endsection