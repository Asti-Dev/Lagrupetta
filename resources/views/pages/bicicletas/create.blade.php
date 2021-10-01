@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Añadir Bicicleta a: {{$cliente->nombre_apellido}}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('clientes.show', ['cliente' => $cliente->id]) }}" title="Go back"> <i class="fas fa-backward "></i> </a>
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
    <div class="row d-flex justify-content-center">
        <form class="col-5"  action="{{ route('bicicletas.store', ['clienteId' => $cliente->id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" class="form-control item" name="marca" id="marca" placeholder="marca">
            </div>
            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" class="form-control item" name="modelo" id="modelo" placeholder="modelo">
            </div>
            <div class="form-group">
                <label for="color">Color</label>
                <input type="text" class="form-control item" name="color" id="color" placeholder="color">
            </div>
            <div class="form-group">
                <label for="codigo">Codigo</label>
                <input type="text" class="form-control item" name="codigo" id="codigo" placeholder="codigo">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Crear</button>
            </div>
        </form>
    </div>
@endsection
