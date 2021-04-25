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
        <livewire:pedido.asignar-entrega-chofer :pedido='$pedido'>

        </div>
    </div>


@endsection