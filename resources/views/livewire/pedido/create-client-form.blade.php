<div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Añadir Cliente</h2>
            </div>
        </div>
    </div>

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

        @if (session()->has('message'))
            <div class="d-flex justify-content-around alert alert-success">
                <p> {{ session('message') }} </p>

                <button type="button" onclick="window.close()" class="btn btn-danger">Cerrar</button>
            </div>
        @endif

    <div class="row d-flex justify-content-center">
        <form class="col"  
        {{-- action="{{ route('clientes.store') }}" --}}
         >
         @if ($step == 0)
            <div class="row">
                <div class="col form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control item" wire:model="nombre" name="nombre" id="nombre">
                </div>
                <div class="col form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control item" wire:model="apellido" name="apellido" id="apellido">
                </div>
            </div>
            <div class="row">
                <div class="col form-group">
                    <label for="telefono">Telefono</label>
                    <input type="tel" class="form-control item" wire:model="telefono" name="telefono" id="telefono">
                </div>
                <div class="col form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control item" wire:model="email" name="email" id="email">
                </div>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control item" wire:model="direccion" name="direccion" id="direccion">
            </div>
            <div class="row">
            <div class="col form-group">
                <label for="tipo_doc">Tipo de Documento</label>
                <select class="form-control" wire:model="tipo_doc" name="tipo_doc" id="tipo_doc">
                    <option value="">Escoge un Documento</option>
                    @foreach ($tipoDoc as $doc)
                    <option value="{{$doc}}">{{$doc}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col form-group">
                <label for="nro_doc">Número de Documento</label>
                <input type="text" class="form-control item" wire:model="nro_doc" name="nro_doc" id="nro_doc">
            </div>
            </div>
            <div class="form-group">
                <label for="fecha_cumpleanos">Fecha de Cumpleaños</label>
                <input type="date" wire:model="fecha_cumpleanos" name="fecha_cumpleanos" id="fecha_cumpleanos" class="form-control" />
            </div>
            <div class="form-group">
                <button type="button"
                wire:click="nextStep"
                class="btn btn-primary">Siguiente</button>
            </div>
            @endif
            @if ($step == 1)
            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" class="form-control item" wire:model="marca" name="marca" id="marca" placeholder="marca">
            </div>
            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" class="form-control item" wire:model="modelo" name="modelo" id="modelo" placeholder="modelo">
            </div>
            <div class="form-group">
                <label for="codigo">Codigo</label>
                <input type="text" class="form-control item" wire:model="codigo" name="codigo" id="codigo" placeholder="codigo">
            </div>
            <div>
                <div class="form-group">
                    <button class="btn btn-secondary" type="button" wire:click="prevStep">
                        Atras
                    </button>
                </div>
            <div class="form-group">
                <button type="button"
                wire:click="save"
                onclick="window.scrollTo(0,0)"
                class="btn btn-primary">Crear</button>
            </div>
            </div>
            @endif




        </form>
    </div>
</div>