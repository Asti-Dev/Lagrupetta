<div class="w-100">
    <h4>Crear Cliente</h4>
   {{--@include('livewire.cliente.form')--}} 
    <button wire:click.prevent="store" class="btn btn-primary">
        Crear
    </button>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Añadir Cliente</h2>
            </div>
            <div class="pull-right">
                <button wire:click.prevent="table" class="btn btn-primary">
                    Regresar
                </button>
            </div>
        </div>
    </div>


    <div class="row d-flex justify-content-center">
        <form class="col-5"  action="{{ route('clientes.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col form-group">
                    <label for="nombre">{{$cliente->nombre}}</label>
                    <input type="text" class="form-control item" name="nombre" id="nombre">
                </div>
                <div class="col form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control item" name="apellido" id="apellido">
                </div>
            </div>
            <div class="row">
                <div class="col form-group">
                    <label for="telefono">Telefono</label>
                    <input type="tel" class="form-control item" name="telefono" id="telefono">
                </div>
                <div class="col form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control item" name="email" id="email">
                </div>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control item" name="direccion" id="direccion">
            </div>
            <div class="row">
            <div class="col form-group">
                <label for="tipo_doc">Tipo de Documento</label>
                <select class="form-control" name="tipo_doc" id="tipo_doc">
                    <option value="">Escoge un Documento</option>
                    @foreach ($tipoDoc as $doc)
                    <option value="{{$doc}}">{{$doc}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col form-group">
                <label for="nro_doc">Número de Documento</label>
                <input type="text" class="form-control item" name="nro_doc" id="nro_doc">
            </div>
            </div>
            <div class="form-group">
                <label for="fecha_cumpleanos">Fecha de Cumpleaños</label>
                <input type="date" name="fecha_cumpleanos" id="fecha_cumpleanos" class="form-control" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Crear</button>
            </div>
        </form>
    </div>
</div>