<div id="repuestoItem{{$count}}" class="col row row-cols-1 row-cols-sm-2 d-flex">
    <div class="col form-group" style="display: none">
        <input type="text" wire:model="repuesto.id" name="idrepuestos[]" class="form-control">
    </div>
    <div class="col form-group d-flex flex-column justify-content-end ">
        <strong>Nombre:</strong>
            <select class="form-control" wire:model="repuesto.nombre" wire:change="encontrarRepuesto()" name="nombrerepuesto[]">
                <option value=""> Selecciona un Repuesto</option>
                @foreach ($listaRepuestos as $listaRepuesto)
                <option value="{{$listaRepuesto->nombre}}">{{ $listaRepuesto->nombre }}</option>
                @endforeach
            </select>
            
    </div>
    <div class="col form-group d-flex flex-column justify-content-end ">
        <strong>Cantidad:</strong>
        <input type="number" min="1" wire:keyup="totalRepuesto()" wire:model="repuesto.cantidad" name="cantidadrepuesto[]" class="form-control">
    </div>
    <div style="display: none" class="col form-group">
        <input type="number" min="0" step="0.01" wire:model="repuesto.precio_unitario" name="preciounirepuesto[]" class="form-control">
    </div>
    <div class="col form-group d-flex flex-column justify-content-end ">
        <strong>Precio:</strong>
        <input readonly type="number" min="0" step="0.01" wire:model="repuesto.precio" name="preciorepuesto[]" class="form-control">
    </div>
    <div class="col form-group d-flex flex-column justify-content-end ">
        <strong>Disponible:</strong>
        <strong>{{$repuesto['disponible']}}</strong>
    </div>
</div>

