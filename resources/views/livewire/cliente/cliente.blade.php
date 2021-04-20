<div>
    <div class="col-lg-12 margin-tb">
        <div class="my-3">
            <h2>Clientes</h2>
        </div>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Hubo un problema con los datos ingresados<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row d-flex">
        <div class="col d-flex flex-column align-items-center">
            @include("livewire.cliente.create")
        </div>
    </div>
</div>