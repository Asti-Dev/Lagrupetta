<div>
    <div class="d-flex align-items-start my-1">
        <a class="btn btn-success" wire:click.prevent="create()" title="Crear solicitud">
            Nuevo
        </a>
        <div class="mx-3 d-flex">
            {{ $pedidos->links() }} 
        </div>
    </div>
    <div class="row row-cols-1 row-cols-lg-4 d-flex align-items-start my-1">
        <div class="col form-group">
            <select class="form-control" id="orden" wire:model='nroOrden'>
                <option value=''>Ordenar por ... </option>
                <option value='1'> INGRESADOS RECIENTE  </option>
                <option value='2'> INGRESADOS ANTIGUOS </option>
                <option value='3'> ACTUALIZADOS RECIENTE </option>
                <option value='4'> ACTUALIZADOS ANTIGUOS </option>
                <option value='5'> NRO PEDIDO MAYOR </option>
                <option value='6'>NRO PEDIDO MENOR  </option>
              </select>
        </div>
        <div class="col form-group">
            <select class="form-control" id="estados" wire:model='estado'>
                <option value=''>Todos los Estados</option>
                <option value='SOLICITADO'> SOLICITADO  </option>
                <option value='EN RUTA'>EN RUTA </option>
                <option value='RECOGIDO'> RECOGIDO </option>
                <option value='EN TALLER'>EN TALLER  </option>
                <option value='COTIZADO'>COTIZADO  </option>
                <option value='EN PROCESO'>EN PROCESO  </option>
                <option value='REVISAR'>REVISAR  </option>
                <option value='CORREGIR'>CORREGIR  </option>
                <option value='TERMINADO'>TERMINADO  </option>
                <option value='ENTREGADO'>ENTREGADO  </option>
                <option value='PAGO PENDIENTE'>PAGO PENDIENTE  </option>
                <option value='COMPLETADO'>COMPLETADO  </option>
                <option value='ANULADO'>ANULADO</option>
                <option value='EN ESPERA'>EN ESPERA  </option>
              </select>
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
              <input type="number" class="form-control" id="nroPedido" wire:model="nroPedido">
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
                            @if($pedido->pedidoEstado->nombre === 'SOLICITADO')
                            <x-test :estado="$pedido->confirmacion" />    
                            @endif         
                            @if($pedido->pedidoEstado->nombre === 'COTIZADO')
                            <x-test :estado="$pedido->pedidoDetalle->confirmacion" />    
                            @endif            
                        </div>
                    </div>
                    <div class="my-2">
                        <div class="accordion">
                            <div class="card" x-data="{ text_openOne{{$key}}:false }">
                              <div class="card-header" >
                                <h2 class="mb-0">
                                  <button class="btn btn-link btn-block text-left" type="button" @click = "text_openOne{{$key}} = true">
                                    General
                                  </button>
                                </h2>
                              </div>
                              <div class="collapse show" x-show="text_openOne{{$key}}" @click.away="text_openOne{{$key}} = false">
                                <div class="card-body">
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Cliente:</strong>
                                        <p class="text-right">{{ ($pedido->cliente->nombre_apellido) ?? '' }}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Bicicleta:</strong>
                                        <p class="text-right">{{ ($pedido->bicicleta->marca . ' ' . $pedido->bicicleta->modelo) ?? ''}}</p>
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
                                        <p class="text-right">{{$pedido->transporteRecojo()->choferTransporte->nombre_apellido ?? ''}}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Direccion de Recojo:</strong>
                                        <p class="text-right">{{ $pedido->transporteRecojo()->direccion ?? ''  }}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Fecha de Recojo:</strong>
                                        <p class="text-right">{{
                                            isset($pedido->transporteRecojo()->fecha_hora_completado) ?
                                            date('d/m/Y h:i A' ,strtotime( $pedido->transporteRecojo()->fecha_hora_completado) ) :
                                            date('d/m/Y',strtotime( $pedido->fecha_recojo_aprox) )
                                        }}</p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <strong>Observacion Chofer Recojo:</strong>
                                        <p class="text-right">{{ $pedido->transporteRecojo()->observacion_chofer ?? ''  }}</p>
                                    </div>
                                </div>
                              </div>
                            </div>
                            @if (isset($pedido->pedidoDetalle))
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
                                          <strong>LLegada al Taller:</strong>
                                          <p class="text-right">{{ $pedido->transporteRecojo()->fecha_hora_local ?? ''  }}</p>
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
                              <div class="card"  x-data="{ text_openFour{{$key}}:false }">
                                  <div class="card-header">
                                    <h2 class="mb-0">
                                      <button class="btn btn-link btn-block text-left collapsed" type="button"  @click = "text_openFour{{$key}} = true">
                                        Entrega del Pedido
                                      </button>
                                    </h2>
                                  </div>
                                  <div class="collapse show"  x-show="text_openFour{{$key}}" @click.away="text_openFour{{$key}} = false">
                                    <div class="card-body">
                                      <div class="form-group d-flex justify-content-between">
                                          <strong>Chofer Entrega:</strong>
                                          <p class="text-right">{{$pedido->transporteEntrega()->choferTransporte->nombre_apellido ?? ''}}</p>
                                      </div>
                                      <div class="form-group d-flex justify-content-between">
                                          <strong>Direccion de Entrega:</strong>
                                          <p class="text-right">{{ $pedido->transporteEntrega()->direccion ?? ''  }}</p>
                                      </div>
                                      <div class="form-group d-flex justify-content-between">
                                          <strong>Fecha de Entrega:</strong>
                                          <p class="text-right">{{
                                              isset($pedido->transporteEntrega()->fecha_hora_completado) ?
                                              date('d/m/Y h:i A' ,strtotime( $pedido->transporteEntrega()->fecha_hora_completado) ) :
                                              date('d/m/Y',strtotime( $pedido->pedidoDetalle->fecha_entrega_aprox) )
                                          }}</p>
                                      </div>
                                      <div class="form-group d-flex justify-content-between">
                                          <strong>Observacion Chofer Entrega:</strong>
                                          <p class="text-right">{{ $pedido->transporteEntrega()->observacion_chofer ?? ''  }}</p>
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
                            @if($pedido->pedidoEstado->id <= 4)
                            <a class="mx-2" href="{{route('pedido.show', ['pedido' => $pedido->id])}}" style="width: min-content" title="show">
                                <i class="fas fa-eye text-success"></i>
                            </a>
                            @endif

                            @if($pedido->pedidoEstado->id >= 5)
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
                        @if ($pedido->pedidoEstado->nombre === 'ENTREGADO')
                        <button wire:click.prevent="pago({{$pedido->id}})" 
                            class="mx-4 btn btn-primary btn-sm">Pago pendiente</button>
                        @endif
                        @if ($pedido->pedidoEstado->nombre === 'TERMINADO')
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