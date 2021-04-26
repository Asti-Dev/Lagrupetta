<div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="my-3">
                <h2>Ingreso </h2>
            </div>
        </div>
    </div>
    

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @switch($view)
        @case('asignar')
        <div>
            <div class="col pull-right">
                <a class="btn btn-primary" wire:click.prevent="index()" title="volver">
                    <i class="fas fa-backward "></i>
                </a>
            </div>
            <livewire:almacen.ingreso.form :pedido="$pedido">
        </div>
            @break
    
        @default
        <div>
            <div class="d-flex align-items-start my-1">
                <div class="mx-3 d-flex">
                    {{ $pedidos->links() }} 
                </div>
            </div>
            <div wire:poll.10s.keep-alive class="container-fluid" style="background: lightskyblue">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 d-flex justify-content-left">
                    @foreach ($pedidos as $pedido)
                    <div class="col">
                        <div class="mx-1 my-3 list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="">Pedido #{{$pedido->id}}</h5>
                                <div class="d-flex flex-column">
                                    <span style="font-size: 100%" class="mb-1 badge badge-primary">{{$pedido->pedidoEstado->nombre}}</span>                
                                </div>
                            </div>
                            <div class="my-2 mx-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <label class="mb-1">Cliente:</label>
                                    <label class="text-right"> {{$pedido->cliente->nombre .' '. $pedido->cliente->apellido}} </label>
                                </div>
                                <div class="d-flex w-100 justify-content-between">
                                    <label class="mb-1">Bicicleta:</label>
                                    <label class="text-right">{{$pedido->bicicleta->marca .' '. $pedido->bicicleta->modelo}} </label>
                                </div>
                                <div class="d-flex w-100 justify-content-between">
                                    <label class="mb-1">Chofer:</label>
                                    <label class="text-right"> {{$pedido->transporteRecojo()->choferTransporte->nombre_apellido}} </label>
                                </div>
                                <div class="d-flex w-100 justify-content-between">
                                    <label class="mb-1">Fecha de Recojo:</label>
                                    <label class="text-right"> {{date('d/m/Y h:i A' ,strtotime( $pedido->transporteRecojo()->fecha_hora_completado) )}} </label>
                                </div>
                                <div class="d-flex w-100 justify-content-between">
                                    <label class="mb-1">Direccion:</label>
                                    <label class="text-right"> {{$pedido->cliente->direccion}} </label>
                                </div>
                                <div class="d-flex w-100 justify-content-between">
                                    <label class="mb-1">Codigo:</label>
                                    <label class="text-right"> {{$pedido->codigo}} </label>
                                </div>
                            </div>
        
                            <div class="d-flex w-100 justify-content-between">
                                <a  wire:click.prevent="enTaller({{$pedido->id}})"class="btn btn-primary">En Taller</a>
        
                                <small class="">{{$pedido->created_at->diffForHumans()}} </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endswitch

    {{-- @include("livewire.almacen.ingreso.$view") --}}

</div>
