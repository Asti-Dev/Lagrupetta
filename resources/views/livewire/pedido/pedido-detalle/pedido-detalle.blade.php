<div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Lista de Servicios</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('taller.index') }}" title="Go back"> <i
                        class="fas fa-backward "></i> </a>
            </div>
        </div>
    </div>

    <div wire:poll.10s.keep-alive>
        <div class="row  m-3">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch1"  wire:model="status" {{$status == true ? 'checked' : '' }}>
                <label class="custom-control-label" for="customSwitch1">
                    {{$status == true ? 'EN PROCESO' : 'EN ESPERA' }}
                </label>
            </div>
        </div>
        <div class="row">
            @if (count($paquetes)) 
            <div class="col-md py-3 d-flex justify-content-center">
                <div class="card w-100">
                    <div class="card-header">
                        Paquetes
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($paquetes as $paquete)
                        <li class="list-group-item"> {{$paquete->nombre}}
                            <ul class="list-group list-group-flush">
                                @foreach ($paquete->servicios as $paquete_servicio)
                                <li class="list-group-item">

                                    @if (!$paquete_servicio->pedidoDetalles
                                    ->where('id',$pedido->pedidoDetalle->id)
                                    ->where('pivot.paquete_id',$paquete->id)
                                    ->first()->pivot->checked)
                                    <div class="d-flex row w-100 justify-content-between align-items-center">
                                        <div class="col-9">
                                            <label class="m-1">{{ $paquete_servicio->nombre }}
                                                <label class="font-weight-bold text-danger">Pendiente</label>
                                            </label>
                                        </div>
                                        @else
                                        <div class="d-flex row w-100 justify-content-between align-items-center">
                                            <div class="col-9">
                                                <label class="m-1">{{ $paquete_servicio->nombre }}
                                                    <label class="font-weight-bold text-success">Listo</label>
                                                </label>
                                            </div>
                                            @endif
                                            <div class="col-3 d-flex justify-content-around">
                                                <strong class='p-1'>{{$paquete_servicio->pedidoDetalles
                                        ->where('id',$pedido->pedidoDetalle->id)
                                        ->where('pivot.paquete_id',$paquete->id)
                                        ->first()->pivot->cantidad_pendiente}}</strong>
                                                <div>
                                                    @if ($paquete_servicio->pedidoDetalles
                                                    ->where('id',$pedido->pedidoDetalle->id)
                                                    ->where('pivot.paquete_id',$paquete->id)
                                                    ->first()->pivot->cantidad_pendiente
                                                    < $paquete_servicio->pedidoDetalles
                                                        ->where('id',$pedido->pedidoDetalle->id)
                                                        ->where('pivot.paquete_id',$paquete->id)
                                                        ->first()->pivot->cantidad)
                                                        <a class="btn btn-secondary btn-sm"
                                                            wire:click.prevent="addCantPaquete({{$pedido->id}},{{$paquete_servicio->id}},{{$paquete->id}})">
                                                            <i class="fas fa-plus"></i>
                                                        </a>
                                                        @endif
                                                        @if ($paquete_servicio->pedidoDetalles
                                                        ->where('id',$pedido->pedidoDetalle->id)
                                                        ->where('pivot.paquete_id',$paquete->id)
                                                        ->first()->pivot->cantidad_pendiente > 0)
                                                        <a class="btn btn-secondary btn-sm"
                                                            wire:click.prevent="removeCantPaquete({{$pedido->id}},{{$paquete_servicio->id}},{{$paquete->id}})">
                                                            <i class="fas fa-minus"></i>
                                                        </a>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            @if (count($servicios))   
            <div class="col-md py-3 d-flex justify-content-center">
                <div class="card w-100">
                    <div class="card-header">
                        Servicios Adicionales
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($servicios as $key => $servicio)
                        <li class="list-group-item">
                            <div class="d-flex row w-100 justify-content-between align-items-center">
                            @if ($servicio->pivot->checked === 0)
                                <div class="col-9">
                                    <label class="m-1">{{ $servicio->nombre }}
                                        <label class="font-weight-bold text-danger">Pendiente</label>
                                    </label>
                                </div>
                            @else
                                <div class="col-9">
                                    <label class="m-1">{{ $servicio->nombre }}
                                        <label class="font-weight-bold text-success">Listo</label>
                                    </label>
                                </div>
                            @endif
                                <div class="col-3 d-flex justify-content-around">
                                    <strong class='p-1'
                                        style="font-size: 1rem">{{$servicio->pivot->cantidad_pendiente}}</strong>
                                    <div>
                                        @if ($servicio->pivot->cantidad_pendiente
                                        < $servicio->pivot->cantidad)
                                            <a class="btn btn-secondary btn-sm"
                                                wire:click.prevent="addCantServicio({{$pedido->id}},{{$servicio->id}})">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        @endif
                                        @if ($servicio->pivot->cantidad_pendiente > 0)
                                            <a class="btn btn-secondary btn-sm"
                                                wire:click.prevent="removeCantServicio({{$pedido->id}},{{$servicio->id}})">
                                                <i class="fas fa-minus"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            @if (count($repuestos))   
            <div class="col-md py-3 d-flex justify-content-center">
                <div class="card w-100">
                    <div class="card-header">
                        Repuestos
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($repuestos as $key => $repuesto)
                        <li class="list-group-item">
                            <div class="d-flex row w-100 justify-content-between align-items-center">
                            @if ($repuesto->pivot->checked === 0)
                                <div class="col-9">
                                    <label class="m-1">{{ $repuesto->nombre }}
                                        <label class="font-weight-bold text-danger">Pendiente</label>
                                    </label>
                                </div>
                            @else   
                                <div class="col-9">
                                        <label class="m-1">{{ $repuesto->nombre }}
                                            <label class="font-weight-bold text-success">Listo</label>
                                        </label>
                                </div>
                            @endif
                                    <div class="col-3 d-flex justify-content-around">
                                        <strong class='p-1'
                                            style="font-size: 1rem">{{$repuesto->pivot->cantidad_pendiente}}</strong>
                                        <div>
                                            @if ($repuesto->pivot->cantidad_pendiente
                                                < $repuesto->pivot->cantidad)
                                                <a class="btn btn-secondary btn-sm"
                                                    wire:click.prevent="addCantRepuesto({{$pedido->id}},{{$repuesto->id}})">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            @endif
                                            @if ($repuesto->pivot->cantidad_pendiente > 0)
                                                <a class="btn btn-secondary btn-sm"
                                                    wire:click.prevent="removeCantRepuesto({{$pedido->id}},{{$repuesto->id}})">
                                                    <i class="fas fa-minus"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>

        <div class="row m-3">
            @if ($checkTotal === $checkCompletos)
            <button wire:click.prevent="revisar({{$pedido->id}})" class="btn btn-primary">Revisar</button>
            @endif
        </div>
    </div>

</div>