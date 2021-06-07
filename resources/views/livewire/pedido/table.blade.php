<div>
    <div class="d-flex align-items-start my-1">
        <a class="btn btn-success" wire:click.prevent="create()" title="Crear solicitud">
            Nuevo
        </a>
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
                            @if($pedido->pedidoEstado->nombre === 'SOLICITADO')
                            <x-test :estado="$pedido->confirmacion" />    
                            @endif         
                            @if($pedido->pedidoEstado->nombre === 'COTIZADO')
                            <x-test :estado="$pedido->pedidoDetalle->confirmacion" />    
                            @endif            
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
                            <label class="text-right"> {{

                            $pedido->transporteRecojo()->fecha_hora_completado ?
                            date('d/m/Y h:i A' ,strtotime( $pedido->transporteRecojo()->fecha_hora_completado) ) :
                            date('d/m/Y',strtotime( $pedido->fecha_recojo_aprox) )
            
                            }} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Direccion:</label>
                            <label class="text-right"> {{$pedido->cliente->direccion}} </label>
                        </div>
                        @if ($pedido->transporteRecojo()->fecha_hora_local)
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">LLegada al Taller:</label>
                            <label class="text-right">{{
                            date('d/m/Y h:i A' ,strtotime( $pedido->transporteRecojo()->fecha_hora_local) )
                            }} 
                            </label>
                        </div>
                        @endif
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Codigo:</label>
                            <label class="text-right"> {{$pedido->codigo}} </label>
                        </div>
                    </div>

                    <div class="d-flex w-100 justify-content-between">
                        <div class="d-flex flex-row-reverse">
                            @if($pedido->pedidoEstado->nombre === 'SOLICITADO')
                            <a class="mx-2" href="{{route('pedido.show', ['pedido' => $pedido->id])}}" style="width: min-content" title="show">
                                <i class="fas fa-eye text-success"></i>
                            </a>
                            @endif

                            @if ($pedido->revision->completado ?? '')
                            <a class="mx-2" style="width: min-content"
                            href="{{ route('download.diagnostico', $pedido->id) }}"
                            title="show">
                            <i class="fas fa-file-download text-primary"></i>
                            </a>
                            @endif
                            @if ($pedido->pedidoDetalle->diagnostico ?? '')
                            <a class="mx-2" style="width: min-content"
                            href="{{ route('download.diagnostico', $pedido->id) }}"
                            title="show">
                            <i class="fas fa-file-download text-primary"></i>
                            </a>
                            @endif

                            <form class="mx-2" style="width: min-content"
                            wire:submit.prevent="destroy({{$pedido->id}})">

                           <button type="submit" onclick="return confirm('¿Estas seguro de borrar el pedido?')"
                               title="delete" style="padding:0px; border: none; background-color:transparent;">
                               <i class="fas fa-trash fa-lg text-danger"></i>
                           </button>
                       </form>
                        </div>
                        @if ($pedido->pedidoEstado->nombre === 'PAGO PENDIENTE')
                        <button wire:click.prevent="completado({{$pedido->id}})" 
                            class=" mx-4 btn btn-primary btn-sm">Completado</button>
                        @endif
                        @if ($pedido->pedidoEstado->nombre === 'ENTREGADO')
                        <button wire:click.prevent="pago({{$pedido->id}})" 
                            class="mx-4 btn btn-primary btn-sm">Pago pendiente</button>
                        @endif
                        @if ($pedido->pedidoEstado->nombre === 'TERMINADO')
                        <button wire:click.prevent="asignarChofer({{$pedido->id}})" 
                            class="mx-4 btn btn-primary btn-sm">Asignar Entrega</button>
                        @endif
                        @if($pedido->pedidoEstado->nombre === 'COTIZADO' &&
                        $pedido->pedidoDetalle->confirmacion != 'ACEPTADO')
                  
                       <a href="{{route('cotizacion.edit', $pedido->pedidoDetalle->id)}}" 
                           class="mx-4 btn btn-primary btn-sm">Reenviar Cotizacion</a>
             
                       @endif
                        <small class="">{{$pedido->created_at->diffForHumans()}} </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>