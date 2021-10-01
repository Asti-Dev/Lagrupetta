<div>
    <h4>Bicicleta</h4>

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
        <label for="marca">Marca</label>
        <input type="text" class="form-control item" wire:model='marca' name="marca" id="marca" placeholder="marca">
    </div>
    <div class="form-group">
        <label for="modelo">Modelo</label>
        <input type="text" class="form-control item" wire:model='modelo' name="modelo" id="modelo" placeholder="modelo">
    </div>
    <div class="form-group">
        <label for="color">Color</label>
        <input type="text" class="form-control item" wire:model='color' name="color" id="color" placeholder="color">
    </div>
    <div class="form-group">
        <label for="codigo">Codigo</label>
        <input type="text" class="form-control item" wire:model='codigo' name="codigo" id="codigo" placeholder="codigo">
    </div>
</div>
