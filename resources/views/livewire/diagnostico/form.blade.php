<div>
    <form>
        <table class="table table-borderless table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Parte</th>
                    <th scope="col"> N/A </th>
                    <th scope="col" class="text-success"> 0 % </th>
                    <th scope="col" class="text-success"> 25 % </th>
                    <th scope="col" class="text-warning"> 50 % </th>
                    <th scope="col" class="text-danger"> 75 % </th>
                    <th scope="col">Comentario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partes as $key => $parte)
                <tr wire:key='{{$key}}'>
                    <th scope="row" width="40%">
                        <b>{{$parte->parteModelo->nombre}}</b>
                        @error('porcentajes.' . $key) <span class="text-danger">Porcentaje Requerido</span> @enderror
                        <div class="col form-group" style="display: none">
                            <input type="text" name="parteId[]" class="form-control" value="{{$parte->id}}">
                            <input type="text" name="parteNombre[]" class="form-control" value="{{$parte->parteModelo->nombre}}">
                        </div>
                    </th>
                    <td>
                        <label for="porcentaje{{$key}}0" class="input-group-prepend">
                            <div class="input-group-text @error('porcentajes.' . $key) border-danger @enderror">
                                <input type="radio" 
                                    name="porcentaje[{{$key}}]" wire:model='porcentajes.{{$key}}.{{$key}}' id="porcentaje{{$key}}0" value="N/A">
                            </div>
                        </label>
                    </td>
                    <td>
                        <label for="porcentaje{{$key}}1" class="input-group-prepend">
                            <div class="input-group-text @error('porcentajes.' . $key) border-danger @enderror">
                                <input type="radio" 
                                    name="porcentaje[{{$key}}]" wire:model='porcentajes.{{$key}}.{{$key}}' id="porcentaje{{$key}}1" value="0%">
                            </div>
                        </label>
                    </td>
                    <td>
                        <label for="porcentaje{{$key}}2" class="input-group-prepend">
                            <div class="input-group-text @error('porcentajes.' . $key) border-danger @enderror">
                                <input type="radio" 
                                    name="porcentaje[{{$key}}]"  wire:model='porcentajes.{{$key}}.{{$key}}' id="porcentaje{{$key}}2" value="25%">
                            </div>
                        </label>
                    </td>
                    <td>
                        <label for="porcentaje{{$key}}3"  wire:model='porcentajes.{{$key}}.{{$key}}' class="input-group-prepend">
                            <div class="input-group-text @error('porcentajes.' . $key) border-danger @enderror">
                                <input type="radio" 
                                    name="porcentaje[{{$key}}]" id="porcentaje{{$key}}3" value="50%">
                            </div>
                        </label>
                    </td>
                    <td>
                        <label for="porcentaje{{$key}}4" wire:model='porcentajes.{{$key}}.{{$key}}' class="input-group-prepend">
                            <div class="input-group-text @error('porcentajes.' . $key) border-danger @enderror">
                                <input type="radio" 
                                    name="porcentaje[{{$key}}]" id="porcentaje{{$key}}4" value="75%">
                            </div>
                        </label>
                    </td>
                    <td>
                        <div class="form-group">
                            <textarea class="form-control" 
                                name="comentario[]" rows="2"></textarea>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <table class="table table-borderless table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Parte</th>
                    <th scope="col">Nro de serie</th>
                    <th scope="col">Comentario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partes2 as $key => $parte)
                <tr>
                    <th scope="row">{{$parte->parteModelo->nombre}}
                        <div class="col form-group" style="display: none">
                            <input type="text" name="parteId2[]" class="form-control" value="{{$parte->id}}">
                            <input type="text" name="parteNombre2[]" class="form-control" value="{{$parte->parteModelo->nombre}}">
                        </div>
                    </th>
                    <td>
                        <div class="form-group">
                            <input type="text" class="form-control" 
                                name="detalle2[]">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <textarea class="form-control"
                                name="comentario2[]" rows="2"></textarea>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="form-group row">
            <label for="inventario" class="col-sm-4 font-weight-bold">Inventario</label>
            <div class="form-group col-sm-8">
                <input class="form-control" name="inventario" id="inventario">
            </div>
        </div>
        <div class="form-group row">
            <label for="comentarioMecanicoDiag" class="col-sm-4 font-weight-bold">Comentario General Mecanico</label>
            <div class="form-group col-sm-8">
                <textarea class="form-control"
                    name="comentarioMecanicoDiag" id="comentarioMecanicoDiag" rows="2"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="color" class="col-sm-4 font-weight-bold">Color de Bicicleta</label>
            <div class="form-group col-sm-8">
                <input class="form-control" name="color" id="color">
            </div>
        </div>
    </form>

</div>