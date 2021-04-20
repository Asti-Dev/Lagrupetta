<div>

    <table class="table table-borderless table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Prueba </th>
                <th scope="col" class="text-success"> Check </th>
                <th scope="col" class="text-warning"> Corregir </th>
                <th scope="col">Comentario</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pruebas as $key => $prueba)
            <tr wire:key='{{$key}}'>
                <th scope="row" width="40%">
                    {{$prueba->nombre}}
                </th>
                <td>
                    <label for="option{{$key}}1" class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="radio" wire:click="checkCorregir()" wire:model="pruebasR.{{$key}}.corregir" name="option[{{$key}}]"
                                id="option{{$key}}1" value="0" aria-label="Radio button for following text input">
                        </div>
                    </label>
                </td>
                <td>
                    <label for="option{{$key}}2" class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="radio" wire:click="checkCorregir()" wire:model="pruebasR.{{$key}}.corregir" name="option[{{$key}}]"
                                id="option{{$key}}2" value="1" aria-label="Radio button for following text input">
                        </div>
                    </label>
                </td>
                <td>
                    <div class="form-group">
                        <textarea class="form-control" wire:keydown='checkCorregir()' wire:model="pruebasR.{{$key}}.comentario" name="comentario[]"
                            rows="2"></textarea>
                    </div>
                    @if ($prueba->pivot->respuesta ?? '')
                    <div>
                        <label>Respuesta</label>
                        <b>
                            {{$prueba->pivot->respuesta}}
                        </b>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-around">
        @if ($checkC)
        <button wire:click.prevent="save()" class="btn btn-warning">Corregir</button>

        @else
        <button wire:click.prevent="salida()" class="btn btn-success">Diagnosticar Salida</button>
        @endif
    </div>
</div>