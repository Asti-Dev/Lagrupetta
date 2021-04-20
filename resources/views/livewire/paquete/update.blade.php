<div class="w-100">
    <h4>Editar Paquete</h4>
    @include('livewire.paquete.form')
    <button wire:click.prevent="update" class="btn btn-primary">
        Actualizar
    </button>
    <button wire:click.prevent="default" class="btn btn-link">
        Cancelar
    </button>
</div>