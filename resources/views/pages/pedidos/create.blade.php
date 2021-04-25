@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Añadir Pedido</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('pedidos.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
                
                <a class="btn btn-primary"     
                onclick="window.open('{{route('quickClient')}}', 
                'newwindow', 
                'width=500,height=500'); 
                return false;"
                href="#"> Nuevo Cliente </a>
            </div>
        </div>
    </div>

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
    
    <livewire:pedido.form />
    
@endsection
