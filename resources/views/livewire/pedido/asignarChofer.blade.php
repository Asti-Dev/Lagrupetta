<div class="row d-flex flex-column align-items-center justify-content-center">
    <div class="col pull-right">
        <a class="btn btn-primary" href="{{route('pedidos.index')}}" title="volver">
            <i class="fas fa-backward "></i>
        </a>
    </div>

    <div class="col-7 ">
        <div class="row d-flex justify-content-center">
            <form class="col" wire:submit.prevent="asignar()">
                <div class="form-group">
                    <label for="chofer">Chofer</label>
                    <select class="form-control @error('chofer') is-invalid @enderror" wire:model="chofer" name="chofer">
                        <option value=""> Selecciona un chofer</option>
                        @foreach ($chofers as $chofer)
                        <option value="{{$chofer->nombre_apellido}}">{{$chofer->nombre_apellido}}</option>
                        @endforeach
                    </select>
                    @error('chofer') <span class="text-danger">Escoge un chofer</span> @enderror
                </div>
                <div class="form-group">
                    <label for="distrito">Distrito</label>
                    <select class="form-control @error('distrito') is-invalid @enderror" wire:model="distrito" name="distrito">
                        <option value=""> Selecciona un distrito</option>
                        @foreach ($distritos as $distrito)
                        <option value="{{$distrito}}">{{$distrito}}</option>
                        @endforeach
                    </select>
                    @error('distrito') <span class="text-danger">Escoge un distrito</span> @enderror
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control item @error('direccion') is-invalid @enderror" name="direccion" id="direccion" wire:model="direccion">
                    @error('direccion') <span class="text-danger">Campo Obligatorio</span> @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">asignar</button>
                </div>
            </form>
        </div>
        
    </div>
</div>