<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="">
                <h2>Registro de pedidos </h2>
            </div>
        </div>
    </div>
    

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('danger'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div>
        @hasanyrole('super-admin|administrador')
        <a class="btn btn-success" wire:click.prevent='export'>
            <i class="fas fa-file-export"></i>
            Exportar
        </a>
        @endhasanyrole
        <div class="d-flex align-items-start my-1">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" for="nroPedido">Nro Pedido</label>
              <div class="col-sm-8">
                  <input type="number" class="form-control" id="nroPedido" wire:model="nroPedido">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" for="estado">Estado</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" id="estado" wire:model="estado">
              </div>
            </div>
        </div>
        <table wire:poll.10s class="table table-bordered table-responsive-lg">
            <thead class="thead-dark">
                <tr class="">
                    <th scope="col">Nro Pedido </th>
                    <th scope="col">Estado
                    </th>
                    <th scope="col">Sub Estado
                    </th>
                    <th scope="col">Tiempo de actualizacion
                    </th>
                    <th scope="col">Tiempo de creacion
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->pedido_id }}</td>
                        <td>{{ ($log->eliminado === 1) ? $log->pedidoEstado->nombre . ' ANULADO' :  $log->pedidoEstado->nombre}}</td>
                        <td>{{ $log->sub_estado }}</td>
                        <td>{{ date('d/m/Y h:i A' ,strtotime( $log->created_at) )  }}</td>
                        <td>{{ date('d/m/Y h:i A' ,strtotime( $log->pedido->created_at) )  }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $logs->links() }} 
        </div>
    
</div>

