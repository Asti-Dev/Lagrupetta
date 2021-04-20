<div class="w-100">
    <div class="form-group">
        <strong>Nombre:</strong>
        <input type="text" wire:model="nombre" name="nombre" class="form-control">
        @error('nombre') <span>{{$message}}</span> @enderror
    </div>
    <div class="form-group">
        <strong>Precio:</strong>
        <input type="number" wire:model="precio" min="0"  step="0.01" name="precio" class="form-control" placeholder="">
        @error('precio') <span>{{$message}}</span> @enderror
    </div>
    <div class="form-group">
        <strong>Activo:</strong>
        <select class="form-control" wire:model="activo" name="activo" id="activo">
            <option value="0">Si</option>
            <option value="1">No</option>
        </select>
    </div>
</div>