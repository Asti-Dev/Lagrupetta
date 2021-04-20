<div id="servicioItem{{$count}}" class="col row row-cols-1 row-cols-sm-2 d-flex">
    <div class="col form-group" style="display: none">
        <input type="text" wire:model="servicio.id" name="idservicios[]" class="form-control">
    </div>
    <div class="col form-group d-flex flex-column justify-content-end ">
        <strong>Nombre:</strong>
        <select class="form-control" wire:model="servicio.nombre" wire:change="encontrarServicio()" name="nombreservicio[]">
            <option value=""> Selecciona un Paquete</option>
            @foreach ($listaServicios as $listaServicio)
            <option value="{{$listaServicio->nombre}}">{{ $listaServicio->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="col form-group d-flex flex-column justify-content-end ">
        <strong>Cantidad:</strong>
        <input type="number" min="1" wire:keyup="totalServicio()" wire:model="servicio.cantidad" name="cantidadservicio[]" class="form-control">
    </div>
    <div style="display: none" class="col form-group">
        <input type="number" min="0" step="0.01" wire:model="servicio.precio_unitario" name="preciouniservicio[]" class="form-control">
    </div>
    <div class="col form-group d-flex flex-column justify-content-end ">
        <strong>Precio:</strong>
        <input readonly type="number" min="0" step="0.01" wire:model="servicio.precio" name="precioservicio[]" class="form-control">
    </div>
</div>
