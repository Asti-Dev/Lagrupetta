<div class="row d-flex flex-column align-items-center justify-content-center">
    <div class="col pull-right">
        <a class="btn btn-primary" wire:click.prevent="index()" title="volver">
            <i class="fas fa-backward "></i>
        </a>
        <a class="btn btn-primary"     
                onclick="window.open('{{route('quickClient')}}', 
                'newwindow', 
                'width=500,height=500'); 
                return false;"
                href="#"> Nuevo Cliente </a>
    </div>

    <div class="col-7 ">
        <livewire:pedido.form />
    </div>
</div>