<div class="w-100">
    <div>
        <h4>Editar Parte</h4>
        @include('livewire.parte-modelo.form')
        <button wire:click.prevent="update" class="btn btn-primary">
            Actualizar
        </button>
        <button wire:click.prevent="default" class="btn btn-link">
            Cancelar
        </button>
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
</div>