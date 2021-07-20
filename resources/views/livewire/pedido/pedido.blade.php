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
    @if ($message = Session::get('danger'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

    @include("livewire.pedido.$view")
    
</div>
