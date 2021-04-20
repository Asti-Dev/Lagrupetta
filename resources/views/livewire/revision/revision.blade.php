<div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="my-3">
                <h2>Pedidos por Revisar </h2>
            </div>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @hasanyrole('jefe mecanicos|super-admin')
    @include("livewire.revision.$view") 
    @endhasanyrole
</div>