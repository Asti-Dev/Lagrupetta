@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="my-3">
                <h2>Pedidos </h2>
            </div>
        </div>
    </div>
    

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    @hasanyrole('administrador|super-admin')


    <livewire:pedido.table>

    @endhasanyrole

@endsection
