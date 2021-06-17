<table class="table table-bordered table-responsive-lg">
    <thead class="thead-dark">
        <tr class="">
            <th scope="col">Acciones</th>
            <th scope="col">No </th>
            <th scope="col">Nombre
            </th>
            <th scope="col">Precio
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($repuestos as $repuesto)
            <tr>
                <td class="d-flex justify-content-center" style="height: 100px" scope="row">
                    <a class="mx-1" wire:click.prevent="edit({{$repuesto->id}})">
                        <i class="fas fa-edit  fa-lg"></i>
                    </a>
                    <form class="mx-1" style="width: min-content" wire:submit.prevent="destroy({{$repuesto->id}})">

                        <button type="submit" onclick="return confirm('¿Estas seguro de borrar este repuesto?')" title="delete" style="padding:0px; border: none; background-color:transparent;">
                            <i class="fas fa-trash fa-lg text-danger"></i>
                        </button>
                    </form>
                </td>
                <td>{{ $repuesto->id }}</td>
                <td>{{ $repuesto->nombre }}</td>
                <td>{{ $repuesto->precio }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $repuestos->links('pagination::bootstrap-4') }} 