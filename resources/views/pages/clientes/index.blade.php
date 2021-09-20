@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-2">
            <div class="my-3">
                <h2>Clientes </h2>
            </div>
            <div class="d-flex justify-content-between align-items-strech my-1">
                <div class="d-flex">
                 <a class="btn btn-success" href="{{ route('clientes.create') }}" title="Crear cliente">
                    Nuevo
                </a>
                <a class="btn btn-success" href="{{ route('clientes.index') }}">
                    Limpiar
                </a>
                <form class="form-inline" action="{{route('clientes.index')}}" method="GET">
                    <div class="form-group row mx-2">
                      <label class="col-sm-5 col-form-label" for="nombre">Nombre Completo</label>
                      <div class="col-sm-5">
                          <input type="text" name="nombre" class="form-control" id="nombre">
                      </div>
                    </div>
                    <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                  </form>
                </div>
                <div>
                @hasanyrole('super-admin|administrador')
                <a class="btn btn-success" href="{{ route('clientes.export') }}">
                    <i class="fas fa-file-export"></i>
                    Exportar
                </a>
                @endhasanyrole
            </div>
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
                <th scope="col">Direccion
                </th>
                <th scope="col">Tipo de Documento
                </th>
                <th scope="col">Nro Documento
                </th>
                <th scope="col">Email
                </th>
                <th scope="col">fecha de cumpleaños
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td class="d-flex justify-content-center" style="height: 100px" scope="row">
                            <a class="mx-1" href="{{ route('clientes.show', $cliente->id) }}" title="show">
                                <i class="fas fa-eye text-success  fa-lg"></i>
                            </a>
                            <a class="mx-1" href="{{ route('clientes.edit', $cliente->id) }}">
                                <i class="fas fa-edit  fa-lg"></i>
                            </a>
                            <form class="mx-1" style="width: min-content"
                                action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" onclick="return confirm('¿Estas seguro de borrar al cliente?')"
                                    title="delete" style="padding:0px; border: none; background-color:transparent;">
                                    <i class="fas fa-trash fa-lg text-danger"></i>
                                </button>
                            </form>
                    </td>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nombre_apellido }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->direccion }}</td>
                    <td>{{ $cliente->tipo_doc }}</td>
                    <td>{{ $cliente->nro_doc }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>{{ $cliente->fecha_cumpleanos }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>

{{ $clientes->links('pagination::bootstrap-4') }} 

@endsection
