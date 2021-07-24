<div>
    <div class="row">
        <div class="col-lg-12 row m-2">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('revisiones.index') }}" title="Go back"> <i
                        class="fas fa-backward "></i> </a>
            </div>
            <div class="">
                <h2>Diagnostico de Salida </h2>
            </div>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @include('livewire.diagnostico.salida')
    
</div>
