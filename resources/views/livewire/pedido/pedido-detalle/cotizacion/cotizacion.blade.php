<div class="col-md-8 mt-3 ">
    <livewire:pedido.pedido-detalle.cotizacion.form-paquetes>
    <livewire:pedido.pedido-detalle.cotizacion.form-servicios>
    <livewire:pedido.pedido-detalle.cotizacion.form-repuestos>
    <div class="form-group">
        <label for="fecha_entrega">Fecha de Entrega</label>
        <input type="date" wire:model='fecha' id="fecha_entrega" name="fecha_entrega" min="2021-01-00" class="form-control
        @error('fecha') is-invalid @enderror">
        @error('fecha') <span class="text-danger">Campo Obligatorio</span> @enderror
    </div>
    <div class="form-group">
        <label for="explicacion" class="form-label">Explicacion</label>
        <textarea wire:model.debounce.2s='explicacion' name="explicacion" id="explicacion" rows="3" class="form-control
        @error('explicacion') is-invalid @enderror"></textarea>
        @error('explicacion') <span class="text-danger">Campo Obligatorio</span> @enderror
    </div>
    <div class="form-group">
        <strong>Precio Total:</strong>
        <input readonly type="number" min="0" step="0.01" name="total_precio" class="form-control">
    </div>
</div>

@section('javascript')

<script>
    function totales() {
            var total = 0;
            var Paquetes = document.getElementsByName('preciopaquete[]');
            var sumPaquetes = 0;
            Paquetes.forEach(
                function(value, key, Paquetes) {
                    sumPaquetes += parseFloat(value.value);
                }
            )
            var Servicios = document.getElementsByName('precioservicio[]');
            var sumServicios = 0;
            Servicios.forEach(
                function(value, key, Servicios) {
                    sumServicios += parseFloat(value.value);
                }
            )

            var Repuestos = document.getElementsByName('preciorepuesto[]');
            var sumRepuestos = 0;
            Repuestos.forEach(
                function(value, key, Repuestos) {
                    sumRepuestos += parseFloat(value.value);
                }
            )

            total = parseFloat(sumRepuestos + sumServicios + sumPaquetes).toFixed(2);


            document.getElementsByName('total_precio')[0].value = total;

        }

</script>
@endsection