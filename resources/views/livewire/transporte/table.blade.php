<div>
    <div class="d-flex align-items-start my-1">
        @if (count($transportes) == 0)
        <div class="w-100 alert alert-primary" role="alert">
            NO TIENES PEDIDOS ASIGNADOS
        </div>
        @endif
    </div>
    <div wire:poll.10s.keep-alive class="container-fluid" style="background: lightskyblue">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 d-flex justify-content-left">
            @foreach ($transportes as $transporte)
            <div class="col">
                <div class="mx-1 my-3 list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="">Pedido #{{$transporte->pedido->id}} </h5>
                        <div class="d-flex flex-column">
                            <span style="font-size: 100%" class="mb-1 badge badge-primary"> {{$transporte->ruta}}</span>
                            @if (!is_null($transporte->completado))
                            <x-test :estado="$transporte->completado" />                        
                            @endif
                        </div>
                    </div>
                    <div class="my-2 mx-3">
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Cliente:</label>
                            <label class="text-right">
                                {{$transporte->pedido->cliente->nombre .' '. $transporte->pedido->cliente->apellido}}
                            </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Bicicleta:</label>
                            <label
                                class="text-right">{{$transporte->pedido->bicicleta->marca .' '. $transporte->pedido->bicicleta->modelo}}
                            </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Direccion:</label>
                            <label class="text-right"> {{$transporte->pedido->cliente->direccion}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Codigo:</label>
                            <label class="text-right"> {{$transporte->pedido->codigo}} </label>
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-between">
                        <a class="btn btn-primary" wire:click.prevent="edit({{$transporte->id}})">
                            @if ($transporte->ruta === 'RECOJO')
                            Recojo
                            @else
                            Entrega
                            @endif
                        </a>
                        <small class="">{{$transporte->created_at->diffForHumans()}} </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>