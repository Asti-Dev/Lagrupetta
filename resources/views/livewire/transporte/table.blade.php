<div>
    <div class="d-flex">
        <a class="btn btn-success" wire:click="clear()">
            Limpiar
        </a>

        @hasanyrole('super-admin|administrador')
        <div class="col-4">
            <select class="form-control" wire:model="chofer" name="chofer">
                <option value=""> Selecciona un chofer</option>
                @foreach ($chofers as $chofer)
                <option value="{{$chofer->id}}">{{$chofer->nombre_apellido}}</option>
                @endforeach
            </select>
        </div>
        @endhasanyrole
        <div class="col-6 d-flex justify-content-between form-group row">
            <label class="col-sm-6 col-form-label" for="">Fecha de Recojo o Entrega: </label>
            <div class="col-sm-6">
                <select class="form-control" wire:model='selectFecha'>
                    <option value=''>Todas las Fechas</option>
                    <option value='HOY'> HOY </option>
                    <option value='SEMANA'>SEMANA </option>
                    <option value='MES'> MES </option>
                </select>
            </div>
        </div>
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
            <select class="form-control" id="estados" wire:model='ruta'>
                <option value=''>Todas las rutas</option>
                <option value='RECOJO'> RECOJO </option>
                <option value='ENTREGA'>ENTREGA </option>
            </select>
        </div>
        <div class="col d-flex justify-content-between form-group row">
            <label class="col-sm-2 col-form-label" for="cliente">Cliente</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="cliente" wire:model="cliente">
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
                            <b class="mb-1">Cliente Telefono:</b>
                            <label class="text-right">
                                {{$transporte->pedido->cliente->telefono ?? ''}}
                            </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <b class="mb-1">Bicicleta:</b>
                            <label
                                class="text-right">{{$transporte->pedido->bicicleta->marca .' '. $transporte->pedido->bicicleta->modelo}}
                            </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <b class="mb-1">Bicicleta Color:</b>
                            <label
                                class="text-right">{{$transporte->pedido->bicicleta->color}}
                            </label>
                        </div>
                        <div class="d-flex flex-column w-100 justify-content-between">
                            <b class="mb-1">Direccion:</b>
                            <label class="text-right"> {{$transporte->distrito}}, {{$transporte->direccion}} </label>
                        </div>
                        <div class="d-flex flex-column w-100 justify-content-between">
                            <b class="mb-1">Observacion Cliente:</b>
                            <label class="text-right"> {{$transporte->pedido->observacion_cliente}} </label>
                        </div>
                        @if (!empty($transporte->pedido->pedidoDetalle->fecha_entrega_aprox))
                        <div class="d-flex w-100 justify-content-between">
                            <b class="mb-1">Fecha Entrega:</b>
                            <label class="text-right">
                                {{ date('d/m/Y' ,strtotime($transporte->pedido->pedidoDetalle->fecha_entrega_aprox))}}
                            </label>
                        </div>
                        @else
                        <div class="d-flex w-100 justify-content-between">
                            <b class="mb-1">Fecha Recojo:</b>
                            <label class="text-right">
                                {{ date('d/m/Y' ,strtotime($transporte->pedido->fecha_recojo_aprox))}} </label>
                        </div>
                        <div class="d-flex flex-column w-100 justify-content-between">
                            <b class="mb-1">Rango de Recojo:</b>
                            <label class="text-right"> {{$transporte->pedido->rango_recojo}} </label>
                        </div>
                        @endif
                        <div class="d-flex w-100 justify-content-between">
                            <b class="mb-1">Chofer:</b>
                            <label class="text-right">
                                {{$transporte->choferTransporte->nombre_apellido}}
                            </label>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <b class="mb-1">Codigo:</b>
                            <label class="text-right"> {{$transporte->pedido->codigo}} </label>
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-between">
                        @hasanyrole('super-admin|chofer')
                        @if ($transporte->pedido->pedidoEstado->nombre === 'EN RUTA ENTREGA' ||
                        $transporte->pedido->pedidoEstado->nombre === 'EN RUTA RECOJO')
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
                        @if ($transporte->pedido->pedidoEstado->nombre === 'TERMINADO')
                            <a  wire:click.prevent="retirar({{$transporte->pedido->id}})"class="btn btn-primary">Retirar</a>
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