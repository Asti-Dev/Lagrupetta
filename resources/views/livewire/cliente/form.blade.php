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
    <div class="form-group">
        <strong>Precio:</strong>
        <input type="number" wire:model="precio" min="0"  step="0.01" name="precio" class="form-control" placeholder="">
        @error('precio') <span>{{$message}}</span> @enderror
    </div>
 
    <div class="form-group">
        <strong>Servicios</strong>
        <div style="background:white; border:lightgrey solid 1.5px ;height: 120px; overflow-y: scroll">
        @foreach ($serviciosSelect as $index => $servicio)
        <label class="w-100">
            <input autocomplete="off" wire:model="nombresServicio.{{$servicio->id}}" 
              value="{{$servicio->id}}" type="checkbox">  
            {{$servicio->nombre}}   
        </label>
        @endforeach
        </div>
    </div>
</div>