@extends('layouts.app')


@section('content')
    <div class="row">
            <div class="">
                <a class="btn btn-primary" href="{{ route('empleados.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
            </div>
            <div class="col">
                <h2> empleado: {{ $empleado->nombre_apellido }}</h2>
            </div>
    </div>

    <div class="row p-3 mt-1" style="background: lightblue">
        <div class="col-4">
            <div class="form-group">
                <strong>Telefono:</strong>
                {{ $empleado->telefono }}
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <strong>Cargo:</strong>
                {{ $empleado->cargo }}
            </div>
        </div>
    </div>

@endsection
