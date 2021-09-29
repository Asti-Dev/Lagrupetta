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

    <div class="row d-flex flex-column align-items-center justify-content-center">
        <div class="col pull-right">
            <a class="btn btn-primary"  href="{{route('clientes.index')}}" title="volver">
                <i class="fas fa-backward "></i>
            </a>
            <a class="btn btn-primary"     
                    onclick="window.open('{{route('quickClient')}}', 
                    'newwindow', 
                    'width=500,height=500'); 
                    return false;"
                    href="#"> Nuevo Cliente </a>
        </div>

        <div class="col-7 ">
            <livewire:pedido.form :cliente="$cliente->id"/>
        </div>
    </div>
</div>
