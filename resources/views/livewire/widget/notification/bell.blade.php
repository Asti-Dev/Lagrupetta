<li wire:poll.20s class="nav-item dropdown">
    <a id="notifications" class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" data-offset="30,20">
        <div class="d-flex align-items-start">
            <i style="font-size: 20px" class="mt-2 fas fa-bell"></i> 
            @if ($notificacionesNoLeidas > 0)
            <span class="p-1 badge badge-pill badge-danger">
                {{$notificacionesNoLeidas}}
            </span>
            @endif
        </div>
    </a>
    <div class="dropdown-menu" style="right:-120%; left:auto; max-height:80vh; 
     @if ($notificaciones->isNotEmpty())
    overflow-y:scroll
     @endif
    " aria-labelledby="notifications">
      @if ($notificaciones->isEmpty())
      <a class="dropdown-item pr-1" href="#">
        <div class="d-flex w-100">
          <div class="mr-5">
              <p class="m-0"> No tienes Notificaciones
              </p>
            </div>
        </div>
      </a>
      @else
      
            @foreach ($notificaciones as $notificacion)
            <a wire:click.prevent='visto({{$notificacion->id}})' class="dropdown-item pr-1" href="#">
              <div class="d-flex w-100 @if ($notificacion->pivot->visto === 0) font-weight-bold @endif ">
                <div class="mr-5">
                    <p class="m-0"> El pedido Nro {{$notificacion->pedido->id}} esta en estado:<br>
                        @switch($notificacion->pedidoEstado->nombre)
                          @case('EN RUTA RECOJO' || 'EN RUTA ENTREGA' || 'COTIZADO')
                          {{
                            ($notificacion->eliminado === 1) ? 
                            $notificacion->pedidoEstado->nombre . ' '. ($notificacion->sub_estado ?? '') . ' ANULADO' :  
                            $notificacion->pedidoEstado->nombre . ' '. ($notificacion->sub_estado ?? '')
                          }}
                            @break
                          @default
                          {{($notificacion->eliminado === 1) ? $notificacion->pedidoEstado->nombre . ' ANULADO' :  $notificacion->pedidoEstado->nombre}}
                        @endswitch
                    </p>
                    <small>{{$notificacion->created_at->diffForHumans()}}</small>
                  </div>
                  <div wire:click.prevent='delete({{$notificacion->id}})' style="cursor: pointer" class="d-flex align-items-center px-3 w-100">
                    <i style="font-size: 15px" class="fas fa-times"></i>
                  </div>
              </div>
            </a>
            @endforeach
        @endif
    </div>
</li>
