@extends('layouts.app')


@section('content')
    <div class="row">
            <div class="">
                <a class="btn btn-primary" href="{{ route('clientes.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
            </div>
            <div class="col">
                <h2> Cliente: {{ $cliente->nombre_apellido }}</h2>
            </div>
    </div>

    <div class="row p-3 mt-1" style="background: lightblue">
        <div class="col-4">
            <div class="form-group">
                <strong>Telefono:</strong>
                {{ $cliente->telefono }}
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <strong>Dirección:</strong>
                {{ $cliente->direccion }}
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <strong>email:</strong>
                {{ $cliente->email }}
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <strong>creacion:</strong>
                {{ $cliente->created_at }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="my-3">
                <h2>Bicicletas en total : {{$cliente->bicicletas->count()}}</h2>
            </div>
            <div class="d-flex align-items-strech my-1">
                 <a class="btn btn-success" href="{{ route('bicicletas.create',['clienteId' => $cliente->id] ) }}" title="Crear bicicleta">
                    Nuevo
                </a>
            </div>
        </div>
    </div>
    

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered table-responsive-lg">
        <thead class="thead-dark">
            <tr class="">
                <th scope="col">Acciones</th>
                <th scope="col">Marca</th>
                <th scope="col">Modelo</th>
                <th scope="col">Codigo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bicicletas as $index => $bicicleta)
                <tr>
                    <td class="d-flex justify-content-center" style="height: 100px" scope="row">
                            <a class="mx-1" href="{{ route('bicicletas.show', $bicicleta->id) }}" title="show">
                                <i class="fas fa-eye text-success  fa-lg"></i>
                            </a>
                            <a class="mx-1" href="{{ route('bicicletas.edit', $bicicleta->id) }}">
                                <i class="fas fa-edit  fa-lg"></i>
                            </a>
                            <form class="mx-1" style="width: min-content"
                                action="{{ route('bicicletas.destroy', $bicicleta->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" onclick="return confirm('¿Estas seguro de borrar la bicicleta?')"
                                    title="delete" style="padding:0px; border: none; background-color:transparent;">
                                    <i class="fas fa-trash fa-lg text-danger"></i>
                                </button>
                            </form>
                    </td>
                    <td>{{ $bicicleta->marca }}</td>
                    <td>{{ $bicicleta->modelo }}</td>
                    <td>{{ $bicicleta->codigo }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $bicicletas->links('pagination::bootstrap-4') }}
@endsection
