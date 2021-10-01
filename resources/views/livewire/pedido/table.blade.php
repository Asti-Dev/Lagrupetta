<div>
    <div class="d-flex align-items-start justify-content-between my-1">
        <div class="d-flex align-items-start">
        <a class="btn btn-success" wire:click.prevent="create()" title="Crear solicitud">
            Nuevo
        </a>
        <div class="col form-group">
          <select class="form-control" id="estados" wire:model='estado'>
              <option value=''>Todos los Estados</option>
              <option value='EN RUTA RECOJO'>EN RUTA RECOJO </option>
              <option value='DEPOSITADO'> DEPOSITADO </option>
              <option value='EN ALMACEN'>EN ALMACEN </option>
              <option value='EN TALLER'>EN TALLER  </option>
              <option value='COTIZADO'>COTIZADO  </option>
              <option value='EN PROCESO'>EN PROCESO  </option>
              <option value='EN ESPERA'>EN ESPERA  </option>
              <option value='EN CALIDAD'>EN CALIDAD  </option>
              <option value='CORREGIR'>CORREGIR  </option>
              <option value='TERMINADO'>TERMINADO  </option>
              <option value='DEPOSITADO MECANICO'>DEPOSITADO MECANICO</option>
              <option value='EN ALMACEN TERMINADO'>EN ALMACEN TERMINADO </option>
              <option value='EN RUTA ENTREGA'>EN RUTA ENTREGA </option>
              <option value='PAGO PENDIENTE'>PAGO PENDIENTE  </option>
              <option value='FACTURADO'>FACTURADO  </option>
              <option value='ANULADO'>ANULADO</option>
            </select>
      </div>
        <div class="mx-3 d-flex">
            {{ $pedidos->links() }} 
        </div>
        </div>
        @hasanyrole('super-admin|administrador')
        <a class="btn btn-success" href="{{ route('pedidos.export') }}">
            <i class="fas fa-file-export"></i>
            Exportar
        </a>
        @endhasanyrole

    </div>
    <div class="row row-cols-1 row-cols-lg-4 d-flex align-items-start mt-1 my-1">
        <div class="col d-flex justify-content-between form-group pl-0 row">
          <label class="col-sm-2 col-form-label" for="fechaIni">Desde:</label>
          <div class="col-sm-10">
            <input type="date" class="form-control" id="fechaIni" wire:model='fechaIni'>
          </div>
        </div>
        <div class="col d-flex justify-content-between form-group pl-0 row">
          <label class="col-sm-2 col-form-label" for="fechaFin">Hasta:</label>
          <div class="col-sm-10">
            <input type="date" class="form-control" id="fechaFin" wire:model='fechaFin'>
          </div>
        </div>
        <div class="col d-flex justify-content-between form-group row">
          <label class="col-sm-2 col-form-label" for="cliente">Cliente</label>
          <div class="col-sm-9">
              <input type="text" class="form-control" id="cliente" wire:model="cliente">
          </div>
        </div>
        <div class="col d-flex justify-content-between form-group row">
          <label class="col-sm-2 col-form-label" for="nroPedido">Nro Pedido</label>
          <div class="col-sm-9">
              <input type="text" class="form-control" id="nroPedido" wire:model="nroPedido">
          </div>
      </div>
  </div>
    <div wire:poll.10s.keep-alive class="container-fluid" style="background: lightskyblue">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 d-flex justify-content-left">
            @foreach ($pedidos as $key => $pedido)
            <div class="col">
                <div class=" my-3 list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="">Pedido #{{$pedido->id}}</h5>
                        <div class="d-flex flex-column">
                            <span style="font-size: 100%" class="mb-1 badge badge-primary">{{$pedido->pedidoEstado->nombre}}</span>      
                            @if ($pedido->pedidoEstado->nombre === 'EN RUTA RECOJO' && isset($pedido->transporteRecojo->completado))
                            <x-test :estado="$pedido->transporteRecojo->completado" />                        
                            @endif    
                            @if ($pedido->pedidoEstado->nombre === 'EN RUTA ENTREGA' && isset($pedido->transporteEntrega->completado))
                            <x-test :estado="$pedido->transporteEntrega->completado" />                        
                            @endif       
                            @if($pedido->pedidoEstado->nombre === 'COTIZADO')
                            <x-test :estado="$pedido->pedidoDetalle->confirmacion" />    
                            @endif  
                            
                        </div>
                    </div>
                    <div class="my-2">
                        <div class="accordion">
                            <div class="card" x-data="{ text_openOne{{$key}}:true }">
                              <div class="card-header" >
                                <h2 class="mb-0">
                                  <button class="btn btn-link btn-block text-left" type="button" @click = "text_openOne{{$key}} == true ? text_openOne{{$key}} = false : text_openOne{{$key}} = true" >
                                    General
                                  </button>
                                </h2>
                              </div>
                              <div class="collapse show" x-show="text_openOne{{$key}}">
                                <div class="card-body">
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Cliente:</strong>
                                        <p class="text-right">{{ ($pedido->cliente->nombre_apellido) ?? '' }}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Celular:</strong>
                                        <p class="text-right">{{ ($pedido->cliente->telefono) ?? '' }}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                      <strong>Email:</strong>
                                      <p class="text-right">{{ ($pedido->cliente->email) ?? '' }}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                      <strong>{{$pedido->cliente->tipo_doc ?? 'Documento no asignado'}}:</strong>
                                      <p class="text-right">{{ ($pedido->cliente->nro_doc) ?? '' }}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Bicicleta:</strong>
                                        <p class="text-right">{{ ($pedido->bicicleta->marca . ' ' . $pedido->bicicleta->modelo) ?? ''}}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                      <strong>Color:</strong>
                                      <p class="text-right">{{ $pedido->bicicleta->color ?? ''}}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Telefono:</strong>
                                        <p class="text-right">{{ $pedido->cliente->telefono ?? ''  }}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Observacion Cliente:</strong>
                                        <p class="text-right">{{ $pedido->observacion_cliente ?? ''  }}</p>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <label class="mb-1">Codigo:</label>
                                        <label class="text-right"> {{$pedido->codigo}} </label>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="card"  x-data="{ text_openTwo{{$key}}:false }">
                              <div class="card-header">
                                <h2 class="mb-0">
                                  <button class="btn btn-link btn-block text-left collapsed" type="button"  @click = "text_openTwo{{$key}} = true">
                                    Recojo del pedido
                                  </button>
                                </h2>
                              </div>
                              <div class="collapse show"  x-show="text_openTwo{{$key}}" @click.away="text_openTwo{{$key}} = false">
                                <div class="card-body">
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Chofer Recojo:</strong>
                                        <p class="text-right">{{$pedido->transporteRecojo->choferTransporte->nombre_apellido ?? ''}}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Direccion de Recojo:</strong>
                                        <p class="text-right">{{ $pedido->transporteRecojo->distrito ?? ''  }} {{ $pedido->transporteRecojo->direccion ?? ''  }}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Fecha de Recojo:</strong>
                                        <p class="text-right">{{
                                            isset($pedido->transporteRecojo->fecha_hora_completado) ?
                                            date('d/m/Y h:i A' ,strtotime( $pedido->transporteRecojo->fecha_hora_completado) ) :
                                            date('d/m/Y',strtotime( $pedido->fecha_recojo_aprox) )
                                        }}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                      <strong>Rango de recojo:</strong>
                                      <p class="text-right">{{ $pedido->rango_recojo ?? ''  }}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Observacion Chofer Recojo:</strong>
                                        <p class="text-right">{{ $pedido->transporteRecojo->observacion_chofer ?? ''  }}</p>
                                    </div>
                                </div>
                              </div>
                            </div>
                            @if (isset($pedido->pedidoDetalle) || isset($pedido->transporteRecojo->fecha_hora_local))
                            <div class="card"  x-data="{ text_openThree{{$key}}:false }">
                                <div class="card-header">
                                  <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"  @click = "text_openThree{{$key}} = true">
                                      Taller
                                    </button>
                                  </h2>
                                </div>
                                <div class="collapse show"  x-show="text_openThree{{$key}}" @click.away="text_openThree{{$key}} = false">
                                  <div class="card-body">
                                      <div class="form-group d-flex justify-content-between">
                                          <strong>LLegada al Local:</strong>
                                          <p class="text-right">{{ $pedido->transporteRecojo->fecha_hora_local ?? ''  }}</p>
                                      </div>
                                      <div class="form-group d-flex justify-content-between">
                                          <strong>Mecanico:</strong>
                                          <p class="text-right"> {{ $pedido->pedidoDetalle->mecanicoUno->nombre_apellido ?? ''  }} </p>
                                      </div>
                                      <div class="form-group d-flex justify-content-between">
                                          <strong>Comentario del Diagnostico:</strong>
                                          <p class="text-right"> {{ $pedido->pedidoDetalle->diagnostico->comentario ?? ''  }} </p>
                                      </div>
                                      <div class="form-group d-flex justify-content-between">
                                          <strong>Explicacion de Servicios:</strong>
                                          <p class="text-right"> {{ $pedido->pedidoDetalle->explicacion ?? ''  }} </p>
                                      </div>
                                  </div>
                                </div>
                              </div>
                              @endif
                              @if (isset($pedido->pedidoDetalle->fecha_entrega_aprox))
                              <div class="card"  x-data="{ text_openFour{{$key}}:false }">
                                  <div class="card-header @if (isset($pedido->transporteEntrega)) d-flex justify-content-around align-items-center @endif">
                                    <h2 class="mb-0">
                                      <button class="btn btn-link btn-block text-left collapsed" type="button"  @click = "text_openFour{{$key}} = true">
                                        Entrega del Pedido
                                      </button>
                                    </h2>
                                    @if ($pedido->transporteEntrega)
                                        @if (isset($pedido->transporteRecojo)) 
                                            <span class="text-primary"><i class="fas fa-exclamation-circle"></i></span>
                                        @endif
                                    @endif
                                  </div>
                                  <div class="collapse show"  x-show="text_openFour{{$key}}" @click.away="text_openFour{{$key}} = false">
                                    <div class="card-body">
                                      <div class="form-group d-flex justify-content-between">
                                          <strong>Chofer Entrega:</strong>
                                          <p class="text-right">{{$pedido->transporteEntrega->choferTransporte->nombre_apellido ?? ''}}</p>
                                      </div>
                                      <div class="form-group d-flex justify-content-between">
                                          <strong>Direccion de Entrega:</strong>
                                          <p class="text-right">{{ $pedido->transporteEntrega->distrito ?? ''  }} {{ $pedido->transporteEntrega->direccion ?? ''  }}</p>
                                      </div>
                                      <div class="form-group d-flex justify-content-between">
                                          <strong>Fecha de Entrega:</strong>
                                          <p class="text-right">{{
                                              isset($pedido->transporteEntrega->fecha_hora_completado) ?
                                              date('d/m/Y h:i A' ,strtotime( $pedido->transporteEntrega->fecha_hora_completado) ) :
                                              date('d/m/Y',strtotime( $pedido->pedidoDetalle->fecha_entrega_aprox) )
                                          }}</p>
                                      </div>
                                      <div class="form-group d-flex justify-content-between">
                                          <strong>Observacion Chofer Entrega:</strong>
                                          <p class="text-right">{{ $pedido->transporteEntrega->observacion_chofer ?? ''  }}</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                           
                            @endif
                        </div>
                    </div>

                    <div class="d-flex w-100 justify-content-between">

                       
                        <div class="d-flex flex-row-reverse">
                            @hasanyrole('super-admin|administrador')
                            @if(in_array($pedido->pedidoEstado->nombre, ['SOLICITADO', 'EN RUTA RECOJO', 'DEPOSITADO', 'EN ALMACEN', 'EN TALLER']) )
                            <a class="mx-2" href="{{route('pedido.show', ['pedido' => $pedido->id])}}" style="width: min-content" title="show">
                                <i class="fas fa-eye text-success"></i>
                            </a>
                            @endif

                            @if(!in_array($pedido->pedidoEstado->nombre, ['SOLICITADO', 'EN RUTA RECOJO', 'DEPOSITADO', 'EN ALMACEN', 'EN TALLER']))
                            <a class="mx-2" href="{{route('cotizacion.show', $pedido->id)}}" style="width: min-content" title="show">
                                <i class="fas fa-eye text-success"></i>
                            </a>
                            @endif
                            @endhasanyrole
                            @if ($pedido->pedidoDetalle->diagnostico ?? '')
                            <a class="mx-2" style="width: min-content"
                            href="{{ route('download.diagnostico', $pedido->id) }}"
                            title="show">
                            <i class="fas fa-file-download text-primary"></i>
                            </a>
                            @endif
                            @hasanyrole('super-admin|administrador')
                            @if (!$pedido->trashed())
                             <form class="mx-2" style="width: min-content"
                             wire:submit.prevent="destroy({{$pedido->id}})"> 

                            <button type="submit" onclick="return confirm('¿Estas seguro de borrar el pedido?')"
                                title="delete" style="padding:0px; border: none; background-color:transparent;">
                                <i class="fas fa-trash fa-lg text-danger"></i>
                            </button>
                             </form>
                            @else
                             <form class="mx-2" style="width: min-content"
                             wire:submit.prevent="restore({{$pedido->id}})">

                            <button type="submit" onclick="return confirm('¿Estas seguro de restaurar el pedido?')"
                                title="restore" style="padding:0px; border: none; background-color:transparent;">
                                <i class="fas fa-trash-restore"></i>
                            </button>
                             </form>
                            @endif
                            @endhasanyrole
                        </div>
                       

                        @hasanyrole('super-admin|administrador')
                        @if ($pedido->pedidoEstado->nombre === 'PAGO PENDIENTE')
                        <button wire:click.prevent="completado({{$pedido->id}})" 
                            class=" mx-4 btn btn-primary btn-sm">Completado</button>
                        @endif
                        @if ($pedido->pedidoEstado->nombre === 'EN RUTA ENTREGA' && $pedido->transporteEntrega->completado === 'COMPLETADO' )
                        <button wire:click.prevent="pago({{$pedido->id}})" 
                            class="mx-4 btn btn-primary btn-sm">Pago pendiente</button>
                        @endif
                        @if ($pedido->pedidoEstado->nombre === 'TERMINADO'
                         || $pedido->pedidoEstado->nombre === 'DEPOSITADO MECANICO'
                         || $pedido->pedidoEstado->nombre === 'EN ALMACEN TERMINADO')
                        <button wire:click.prevent="asignarChofer({{$pedido->id}})" 
                            class="mx-4 btn btn-primary btn-sm">Asignar Entrega</button>
                        @endif
                        @endhasanyrole
                        <small class="">{{$pedido->created_at->diffForHumans()}} </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>