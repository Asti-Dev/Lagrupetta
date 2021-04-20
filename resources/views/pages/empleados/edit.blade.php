@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Actualizar empleado</h2>
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
        <form class="col-5"  action="{{ route('empleados.update', $empleado->id ) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre_apellido">Nombre Completo</label>
                <input type="text" class="form-control item" name="nombre_apellido" id="nombre_apellido" value="{{$empleado->nombre_apellido}}">
            </div>
            <div class="row">
            <div class="col form-group">
                <label for="telefono">Telefono</label>
                <input type="text" class="form-control item" name="telefono" id="telefono" value="{{$empleado->telefono}}">
            </div>
            <div class="col form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control item" name="email" id="email" value="{{$empleado->user->email}}">
            </div>
            </div>
            <div class="form-group">
                <label for="cargo">Cargo</label>
                <select class="form-control" name="cargo" id="cargo">
                    <option value="">Escoge un Documento</option>
                    @foreach ($roles as $rol)
                    @if ($rol->name === $empleado->cargo)
                    <option value="{{$rol->name}}" selected>{{$rol->name}}</option>
                    @else
                    <option value="{{$rol->name}}">{{$rol->name}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="row">
            <div class="col form-group">
                <label for="tipo_doc">Tipo de Documento</label>
                <select class="form-control" name="tipo_doc" id="tipo_doc">
                    <option value="">Escoge un Documento</option>
                    @foreach ($tipoDoc as $doc)
                    @if ($doc === $empleado->tipo_doc)
                    <option value="{{$doc}}" selected>{{$doc}}</option>
                    @else
                    <option value="{{$doc}}">{{$doc}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col form-group">
                <label for="nro_doc">Número de Documento</label>
                <input type="text" class="form-control item" name="nro_doc" id="nro_doc" value="{{$empleado->nro_doc}}">
            </div>
            </div>
            <div class="form-group">
                <label for="fecha_cumpleanos">Fecha de Cumpleaños</label>
                <input type="date" id="fecha_cumpleanos"
                       name="fecha_cumpleanos" value="{{$empleado->fecha_cumpleanos}}"
                        class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
@endsection
