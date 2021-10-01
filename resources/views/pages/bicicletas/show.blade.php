@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Bicicleta:</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('clientes.show', ['cliente' => $bicicleta->cliente->id]) }}" title="Go back"> <i class="fas fa-backward "></i> </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col d-flex flex-column justify-content-around">
            <div class="d-flex flex-column">
                <div class="form-group">
                    <strong>Marca:</strong>
                    {{ $bicicleta->marca }}
                </div>
                <div class="form-group">
                    <strong>Modelo:</strong>
                    {{ $bicicleta->modelo }}
                </div>
                <div class="form-group">
                    <strong>Color:</strong>
                    {{ $bicicleta->color }}
                </div>
                <div class="form-group">
                    <strong>Codigo:</strong>
                    {{ $bicicleta->codigo ?? '' }}
                </div>
            </div>
            @if ($bicicleta->diagnosticos)
                <livewire:bicicleta.diagnosticos :bicicleta="$bicicleta" />
            @endif
        </div>
        <div class="col">
            <livewire:bicicleta.partes :bicicleta="$bicicleta"/>           
        </div>
    </div>
@endsection
