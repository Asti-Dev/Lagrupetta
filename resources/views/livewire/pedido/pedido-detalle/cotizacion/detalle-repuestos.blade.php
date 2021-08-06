<div id="repuestoItem{{$count}}" class="col row row-cols-1 row-cols-sm-2 d-flex">
    <div class="col form-group" style="display: none">
        <input type="text" wire:model="repuesto.id" name="idrepuestos[]" class="form-control">
    </div>
    <div class="col form-group d-flex flex-column justify-content-end ">
        <strong>Nombre:</strong>
        <input autocomplete="off" list="repuestos" wire:model="repuesto.nombre" wire:keyup="encontrarRepuesto()"
                type="text" name="nombrerepuesto[]" class="form-control">
            <datalist id="repuestos">
                @foreach ($listaRepuestos as $listaRepuesto)
                <option value="{{$listaRepuesto->nombre}}">
                @endforeach
            </datalist>  
            
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
</div>

