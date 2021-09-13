<div wire:poll.10s.keep-alive class="card">
    <div class="card-header">Pedidos por Mecanico</div>
    <div class="card-body">
    <table class="table table-borderless">
        <thead>
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Cantidad de Pedidos</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($mecanicos as $index => $mecanico)
            <tr>
                <th scope="row">{{$mecanico->nombre_apellido}}</th>
                <td>{{count($mecanico->pedidodDetalles()->whereHas('pedido.pedidoEstado', function($query){
                    $query->whereIn('nombre', ['EN TALLER','COTIZADO','EN PROCESO','EN ESPERA','EN CALIDAD','CORREGIR']);
                })->get())}}
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
      {{ $mecanicos->links() }}
    </div>
</div>
