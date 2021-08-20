<div class="w-100">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-center">
                <a class="btn btn-sm btn-primary" wire:click='index()' title="Go back"> <i class="fas fa-backward "></i> </a>
                <h4 class="ml-3 m-0">{{$transporte->ruta}}</h4>
        </div>
    </div>
    
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