<div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="my-3">
                <h2>Pedidos por Corregir </h2>
            </div>
        </div>
    </div>
    <table class="table table-borderless table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Prueba </th>
                <th scope="col" class="text-success"> Completado </th>
                <th scope="col">Comentario del Jefe</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pruebas as $key => $prueba)
            <tr wire:key='{{$key}}'>
                <th scope="row" width="40%">
                    {{$prueba->nombre}}
                </th>
                <td>
                    <div class="input-group-lg">
                        <label for="completado{{$key}}" class="input-group-prepend">
                            <div class="input-group-text">
                                <input wire:click="checkCorregir()" wire:model="pruebasR.{{$key}}.completado"
                                type="checkbox" name="completado[]" id="completado{{$key}}"/>
                            </div>
                        </label>
                    </div>
                </td>
                <td>
                    <b>
                        {{$prueba->pivot->comentario ?? 'Sin comentario'}}
                    </b>
                    <div class="form-group">
                        <label for="respuesta{{$key}}">Respuesta</label>
                        <textarea class="form-control" wire:change='checkCorregir()' wire:model="pruebasR.{{$key}}.respuesta" name="respuesta[]"
                        id="respuesta{{$key}}" rows="2"></textarea>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-around">
        <button wire:click.prevent="save()" class="btn btn-primary">Revisar</button>
    </div>
</div>
