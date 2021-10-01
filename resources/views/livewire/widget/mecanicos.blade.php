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
                <td>{{$mecanico->pedidod_detalles_count}}
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
</div>
