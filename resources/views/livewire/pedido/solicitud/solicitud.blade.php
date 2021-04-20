<div>
    <div class="row">
        <div class="">
            <a class="btn btn-primary" href="{{ route('pedidos.index') }}" title="Go back"> <i
                    class="fas fa-backward "></i> </a>
        </div>
        <div class="col">
            <h2> Pedido #{{ $pedido->id }}</h2>
        </div>
    </div>

    <div class="row p-3 my-3">
        <div class="col-sm-6">
            <div class="col px-5 py-3" style="background: lightblue">
                <div class="form-group d-flex justify-content-between">
                    <strong>Cliente:</strong>
                    <p class="text-right">{{ ($pedido->cliente->nombre .' '. $pedido->cliente->apellido) ?? '' }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Bicicleta:</strong>
                    <p class="text-right">{{ ($pedido->bicicleta->marca . ' ' . $pedido->bicicleta->modelo) ?? ''}}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Chofer:</strong>
                    <p class="text-right">{{$pedido->transporteRecojo()->choferTransporte->nombre_apellido ?? ''}}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Telefono:</strong>
                    <p class="text-right">{{ $pedido->cliente->telefono ?? ''  }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Direccion:</strong>
                    <p class="text-right">{{ $pedido->cliente->direccion ?? ''  }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Fecha de Recojo:</strong>
                    <p class="text-right">{{ $pedido->fecha_recojo_aprox ?? ''  }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>LLegada al Taller:</strong>
                    <p class="text-right">fecha en taller</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Mecanico:</strong>
                    <p class="text-right"> Mecanico </p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Direccion:</strong>
                    <p class="text-right">{{ $pedido->cliente->direccion ?? ''  }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Fecha de Entrega:</strong>
                    <p class="text-right">Fecha de entrega</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
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
            <livewire:pedido.solicitud.form :pedido='$pedido'>
        </div>
    </div>

</div>