@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="my-3">
                <h2>Pedidos </h2>
            </div>
            <div class="d-flex align-items-strech my-1">
                 <a class="btn btn-success" href="{{ route('pedidos.create') }}" title="Crear solicitud">
                    Nuevo
                </a>
                <a class="btn btn-success" href="{{ route('pedidos.index') }}">
                    Limpiar
                </a>
            </div>
        </div>
    </div>
    

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <livewire:pedido.table>


@endsection
