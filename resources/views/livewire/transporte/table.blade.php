<div>
    <div class="row row-cols-1 row-cols-lg-4 d-flex align-items-start my-1">
          <div class="col form-group">
            <select class="form-control" wire:model='selectFecha'>
              <option value=''>Todas las Fechas</option>
              <option value='HOY'> HOY </option>
              <option value='SEMANA'>SEMANA </option>
              <option value='MES'> MES </option>
            </select>
          </div>
          <div class="col form-group">
            <select class="form-control" id="estados" wire:model='ruta'>
              <option value=''>Todas las rutas</option>
              <option value='RECOJO'> RECOJO  </option>
              <option value='ENTREGA'>ENTREGA </option>
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
    @if (count($transportes) == 0)
    <div class="d-flex align-items-start my-1">
        
        <div class="w-100 alert alert-primary" role="alert">
            NO TIENES PEDIDOS ASIGNADOS
        </div>
    </div>
    @endif

    <div wire:poll.10s.keep-alive class="container-fluid" style="background: lightskyblue">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 d-flex justify-content-left">
            @foreach ($transportes as $transporte)
            <div class="col">
                <div class="mx-1 my-3 list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="">Pedido #{{$transporte->pedido->id}} </h5>
                        <div class="d-flex flex-column">
                            <span style="font-size: 100%" class="mb-1 badge 
                            @if ($transporte->ruta == 'RECOJO')
                            badge-warning 
                                @else
                                badge-primary 

                            @endif"> {{$transporte->ruta}}</span>
                            @if (!is_null($transporte->completado))
                            <x-test :estado="$transporte->completado" />                        
                            @endif
                        </div>
                    </div>
                    <div class="my-2 mx-3">
                        <div class="d-flex w-100 justify-content-between">
                            <b class="mb-1">Cliente:</b>
                            <label class="text-right">
                                {{$transporte->pedido->cliente->nombre_apellido}}
                            </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <b class="mb-1">Bicicleta:</b>
                            <label
                                class="text-right">{{$transporte->pedido->bicicleta->marca .' '. $transporte->pedido->bicicleta->modelo}}
                            </label>
                        </div>
                        <div class="d-flex flex-column w-100 justify-content-between">
                            <b class="mb-1">Direccion:</b>
                            <label class="text-right"> {{$transporte->direccion}} </label>
                        </div>
                        <div class="d-flex flex-column w-100 justify-content-between">
                            <b class="mb-1">Observacion Cliente:</b>
                            <label class="text-right"> {{$transporte->pedido->observacion_cliente}} </label>
                        </div>
                        @if (!empty($transporte->pedido->pedidoDetalle->fecha_entrega_aprox))
                        <div class="d-flex w-100 justify-content-between">
                            <b class="mb-1">Fecha Entrega:</b>
                            <label class="text-right"> {{ date('d/m/Y' ,strtotime($transporte->pedido->pedidoDetalle->fecha_entrega_aprox))}} </label>
                        </div>
                        @else
                        <div class="d-flex w-100 justify-content-between">
                            <b class="mb-1">Fecha Recojo:</b>
                            <label class="text-right"> {{ date('d/m/Y' ,strtotime($transporte->pedido->fecha_recojo_aprox))}} </label>
                        </div>
                        @endif
                        <div class="d-flex w-100 justify-content-between">
                            <b class="mb-1">Codigo:</b>
                            <label class="text-right"> {{$transporte->pedido->codigo}} </label>
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-between">
                        @hasanyrole('super-admin|chofer')
                        @if ($transporte->pedido->pedidoEstado->nombre === 'EN RUTA ENTREGA' || $transporte->pedido->pedidoEstado->nombre === 'EN RUTA RECOJO')
                        <a class="shadow-lg p-3 btn btn-primary" wire:click.prevent="edit({{$transporte->id}})">
                            @if ($transporte->ruta === 'RECOJO')
                            Realizar Recojo
                            @else
                            Realizar Entrega
                            @endif
                        </a>
                        @endif
                        @if ($transporte->completado === 'COMPLETADO' && $transporte->ruta === 'RECOJO')
                        <a class="shadow-lg p-3 btn btn-primary" wire:click.prevent="depositar({{$transporte->id}})">
                            Depositar
                        </a>
                        @endif
                        @endhasanyrole
                        <small class="">{{$transporte->created_at->diffForHumans()}} </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>