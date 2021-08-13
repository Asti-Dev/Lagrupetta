<div >
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
            @error('explicacion') <li class="error">Explicacion Requerida</li> @enderror
            @error('fecha_entrega') <li class="error">Fecha de Entrega Requerida</li> @enderror
        </ul>
    </div>
    @endif

    <div class="row">
        <form class='w-100 d-flex flex-column align-items-center justify-content-center'
        action="{{ route('cotizacion.update', $pedidoDetalle->id) }}" method="POST">
        @csrf
        @method('PUT')
            <div x-data="{ tab: 'zero' }" class="col">
                <div class="col" x-show="tab === 'zero'" >
                    {{-- Verificar Bicicleta --}}
                    <div class="col-6">
                        <div wire:click="$refresh" class="mx-1 my-3 list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="">Bicicleta </h5>
                            </div>
                            <div class="my-2 mx-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <b class="mb-1">Marca:</b>
                                    <label class="text-right">
                                        {{$bicicleta->marca}}
                                    </label>
                                </div>
                                <div class="d-flex w-100 justify-content-between">
                                    <b class="mb-1">Modelo:</b>
                                    <label
                                        class="text-right">{{$bicicleta->modelo}}
                                    </label>
                                </div>
                                <div class="d-flex flex-column w-100 justify-content-between">
                                    <b class="mb-1">codigo:</b>
                                    <label class="text-right"> {{$bicicleta->codigo}} </label>
                                </div>
                            </div>
                            <div class="d-flex w-100 justify-content-between">
                                <a class="btn btn-primary"  
                                onclick="window.open('{{route('bicicletas.edit', $bicicleta->id)}}', 
                                'newwindow', 
                                'width=500,height=500'); 
                                return false;"
                                href="#"> Editar Bicicleta </a>
                            </div>
                        </div>
                    </div>
                        <div class="form-group">
                            <button type="button" :class="{ 'active': tab === 'one' }" @click="tab = 'one'"
                                class="btn btn-primary btn-lg">Siguiente</button>
                        </div>
                </div>
                <div class="col" x-show="tab === 'one'" >
                    {{-- incluir form de diagnostico --}}
                    <livewire:diagnostico.form :pedidoDetalleId="$pedidoDetalle->id">
                        <div class="form-group">
                            <button class="btn btn-secondary" type="button" :class="{ 'active': tab === 'zero' }"
                                @click="tab = 'zero'">
                                Atras
                            </button>
                        </div>
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