@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Actualizar Cliente</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('clientes.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
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
    <div class="row d-flex justify-content-center align-items-center">
        <form class="col-md-10 d-flex flex-column align-items-center" action="{{ route('clientes.update', $cliente->id ) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="w-100 d-flex flex-column flex-md-row justify-content-around">
            <div>
                <h4>Cliente</h4>
            <div class="row">
                <div class="col form-group">
                    <label for="nombre_apellido">Nombre Completo</label>
                    <input type="text" class="form-control item" name="nombre_apellido" id="nombre_apellido" value="{{$cliente->nombre_apellido}}">
                </div>
            </div>
            <div class="row">
            <div class="col form-group">
                <label for="telefono">Telefono</label>
                <input type="text" class="form-control item" name="telefono" id="telefono" value="{{$cliente->telefono}}">
            </div>
            <div class="col form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control item" name="email" id="email" value="{{$cliente->email}}">
            </div>
            </div>
            <div class="row">
                <div class="col form-group">
                    <label for="distrito">Distrito</label>
                    <select class="form-control" name="distrito" id="distrito">
                        <option value="">Escoge un Distrito</option>
                        @foreach ($distritos as $distrito)
                        @if ($distrito === $cliente->distrito)
                        <option value="{{$distrito}}" selected>{{$distrito}}</option>
                        @else
                        <option value="{{$distrito}}">{{$distrito}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="col form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control item" name="direccion" id="direccion" value="{{$cliente->direccion}}">
                </div>
            </div>
            <div class="row">
            <div class="col form-group">
                <label for="tipo_doc">Tipo de Documento</label>
                <select class="form-control" name="tipo_doc" id="tipo_doc">
                    <option value="">Escoge un Documento</option>
                    @foreach ($tipoDoc as $doc)
                    @if ($doc === $cliente->tipo_doc)
                    <option value="{{$doc}}" selected>{{$doc}}</option>
                    @else
                    <option value="{{$doc}}">{{$doc}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col form-group">
                <label for="nro_doc">Número de Documento</label>
                <input type="text" class="form-control item" name="nro_doc" id="nro_doc" value="{{$cliente->nro_doc}}">
            </div>
            </div>
            <div class="form-group">
                <label for="medio_llegada">Medios de Llegada</label>
                <select class="form-control" name="medio_llegada" id="medio_llegada">
                    <option value="">Escoge un medio de llegada</option>
                    @foreach ($llegadas as $llegada)
                    @if ($llegada === $cliente->medio_llegada)
                    <option value="{{$llegada}}" selected>{{$llegada}}</option>
                    @else
                    <option value="{{$llegada}}">{{$llegada}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_cumpleanos">Fecha de Cumpleaños</label>
                <input type="date" id="fecha_cumpleanos"
                       name="fecha_cumpleanos" value="{{$cliente->fecha_cumpleanos}}"
                        class="form-control">
            </div>
            </div>
            <livewire:bicicleta.edit-bicicleta-cliente :bicicletas='$cliente->bicicletas'>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
@endsection
