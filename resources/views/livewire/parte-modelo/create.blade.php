<div class="w-100">
    <h4>Crear Parte</h4>
    @include('livewire.parte-modelo.form')
    <button wire:click.prevent="store" class="btn btn-primary">
        Crear
    </button>
</div>