<div>
    <div class="d-flex align-items-start my-1">
        @if (count($revisiones) == 0)
        <div class="w-100 alert alert-primary" role="alert">
            NO HAY REVISIONES PENDIENTES
        </div>
        @endif
    </div>
    <div wire:poll.10s.keep-alive class="container-fluid" style="background: lightskyblue">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 d-flex justify-content-left">
            @foreach ($revisiones as $revision)
            <div class="col">
                <div class="mx-1 my-3 list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="">Pedido #{{$revision->pedido->id}}</h5>
                        <div class="d-flex flex-column">
                            <span style="font-size: 100%" class="mb-1 badge badge-primary">{{$revision->pedido->pedidoEstado->nombre}}</span>                   
                        </div>
                    </div>
                    <div class="my-2 mx-3">
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Cliente:</label>
                            <label class="text-right"> {{$revision->pedido->cliente->nombre .' '. $revision->pedido->cliente->apellido}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Bicicleta:</label>
                            <label class="text-right">{{$revision->pedido->bicicleta->marca .' '. $revision->pedido->bicicleta->modelo}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Chofer:</label>
                            <label class="text-right"> {{$revision->pedido->transporteRecojo()->choferTransporte->nombre_apellido}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Fecha de Recojo:</label>
                            <label class="text-right">
                                 {{date('d/m/Y h:i A' ,strtotime( $revision->pedido->transporteRecojo()->fecha_hora_completado) )}} 
                            </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Direccion:</label>
                            <label class="text-right"> {{$revision->pedido->cliente->direccion}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">LLegada al Taller:</label>
                            <label class="text-right">{{
                                date('d/m/Y h:i A' ,strtotime( $revision->pedido->transporteRecojo()->fecha_hora_local) )
                                }}  </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Codigo:</label>
                            <label class="text-right"> {{$revision->pedido->codigo}} </label>
                        </div>
                    </div>

                    <div class="d-flex w-100 justify-content-between">
                        @if($revision->pedido->pedidoEstado->nombre === 'REVISAR')
                        <a wire:click.prevent="revision({{$revision->id}})"
                            class="btn btn-primary">Revisar</a>
                        @endif
                        <small class="">{{$revision->pedido->created_at->diffForHumans()}} </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>