<div>
    @hasanyrole('jefe mecanicos|super-admin')

    <livewire:taller.ingreso.ingreso />

    @endhasanyrole
    
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
    @if ($message = Session::get('danger'))
    <div class="alert alert-danger">
        <p>{{ $message }}</p>
    </div>
    @endif
    @include("livewire.taller.$view") 
</div>
