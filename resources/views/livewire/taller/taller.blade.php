<div>
    
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="my-3">
                <h2>Pedidos en Taller </h2>
            </div>
        </div>
    </div>
    

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @hasanyrole('jefe mecanicos|mecanico|super-admin')
    @include("livewire.taller.$view") 
    @endhasanyrole
</div>
