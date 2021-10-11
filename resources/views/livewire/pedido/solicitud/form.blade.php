    <form class="col" wire:submit.prevent="update">
        @csrf
        @method('put')
        <div class="form-group row">
            <label for="cliente" class="col-sm-4 col-form-label">Cliente</label>
            <div class="col-sm-8">
            <input autocomplete="off" list="clientes" wire:model="cliente" wire:change="$emit('updatedCliente')"
                type="text" name="cliente" id="cliente" class="form-control">
            <datalist id="clientes">
                @foreach ($clientes as $cliente)
                <option value="{{ $cliente->nombre_apellido }}">{{ $cliente->tipo_doc . ' :     ' . $cliente->nro_doc}}</option>
                @endforeach
            </datalist>  
            </div>      
        </div>
        <div class="form-group row">
            <label for="bicicleta" class="col-sm-4 col-form-label">Bicicletas:</label>
            <div class="col-sm-8">
            <select class="form-control" wire:model="bicicleta.id" name="bicicleta">
                @if (empty($bicicletas))
                    <option value="{{$bicicleta->id}}"> {{$bicicleta->marca}}{{' ' . $bicicleta->modelo}}</option>
                @else
                    <option value=""> Selecciona una bicicleta</option>
                    @foreach ($bicicletas as $bicicleta)
                    <option value="{{$bicicleta->id}}">{{$bicicleta->marca}}{{' ' . $bicicleta->modelo}}</option>
                    @endforeach
                @endif
            </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="distrito" class="col-sm-4 col-form-label">Distrito: {{$distrito}}</label>
            <div class="col-sm-8">
                <select class="form-control" wire:model='distrito' name="distrito" id="distrito">
                    <option value="">Escoge un Distrito</option>
                    @foreach ($distritos as $value)
                    <option value="{{$value}}">{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="direccion">Dirección</label>
            <div class="col-sm-8">
            <input type="text" class="form-control item" name="direccion" id="direccion" wire:model="direccion">
            </div>
        </div>
        <div class="form-group row">
            <label for="chofer" class="col-sm-4 col-form-label">Chofer</label>
            <div class="col-sm-8">
                <select class="form-control" wire:model="chofer" name="Chofer">
                    <option value=""> Selecciona un chofer</option>
                    @foreach ($chofers as $chofer)
                    <option value="{{$chofer->nombre_apellido}}">{{$chofer->nombre_apellido}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="fechaRecojoAprox" class="col-sm-4 col-form-label">Fecha de Recojo: <br> {{date('d/m/Y',strtotime($pedido->fecha_recojo_aprox))}}</label>
            <div class="col-sm-8">
            <input wire:model="fechaRecojoAprox" id="fechaRecojoAprox"
                   name="fechaRecojoAprox" min="2021-01-00"
                    class="form-control" type="date">
            </div>
        </div>
        <div class="form-group row">
            <label for="rango" class="col-sm-4 col-form-label">Rango de Recojo:</label>
            <div class="col-sm-8">
                <select class="form-control" wire:model='rango' name="rango" id="rango_recojo">
                    <option value="">Escoge un rango</option>
                    @foreach ($rangos as $value)
                    <option value="{{$value}}">{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="observacion" class="col-sm-4 col-form-label">Observacion</label>
            <div class="col-sm-8">
            <textarea class="form-control" wire:model.debounce.2s="observacion" name="observacion" id="observacion" rows="3">{{ $observacion }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            Actualizar
        </button>
    </form>
