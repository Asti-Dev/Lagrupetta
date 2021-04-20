@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Añadir Empleado</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('empleados.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
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
        <form class="col-5"  action="{{ route('empleados.store') }}" method="POST">
            @csrf
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
            <div class="form-group">
                <label for="cargo">Cargo</label>
                <select class="form-control" name="cargo" aria-label="">
                    <option value="">Escoge un Cargo</option>
                    @foreach ($roles as $rol)
                    <option value="{{$rol->name}}">{{$rol->name}}</option>
                    @endforeach
                  </select>
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
                <label for="fecha_cumpleanos">Fecha de Cumpleaños</label>
                <input type="date" name="fecha_cumpleanos" id="fecha_cumpleanos" class="form-control" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Crear</button>
            </div>
        </form>
    </div>
@endsection
