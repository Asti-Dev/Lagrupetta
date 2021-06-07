    <form class="col" wire:submit.prevent="update">
        @csrf
        @method('put')
        <div class="form-group row">
            <label for="cliente" class="col-sm-4 col-form-label">Cliente</label>
            <div class="col-sm-8">
            <input autocomplete="off" list="clientes" wire:model="cliente" wire:change="$emit('updatedCliente')"
                type="email" name="cliente" id="cliente" class="form-control">
            <datalist id="clientes">
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->user->email }}">
                @endforeach
            </datalist>  
            </div>      
        </div>
        <div class="form-group row">
            <label for="bicicleta" class="col-sm-4 col-form-label">Bicicletas:</label>
            <div class="col-sm-8">
            <select class="form-control" wire:model="bicicleta.id" name="bicicleta">
                @if (empty($bicicletas))
                    <option value="{{$bicicleta->id}}"> {{$bicicleta->marca}}{{' ' . $bicicleta->modelo}}</option>
                @else
                    <option value=""> Selecciona una bicicleta</option>
                    @foreach ($bicicletas as $bicicleta)
                    <option value="{{$bicicleta->id}}">{{$bicicleta->marca}}{{' ' . $bicicleta->modelo}}</option>
                    @endforeach
                @endif
            </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="chofer" class="col-sm-4 col-form-label">Chofer</label>
            <div class="col-sm-8">
            <input autocomplete="off" list="chofers" wire:model="chofer" wire:change="$emit('updatedChofer')"
                type="text" name="Chofer" id="Chofer" class="form-control">
            <datalist id="chofers">
                @foreach ($chofers as $chofer)
                    <option value="{{ $chofer->nombre_apellido }}">
                @endforeach
            </datalist> 
            </div>
        </div>
        <div class="form-group row">
            <label for="fechaRecojoAprox" class="col-sm-4 col-form-label">Fecha de Recojo: <br> {{date('d/m/Y',strtotime($pedido->fecha_recojo_aprox))}}</label>
            <div class="col-sm-8">
            <input wire:model="fechaRecojoAprox" id="fechaRecojoAprox"
                   name="fechaRecojoAprox" min="2021-01-00"
                    class="form-control" type="date">
            </div>
        </div>
        <div class="form-group row">
            <label for="observacion" class="col-sm-4 col-form-label">Observacion</label>
            <div class="col-sm-8">
            <textarea class="form-control" wire:model="observacion" name="observacion" id="observacion" rows="3">{{ $observacion }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="confirmacion" class="col-sm-4 col-form-label">Estado:</label>
            <div class="col-sm-8">
            <select class="form-control" wire:model="confirmacion" name="confirmacion">
                    @foreach ($estados as $estado)
                    <option value="{{$estado}}">{{$estado}}</option>
                    @endforeach
            </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            Actualizar
        </button>
    </form>
