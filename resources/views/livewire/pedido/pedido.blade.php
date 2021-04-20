<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="">
                <h2>Pedidos </h2>
            </div>
        </div>
    </div>
    

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @hasanyrole('administrador|super-admin')

    @include("livewire.pedido.$view")
    
    @endhasanyrole

</div>
