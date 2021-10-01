@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Actualizar Bicicleta de : {{$cliente->nombre_apellido}}</h2>
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
        <form class="col-5"  action="{{ route('bicicletas.update', $bicicleta->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" class="form-control item" name="marca" id="marca" value="{{$bicicleta->marca}}">
            </div>
            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" class="form-control item" name="modelo" id="modelo" value="{{$bicicleta->modelo}}">
            </div>
            <div class="form-group">
                <label for="color">Color</label>
                <input type="text" class="form-control item" name="color" id="color" value="{{$bicicleta->color ?? ''}}">
            </div>
            <div class="form-group">
                <label for="codigo">Codigo</label>
                <input type="text" class="form-control item" name="codigo" id="codigo" value="{{$bicicleta->codigo ?? ''}}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
@endsection

