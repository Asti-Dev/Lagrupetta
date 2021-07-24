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
                    <input autocomplete="off" list="chofers" wire:model="chofer" wire:change="$emit('updatedChofer')" type="text"
                        name="chofer" id="chofer" class="form-control">
                    <datalist id="chofers">
                        @foreach ($chofers as $chofer)
                        <option value="{{ $chofer->nombre_apellido }}">
                            @endforeach
                    </datalist>
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