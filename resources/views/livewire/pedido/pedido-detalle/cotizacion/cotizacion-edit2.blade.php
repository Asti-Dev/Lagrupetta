<div>
    <div style="background-color:skyblue" class='d-flex flex-column align-items-center px-1'>
    <form  class=""
        action="{{ route('cobranza.update', $pedido->pedidoDetalle->id) }}" method="POST">
        @csrf
        @method('PUT')
    <livewire:pedido.pedido-detalle.cotizacion.form-paquetes :pedido="$pedido">
    <livewire:pedido.pedido-detalle.cotizacion.form-servicios :pedido="$pedido">
    <livewire:pedido.pedido-detalle.cotizacion.form-repuestos :pedido="$pedido">

    <div class="form-group">
        <label for="fecha_entrega">Fecha de Entrega</label>
        <input wire:model='fechaEntrega' type="date" id="fecha_entrega" name="fecha_entrega" min="2021-01-00" class="form-control
        @error('fechaEntrega') is-invalid @enderror">
        @error('fechaEntrega') <span class="text-danger">Campo Obligatorio</span> @enderror
    </div>
    <div class="form-group">
        <label for="explicacion" class="form-label">Explicacion</label>
        <textarea wire:model='explicacion' name="explicacion" id="explicacion" rows="3" class="form-control
        @error('explicacion') is-invalid @enderror">{{$explicacion}}</textarea>
        @error('explicacion') <span class="text-danger">Campo Obligatorio</span> @enderror
    </div>
    <div class="form-group">
        <strong>Precio Total:</strong>
        <input readonly wire:model='precioTotal' type="number" min="0" step="0.01" name="total_precio" class="form-control">
        @error('total_precio') <span>{{$message}}</span> @enderror
    </div>
    <div class="form-group">
        <button type="submit" onclick="totales()" 
            class="btn btn-primary">Cotizar</button>
    </div>
    </form>
    </div>
</div>

@section('javascript')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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