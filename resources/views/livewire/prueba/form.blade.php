<div class="w-100">
    <div class="form-group">
        <strong>Nombre:</strong>
        <input type="text" wire:model="nombre" name="nombre" class="form-control">
        @error('nombre') <span>{{$message}}</span> @enderror
    </div>
    <div class="form-group">
        <strong>Descripcion:</strong>
        <textarea class="form-control" wire:model="descripcion" name="descripcion" id="descripcion" rows="3"></textarea>
        @error('descripcion') <span>{{$message}}</span> @enderror
    </div>
</div>