
<div class="card col my-2 p-0">
    <div class="card-header col py-2 d-flex justify-content-between">
        <strong>Paquetes</strong>
        <a style="cursor: pointer" wire:click="addPaquete"><i style="font-size: 1.5rem; color:green"
                class="fas fa-plus"></i></a>
    </div>
    <div style="background: honeydew" class="card-body w-100 d-flex flex-column align-items-center">
        @foreach ($orderPaquetes as $index => $orderPaquete)

            @livewire('pedido.pedido-detalle.cotizacion.detalle-paquetes', ['orderPaquete'=> $orderPaquete , 'index' => $index], key($index))
            <div class="col-12 row d-flex justify-content-end">
                <a style="cursor: pointer" wire:click.prevent="removePaquete({{$index}})">
                    <i style="font-size: 1.5rem; color:red" class="fas fa-window-close"></i>
                </a>
            </div>
            <hr class="w-100" style="height:1rem; color: black">

        @endforeach
    </div>
</div>
