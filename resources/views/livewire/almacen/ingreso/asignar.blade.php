<div>
    <div class="col pull-right">
        <a class="btn btn-primary" wire:click.prevent="index()" title="volver">
            <i class="fas fa-backward "></i>
        </a>
    </div>
    <livewire:almacen.ingreso.form :pedido="$pedido">
</div>