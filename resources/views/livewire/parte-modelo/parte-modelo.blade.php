<div>
    <div class="col-lg-12 margin-tb">
        <div class="my-3">
            <h2>Partes</h2>
        </div>
    </div>
    <div class="row d-flex">
    <div class="col m-1">
        @include('livewire.parte-modelo.table')
    </div>
    <div class="col d-flex flex-column align-items-center">
        @include("livewire.parte-modelo.$view")
    </div>
</div>
