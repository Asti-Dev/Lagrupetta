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
            <x-show-pedido :pedido="$pedido" />
        </div>
@if ($pedido->pedidoEstado->nombre === 'SOLICITADO')
<div class="col-sm-6">
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
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
@endif

    </div>

</div>