<div class="w-100">
    <h4>Crear Repuesto</h4>
    @include('livewire.repuesto.form')
    <button wire:click.prevent="store" class="btn btn-primary">
        Crear
    </button>
</div>