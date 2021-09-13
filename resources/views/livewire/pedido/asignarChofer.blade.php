<div class="row d-flex flex-column align-items-center justify-content-center">
    <div class="col pull-right">
        <a class="btn btn-primary" wire:click.prevent="index()" title="volver">
            <i class="fas fa-backward "></i>
        </a>
    </div>

    <div class="col-7 ">
        <div class="row d-flex justify-content-center">
            <form class="col" wire:submit.prevent="asignar()">
                <div class="form-group">
                    <label for="chofer">Chofer</label>
                    <select class="form-control" wire:model="chofer" name="chofer">
                        <option value=""> Selecciona un chofer</option>
                        @foreach ($chofers as $chofer)
                        <option value="{{$chofer->nombre_apellido}}">{{$chofer->nombre_apellido}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control item" name="direccion" id="direccion" wire:model="direccion">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">asignar</button>
                </div>
            </form>
        </div>
        
    </div>
</div>