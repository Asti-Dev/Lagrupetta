<div>
    <div class="d-flex align-items-start my-1">
        @if (count($pedidoDetalles) == 0)
        <div class="w-100 alert alert-primary" role="alert">
            NO TIENES PEDIDOS ASIGNADOS
        </div>
        @endif
    </div>
    <div wire:poll.10s.keep-alive class="container-fluid" style="background: lightskyblue">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 d-flex justify-content-left">
            @foreach ($pedidoDetalles as $pedidoDetalle)
            <div class="col">
                <div class="mx-1 my-3 list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="">Pedido #{{$pedidoDetalle->pedido->id}}</h5>
                        <div class="d-flex flex-column">
                            <span style="font-size: 100%" class="mb-1 badge badge-primary">{{$pedidoDetalle->pedido->pedidoEstado->nombre}}</span>
                            @if($pedidoDetalle->pedido->pedidoEstado->nombre === 'SOLICITADO')
                            <x-test :estado="$pedidoDetalle->pedido->confirmacion" />    
                            @endif
                            @if($pedidoDetalle->pedido->pedidoEstado->nombre === 'COTIZADO')
                            <x-test :estado="$pedidoDetalle->confirmacion" />    
                            @endif                     
                        </div>
                    </div>
                    <div class="my-2 mx-3">
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Cliente:</label>
                            <label class="text-right"> {{$pedidoDetalle->pedido->cliente->nombre .' '. $pedidoDetalle->pedido->cliente->apellido}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Bicicleta:</label>
                            <label class="text-right">{{$pedidoDetalle->pedido->bicicleta->marca .' '. $pedidoDetalle->pedido->bicicleta->modelo}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Chofer:</label>
                            <label class="text-right"> {{$pedidoDetalle->pedido->transporteRecojo()->choferTransporte->nombre_apellido}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Fecha de Recojo:</label>
                            <label class="text-right">
                                 {{date('d/m/Y h:i A' ,strtotime( $pedidoDetalle->pedido->transporteRecojo()->fecha_hora_completado) )}} 
                            </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Observacion Chofer:</label>
                            <label class="text-right"> {{$pedidoDetalle->pedido->transporteRecojo()->observacion_chofer}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">LLegada al Taller:</label>
                            <label class="text-right">{{
                                date('d/m/Y h:i A' ,strtotime( $pedidoDetalle->pedido->transporteRecojo()->fecha_hora_local) )
                                }}  </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Codigo:</label>
                            <label class="text-right"> {{$pedidoDetalle->pedido->codigo}} </label>
                        </div>
                    </div>

                    <div class="d-flex w-100 justify-content-between">
                        @if($pedidoDetalle->pedido->pedidoEstado->nombre  === 'CORREGIR')
                        <a href="{{route('corregir', ['revisionId' => $pedidoDetalle->pedido->revision->id] )}}" 
                            class="btn btn-primary">Corregir</a>
                        @endif
                        @if($pedidoDetalle->confirmacion === 'ACEPTADO' && $pedidoDetalle->pedido->revision == false)
                        <a href="{{route('todoList', ['pedidoDetalleId' => $pedidoDetalle->id] )}}" 
                            class="btn btn-primary">Trabajar</a>
                        @endif
                        @if($pedidoDetalle->diagnostico_id == false)
                        <a href="{{route('cotizar',  $pedidoDetalle->id )}}" 
                            class="btn btn-primary">Diagnosticar/Cotizar</a>
                        @endif
                        <small class="">{{$pedidoDetalle->pedido->created_at->diffForHumans()}} </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>