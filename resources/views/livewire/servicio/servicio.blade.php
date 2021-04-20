<div>
    <div class="col-lg-12 margin-tb">
        <div class="my-3">
            <h2>Servicios</h2>
        </div>

    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="row d-flex">
    <div class="col m-1">
        @include('livewire.servicio.table')
    </div>
    <div class="col d-flex flex-column align-items-center">
        @include("livewire.servicio.$view")
    </div>
</div>