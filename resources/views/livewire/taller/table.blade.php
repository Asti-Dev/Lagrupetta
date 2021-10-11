<div>
    <div class="row row-cols-1 row-cols-lg-4 d-flex align-items-start my-1">
        @hasanyrole('super-admin|administrador')
        <select class="form-control" wire:model="mecanico" name="mecanico">
            <option value=""> Selecciona un mecanico</option>
            @foreach ($mecanicos as $mecanico)
            <option value="{{$mecanico->id}}">{{$mecanico->nombre_apellido}}</option>
            @endforeach
        </select>
        @endhasanyrole
    </div>
    <div class="row row-cols-1 row-cols-lg-4 d-flex align-items-start my-1">
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
        <div class="col form-group">
            <select class="form-control" id="estados" wire:model='estado'>
                <option value=''>Todos los Estados</option>
                <option value='EN TALLER'>EN TALLER  </option>
                <option value='COTIZADO'>COTIZADO  </option>
                <option value='EN PROCESO'>EN PROCESO  </option>
                <option value='EN CALIDAD'>EN CALIDAD  </option>
                <option value='CORREGIR'>CORREGIR  </option>
                <option value='TERMINADO'>TERMINADO  </option>
                <option value='EN ESPERA'>EN ESPERA  </option>
              </select>
        </div>
        <div class="col d-flex justify-content-between form-group row">
          <label class="col-sm-2 col-form-label" for="cliente">Cliente</label>
          <div class="col-sm-9">
              <input type="text" class="form-control" id="cliente" wire:model="cliente">
          </div>
        </div>
    </div>
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
                            <label class="text-right"> {{$pedidoDetalle->pedido->cliente->nombre_apellido}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Bicicleta:</label>
                            <label class="text-right">{{$pedidoDetalle->pedido->bicicleta->marca .' '. $pedidoDetalle->pedido->bicicleta->modelo}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Bicicleta Color:</label>
                            <label class="text-right"> {{$pedidoDetalle->pedido->bicicleta->color}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Chofer:</label>
                            <label class="text-right"> {{$pedidoDetalle->pedido->transporteRecojo->choferTransporte->nombre_apellido}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Observacion Cliente:</label>
                            <label class="text-right"> {{$pedidoDetalle->pedido->observacion_cliente}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Observacion Chofer:</label>
                            <label class="text-right"> {{$pedidoDetalle->pedido->transporteRecojo->observacion_chofer}} </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1"> Mecanico:</label>
                            <label class="text-right"> {{$pedidoDetalle->mecanicoUno->nombre_apellido}} </label>
                        </div>
                        @if (isset($pedidoDetalle->fecha_entrega_aprox))
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Fecha Entrega:</label>
                            <label class="text-right"> {{ date('d/m/Y' ,strtotime($pedidoDetalle->fecha_entrega_aprox))}} </label>
                        </div>
                        @endif
                        
                        <div class="d-flex w-100 justify-content-between">
                            <label class="mb-1">Codigo:</label>
                            <label class="text-right"> {{$pedidoDetalle->pedido->codigo}} </label>
                        </div>
                    </div>

                    <div class="d-flex w-100 justify-content-between">
                        @hasanyrole('super-admin|mecanico|jefe mecanicos')
                        <div class="d-flex flex-column">
                        @if($pedidoDetalle->pedido->pedidoEstado->nombre  === 'CORREGIR')
                        <a href="{{route('corregir', ['revisionId' => $pedidoDetalle->pedido->revision->id] )}}" 
                            class="btn btn-primary">Corregir</a>
                        @endif
                        @if($pedidoDetalle->confirmacion === 'ACEPTADO' && in_array($pedidoDetalle->pedido->pedidoEstado->nombre , $estadosTrabajar))
                        <a href="{{route('todoList', ['pedidoDetalleId' => $pedidoDetalle->id] )}}" 
                            class="btn btn-primary">Trabajar</a>
                        @endif
                        @if($pedidoDetalle->diagnostico_id == false && $pedidoDetalle->pedido->pedidoEstado->nombre == 'EN TALLER')
                        <a href="{{route('cotizar',  $pedidoDetalle->id )}}" 
                            class="btn btn-primary">Diagnosticar/Cotizar</a>
                        @endif
                        @if($pedidoDetalle->confirmacion === 'EN ESPERA' || $pedidoDetalle->confirmacion === 'RECHAZADO')
                            <a href="{{route('cotizacion.edit', $pedidoDetalle->id)}}"
                                class="btn btn-primary">Reenviar Cotizacion</a>
                        @endif
                        @if (in_array($pedidoDetalle->pedido->pedidoEstado->nombre , $estadosEditar))
                        <a href="{{route('cotizacion.edit2',  $pedidoDetalle->pedido->id )}}" 
                            class="btn btn-primary mt-1">Editar Cotizacion</a>                            
                        @endif
                    </div>
                        @endhasanyrole
                        <small class="">{{$pedidoDetalle->pedido->created_at->diffForHumans()}} </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>