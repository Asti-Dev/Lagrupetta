<div>
    <div class="row">
        <div class="">
            <a class="btn btn-primary" href="{{ route('repuestos.index') }}" title="Go back"> <i
                    class="fas fa-backward "></i> </a>
        </div>
        <div class="col-lg-12 margin-tb">
            <div class="my-3">
                <h2>Importar Repuestos </h2>
            </div>
        </div>
    </div>
    

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="row">
        <div class="col">
        <h5>Nota Importante!!</h5>
        <p>Para usar la importacion se tiene que subir un archivo excel
            siguiendo la plantilla que tiene <b>Exportar Repuestos.</b> </p>
        <p>Ademas se debe tener en cuenta lo siguiente:</p>
        <ol>
            <li>La columna <b>"Nro"</b> identifica al repuesto. si se coloca una fila con un Nro que ya existe, 
                se procederá a actualizar la informacion de el repuesto que tenga ese Nro</li>
            <li>
                Si se desea agregar un Repuesto nuevo, colocar un Nro que no exista en la base de datos.
            </li>
            <li>
                En las columnas <b>"Disponible" y "Apto Venta"</b>, solo se aceptan las opciones SI Y NO. Cualquier otra opcion puede causar
                 un mal funcionamiento del sistema.
            </li>
            <li>
                NUNCA MODIFICAR LOS NOMBRES DE LAS COLUMNAS. Esto causaria que no se lea la información del Documento
            </li>
        </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 margin-tb">
            <form wire:submit.prevent="importRepuesto">
                <div class="form-group">
                    <input type="file" wire:model="file" class="form-control
                    @error('file') is-invalid @enderror">
                    @error('file') <span class="text-danger">Archivo no aceptado</span> @enderror

                </div>
                <button type="submit" class="btn btn-primary mb-2">Importar Excel</button>
            </form>
        </div>
    </div>
    
</div>