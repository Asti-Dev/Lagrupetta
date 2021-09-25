<div class="card">
    <div class="card-header">
        <h2 class="mb-0">
            Informacion del Pedido
        </h2>
      </div>
    <div class="accordion" id="accordionExample">
        <div class="card">
          <div class="card-header" id="headingOne">
            <h2 class="mb-0">
              <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                General
              </button>
            </h2>
          </div>
          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <div class="form-group d-flex justify-content-between">
                    <strong>Cliente:</strong>
                    <p class="text-right">{{ ($pedido->cliente->nombre_apellido) ?? '' }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                  <strong>Celular:</strong>
                  <p class="text-right">{{ ($pedido->cliente->telefono) ?? '' }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                  <strong>Email:</strong>
                  <p class="text-right">{{ ($pedido->cliente->email) ?? '' }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                  <strong>{{$pedido->cliente->tipo_doc ?? 'Documento no asignado'}}:</strong>
                  <p class="text-right">{{ ($pedido->cliente->nro_doc) ?? '' }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Bicicleta:</strong>
                    <p class="text-right">{{ ($pedido->bicicleta->marca . ' ' . $pedido->bicicleta->modelo) ?? ''}}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Telefono:</strong>
                    <p class="text-right">{{ $pedido->cliente->telefono ?? ''  }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Observacion Cliente:</strong>
                    <p class="text-right">{{ $pedido->observacion_cliente ?? ''  }}</p>
                </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Recojo del pedido
              </button>
            </h2>
          </div>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <div class="form-group d-flex justify-content-between">
                    <strong>Chofer Recojo:</strong>
                    <p class="text-right">{{$pedido->transporteRecojo->choferTransporte->nombre_apellido ?? ''}}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Direccion de Recojo:</strong>
                    <p class="text-right">{{ $pedido->transporteRecojo->direccion ?? ''  }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Fecha de Recojo:</strong>
                    <p class="text-right">{{
                        isset($pedido->transporteRecojo->fecha_hora_completado) ?
                        date('d/m/Y h:i A' ,strtotime( $pedido->transporteRecojo->fecha_hora_completado) ) :
                        date('d/m/Y',strtotime( $pedido->fecha_recojo_aprox) )
                    }}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <strong>Observacion Chofer Recojo:</strong>
                    <p class="text-right">{{ $pedido->transporteRecojo->observacion_chofer ?? ''  }}</p>
                </div>
            </div>
          </div>
        </div>
        @if (isset($pedido->pedidoDetalle))
        <div class="card">
            <div class="card-header" id="headingThree">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Taller
                </button>
              </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
              <div class="card-body">
                  <div class="form-group d-flex justify-content-between">
                      <strong>LLegada al Taller:</strong>
                      <p class="text-right">{{ $pedido->transporteRecojo->fecha_hora_local ?? ''  }}</p>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                      <strong>Mecanico:</strong>
                      <p class="text-right"> {{ $pedido->pedidoDetalle->mecanicoUno->nombre_apellido ?? ''  }} </p>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                      <strong>Comentario del Diagnostico:</strong>
                      <p class="text-right"> {{ $pedido->pedidoDetalle->diagnostico->comentario ?? ''  }} </p>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                      <strong>Explicacion de Servicios:</strong>
                      <p class="text-right"> {{ $pedido->pedidoDetalle->explicacion ?? ''  }} </p>
                  </div>
              </div>
            </div>
          </div>
          <div class="card">
              <div class="card-header" id="headingFour">
                <h2 class="mb-0">
                  <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Entrega del Pedido
                  </button>
                </h2>
              </div>
              <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                <div class="card-body">
                  <div class="form-group d-flex justify-content-between">
                      <strong>Chofer Entrega:</strong>
                      <p class="text-right">{{$pedido->transporteEntrega->choferTransporte->nombre_apellido ?? ''}}</p>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                      <strong>Direccion de Entrega:</strong>
                      <p class="text-right">{{ $pedido->transporteEntrega->direccion ?? ''  }}</p>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                      <strong>Fecha de Entrega:</strong>
                      <p class="text-right">{{
                          isset($pedido->transporteEntrega->fecha_hora_completado) ?
                          date('d/m/Y h:i A' ,strtotime( $pedido->transporteEntrega->fecha_hora_completado) ) :
                          date('d/m/Y',strtotime( $pedido->pedidoDetalle->fecha_entrega_aprox) )
                      }}</p>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                      <strong>Observacion Chofer Entrega:</strong>
                      <p class="text-right">{{ $pedido->transporteEntrega->observacion_chofer ?? ''  }}</p>
                  </div>
                </div>
              </div>
            </div>
       
        @endif
    </div>
</div>