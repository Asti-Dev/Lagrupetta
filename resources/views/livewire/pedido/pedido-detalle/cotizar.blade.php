<div>
    <div class="row">
        <div class="">
            <a class="btn btn-primary" href="{{ route('taller.index') }}" title="Go back"> <i
                    class="fas fa-backward "></i> </a>
        </div>
        <div class="col">
            <h2> Pedido #{{ $pedidoDetalle->pedido->id }}</h2>
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

    <div class="row">
        <form class='w-100 d-flex flex-column align-items-center justify-content-center'
        action="{{ route('cotizacion.update', $pedidoDetalle->id) }}" method="POST">
        @csrf
        @method('PUT')
            <div x-data="{ tab: 'one' }" class="col">
                <div class="col" x-show="tab === 'one'" >
                    {{-- incluir form de diagnostico --}}
                    <livewire:diagnostico.form :pedidoDetalleId="$pedidoDetalle->id">
                        <div class="form-group">
                            <button type="button" :class="{ 'active': tab === 'one' }" @click="tab = 'two'"
                                class="btn btn-primary btn-lg">Siguiente</button>
                        </div>
                </div>
                <div class="col" x-show="tab === 'two'" >
                    <div class="d-flex flex-column align-items-center justify-content-center">
                    {{-- incluir form de asignar servicios --}}
                    <livewire:pedido.pedido-detalle.cotizacion.cotizacion :pedido="$pedidoDetalle->pedido->id">
                    <div>
                        <div class="form-group">
                            <button class="btn btn-secondary" type="button" :class="{ 'active': tab === 'two' }"
                                @click="tab = 'one'">
                                Atras
                            </button>
                        </div>
                        <div class="form-group">
                            <button type="submit" onclick="totales()" 
                                class="btn btn-primary">Cotizar</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>