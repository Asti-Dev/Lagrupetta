<div class="w-100">
    <h4>{{$transporte->ruta}}</h4>
    @include('livewire.transporte.form')
    <div class="d-flex justify-content-around">
    <button wire:click.prevent="completado()" class="btn btn-success">
        Completado
    </button>
    <button wire:click.prevent="fallido()" class="btn btn-danger">
        Fallido
    </button>
    </div>
</div>