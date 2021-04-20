<table class="table table-bordered table-responsive-lg">
    <thead class="thead-dark">
        <tr class="">
            <th scope="col">Acciones</th>
            <th scope="col">No </th>
            <th scope="col">Nombre
            </th>
            <th scope="col">Descripcion
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pruebas as $prueba)
            <tr>
                <td class="d-flex justify-content-center" style="height: 100px" scope="row">
                    <a class="mx-1" wire:click.prevent="edit({{$prueba->id}})">
                        <i class="fas fa-edit  fa-lg"></i>
                    </a>
                    <form class="mx-1" style="width: min-content" wire:submit.prevent="destroy({{$prueba->id}})">

                        <button type="submit" onclick="return confirm('¿Estas seguro de borrar esta prueba?')" title="delete" style="padding:0px; border: none; background-color:transparent;">
                            <i class="fas fa-trash fa-lg text-danger"></i>
                        </button>
                    </form>
                </td>
                <td>{{ $prueba->id }}</td>
                <td>{{ $prueba->nombre }}</td>
                <td>{{ $prueba->descripcion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $pruebas->links('pagination::bootstrap-4') }} 