<div>
    <div class="d-flex align-items-center col-lg-12 margin-tb">
        <div class="my-3 mr-3">
            <h2>Repuestos</h2>
        </div>
        @hasanyrole('super-admin|administrador')
                <a class="btn btn-success" href="{{ route('repuestos.export') }}">
                    <i class="fas fa-file-export"></i>
                    Exportar
                </a>
        @endhasanyrole
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="row d-flex">
    <div class="col m-1">
        @include('livewire.repuesto.table')
    </div>
    <div class="col d-flex flex-column align-items-center">
        @include("livewire.repuesto.$view")
    </div>
</div>