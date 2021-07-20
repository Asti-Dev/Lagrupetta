<div wire:poll.10s.keep-alive>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="my-3">
                <h2>Pedido Transporte </h2>
            </div>
        </div>
    </div>
    

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @include("livewire.transporte.$view")

</div>
