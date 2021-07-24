<form  wire:submit.prevent="store">
    <div class="form-group">
        <label for="cliente">Cliente</label>
        <input autocomplete="off" list="clientes" wire:model="cliente" wire:change="$emit('updatedCliente')" type="text"
            name="cliente" id="cliente" class="form-control">
        <datalist class="w-100" id="clientes">
            @foreach ($clientes as $cliente)
            <option value="{{ $cliente->nombre_apellido }}">{{ $cliente->tipo_doc . ' :     ' . $cliente->nro_doc}}</option>
                @endforeach
        </datalist>
    </div>
    <div class="form-group">
        <strong>Bicicletas:</strong>
        <select class="form-control" wire:model="bicicleta" name="bicicleta">
            <option value=""> Selecciona una bicicleta</option>
            @foreach ($bicicletas as $bicicleta)
            <option value="{{$bicicleta->id}}">{{$bicicleta->marca . ' ' . $bicicleta->modelo}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="direccion">Dirección</label>
        <input type="text" class="form-control item" name="direccion" id="direccion" wire:model="direccion">
    </div>
    <div class="form-group">
        <label for="chofer">Chofer</label>
        <input autocomplete="off" list="chofers" wire:model="chofer" wire:change="$emit('updatedChofer')" type="text"
            name="chofer" id="chofer" class="form-control">
        <datalist id="chofers">
            @foreach ($chofers as $chofer)
            <option value="{{ $chofer->nombre_apellido }}">
                @endforeach
        </datalist>
    </div>
    <div class="form-group">
        <label for="fechaRecojoAprox">Fecha de Recojo</label>
        <input type="date" wire:model="fechaRecojoAprox" id="fechaRecojoAprox" name="fechaRecojoAprox" min="2021-01-00" class="form-control">
    </div>
    <div class="form-group">
        <label for="observacion" class="form-label">Observacion</label>
        <textarea class="form-control" wire:model="observacion" name="observacion" id="observacion" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">
        Crear
    </button>
</form>