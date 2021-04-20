<div class="row d-flex justify-content-center">
    <form class="col" wire:submit.prevent="asignar">
        <div class="form-group">
            <label for="mecanico">Mecanico</label>
            <input autocomplete="off" list="mecanicos" wire:model="mecanico" wire:change="$emit('updatedMecanico')"
                type="text" name="Mecanico" id="Mecanico" class="form-control">
            <datalist id="mecanicos">
                @foreach ($mecanicos as $mecanico)
                    <option value="{{ $mecanico->nombre_apellido }}">
                @endforeach
            </datalist>  
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">asignar</button>
        </div>
    </form>
</div>
