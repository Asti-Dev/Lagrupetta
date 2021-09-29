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
        <div class="col-4">
            <div class="form-group">
                <strong>Distrito:</strong>
                {{ $cliente->distrito }}
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="my-3">
                <h2>Pedidos en total : {{$cliente->pedidos->count()}}</h2>
            </div>
            <div class="d-flex align-items-strech my-1">
                 <a class="btn btn-success" href="{{ route('pedido.cliente',['cliente' => $cliente->id] ) }}" title="Crear bicicleta">
                    Nuevo
                </a>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-responsive-lg">
        <thead class="thead-dark">
            <tr class="">
                <th scope="col">Nro</th>
                <th scope="col">Estado</th>
                <th scope="col">Precio Total</th>
                <th scope="col">Fecha de creacion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidos as $index => $pedido)
                <tr>
                    <td>{{ $pedido->id ?? '' }}
                            @hasanyrole('super-admin|administrador')
                            @if(in_array($pedido->pedidoEstado->nombre, ['SOLICITADO', 'EN RUTA RECOJO', 'DEPOSITADO', 'EN ALMACEN', 'EN TALLER']) )
                            <a class="mx-2" href="{{route('pedido.show', ['pedido' => $pedido->id])}}" style="width: min-content" title="show">
                                <i class="fas fa-eye text-success"></i>
                            </a>
                            @endif

                            @if(!in_array($pedido->pedidoEstado->nombre, ['SOLICITADO', 'EN RUTA RECOJO', 'DEPOSITADO', 'EN ALMACEN', 'EN TALLER']))
                            <a class="mx-2" href="{{route('cotizacion.show', $pedido->id)}}" style="width: min-content" title="show">
                                <i class="fas fa-eye text-success"></i>
                            </a>
                            @endif
                            @endhasanyrole
                            @if ($pedido->pedidoDetalle->diagnostico ?? '')
                            <a class="mx-2" style="width: min-content"
                            href="{{ route('download.diagnostico', $pedido->id) }}"
                            title="show">
                            <i class="fas fa-file-download text-primary"></i>
                            </a>
                            @endif
                    </td>
                    <td>{{ $pedido->pedidoEstado->nombre ?? '' }}</td>
                    <td>{{ $pedido->pedidoDetalle->precio_final ?? '' }}</td>
                    <td>{{ $pedido->created_at ?? ''}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $pedidos->links('pagination::bootstrap-4') }}
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
