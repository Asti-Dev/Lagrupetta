@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="my-3">
                <h2>Empleados </h2>
            </div>
            <div class="d-flex align-items-strech my-1">
                 <a class="btn btn-success" href="{{ route('empleados.create') }}" title="Crear empleado">
                    Nuevo
                </a>
                <a class="btn btn-success" href="{{ route('empleados.index') }}">
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


    <table class="table table-bordered table-responsive">
        <thead class="thead-dark">
            <tr class="">
                <th scope="col">Acciones</th>
                <th scope="col">No </th>
                <th scope="col">Nombre
                </th>
                <th scope="col">Telefono
                </th>
                <th scope="col">Cargo
                </th>
                <th scope="col">Tipo de Documento
                </th>
                <th scope="col">Nro Documento
                </th>
                <th scope="col">Email
                </th>
                <th scope="col">Fecha de Cumpleaños
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
                <tr>
                    <td class="d-flex justify-content-center" style="height: 100px" scope="row">
                            <a class="mx-1" href="{{ route('empleados.show', $empleado->id) }}" title="show">
                                <i class="fas fa-eye text-success  fa-lg"></i>
                            </a>
                            <a class="mx-1" href="{{ route('empleados.edit', $empleado->id) }}">
                                <i class="fas fa-edit  fa-lg"></i>
                            </a>
                            <form class="mx-1" style="width: min-content"
                                action="{{ route('empleados.destroy', $empleado->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" onclick="return confirm('¿Estas seguro de borrar al empleado?')"
                                    title="delete" style="padding:0px; border: none; background-color:transparent;">
                                    <i class="fas fa-trash fa-lg text-danger"></i>
                                </button>
                            </form>
                    </td>
                    <td>{{ $empleado->id }}</td>
                    <td>{{ $empleado->nombre_apellido }}</td>
                    <td>{{ $empleado->telefono }}</td>
                    <td>{{ $empleado->cargo }}</td>
                    <td>{{ $empleado->tipo_doc }}</td>
                    <td>{{ $empleado->nro_doc }}</td>
                    <td>{{ $empleado->user->email }}</td>
                    <td>{{ $empleado->fecha_cumpleanos }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

{{ $empleados->links('pagination::bootstrap-4') }} 

@endsection
