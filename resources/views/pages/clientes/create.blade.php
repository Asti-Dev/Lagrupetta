@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Añadir Cliente</h2>
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
        <form class="col-md-10 d-flex flex-column align-items-center"  action="{{ route('clientes.store') }}" method="POST">
            @csrf
            <div class="w-100 d-flex flex-column flex-md-row justify-content-around">
            <div>
                <h4>Cliente</h4>
                <div class="row">
                    <div class="col form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control item" name="nombre" id="nombre">
                    </div>
                    <div class="col form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control item" name="apellido" id="apellido">
                    </div>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="telefono">Telefono</label>
                        <input type="tel" class="form-control item" name="telefono" id="telefono">
                    </div>
                    <div class="col form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control item" name="email" id="email">
                    </div>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="distrito">Distrito</label>
                        <select class="form-control" name="distrito" id="distrito">
                            <option value="">Escoge un Distrito</option>
                            @foreach ($distritos as $distrito)
                            <option value="{{$distrito}}">{{$distrito}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control item" name="direccion" id="direccion">
                    </div>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="tipo_doc">Tipo de Documento</label>
                        <select class="form-control" name="tipo_doc" id="tipo_doc">
                            <option value="">Escoge un Documento</option>
                            @foreach ($tipoDoc as $doc)
                            <option value="{{$doc}}">{{$doc}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col form-group">
                        <label for="nro_doc">Número de Documento</label>
                        <input type="text" class="form-control item" name="nro_doc" id="nro_doc">
                    </div>
                </div>
                <div class="form-group">
                    <label for="medio_llegada">Medios de Llegada</label>
                    <select class="form-control" name="medio_llegada" id="medio_llegada">
                        <option value="">Escoge un medio de llegada</option>
                        @foreach ($llegadas as $llegada)
                        <option value="{{$llegada}}">{{$llegada}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="fecha_cumpleanos">Fecha de Cumpleaños</label>
                    <input type="date" name="fecha_cumpleanos" id="fecha_cumpleanos" class="form-control" />
                </div>
            </div>
            <div>
                <h4>Bicicleta</h4>

                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" class="form-control item" name="marca" id="marca" placeholder="marca">
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" class="form-control item" name="modelo" id="modelo" placeholder="modelo">
                </div>
                <div class="form-group">
                    <label for="codigo">Codigo</label>
                    <input type="text" class="form-control item" name="codigo" id="codigo" placeholder="codigo">
                </div>
            </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Crear</button>
            </div>
        </form>
    </div>
@endsection
