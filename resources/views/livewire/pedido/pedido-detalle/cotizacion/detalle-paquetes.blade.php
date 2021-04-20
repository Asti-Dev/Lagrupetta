<div id="paqueteItem{{$count}}" class="col row row-cols-1 row-cols-sm-2 d-flex">
    <div class="col form-group" style="display: none">
        <input type="text" wire:model="paquete.id" name="idpaquetes[]" class="form-control">
    </div>
    <div class="col form-group d-flex flex-column justify-content-end ">
        <strong>Nombre:</strong>
        <select class="form-control" wire:model="paquete.nombre" wire:change="encontrarPaquete()" name="nombrepaquete[]">
            <option value=""> Selecciona un Paquete</option>
            @foreach ($listaPaquetes as $listaPaquete)
            <option value="{{$listaPaquete->nombre}}">{{ $listaPaquete->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="col form-group d-flex flex-column justify-content-end ">
        <strong>Descripcion:</strong>
        <textarea readonly type="text" wire:model="paquete.descripcion" name="descripcion[]"
            class="form-control"></textarea>
    </div>
    <div class="col form-group d-flex flex-column justify-content-end ">
        <strong>Cantidad:</strong>
        <input type="number" min="1" wire:keyup="totalPaquete()" wire:model="paquete.cantidad" name="cantidadpaquete[]" class="form-control">
    </div>
    <div style="display: none" class="col form-group">
        <input type="number" min="0" step="0.01" wire:model="paquete.precio_unitario" name="preciounipaquete[]" class="form-control">
    </div>
    <div class="col form-group d-flex flex-column justify-content-end ">
        <strong>Precio:</strong>
        <input readonly type="number" min="0" step="0.01" wire:model="paquete.precio" name="preciopaquete[]" class="form-control">
    </div>
</div>

