<div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="my-3">
                <h2>Exportar Pedidos </h2>
            </div>
        </div>
    </div>
    

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-5 margin-tb">
            <form wire:submit.prevent="setFechas">
                <div class="form-group">
                    <label for="fechaInicio">Fecha Inicio</label>
                    <input type="date" class="form-control
                    @error('fechaInicio') is-invalid @enderror" id="fechaInicio" wire:model.lazy="fechaInicio">
                    @error('fechaInicio') <span class="text-danger">Campo Obligatorio</span> @enderror

                </div>
                <div class="form-group">
                    <label for="fechaFinal">Fecha Final</label>
                    <input type="date" class="form-control
                    @error('fechaFinal') is-invalid @enderror" id="fechaFinal" wire:model.lazy="fechaFinal">
                    @error('fechaFinal') <span class="text-danger">Campo Obligatorio</span> @enderror

                </div>
                <button type="submit" class="btn btn-primary mb-2">Descargar Excel</button>
            </form>
        </div>
    </div>
    
</div>
