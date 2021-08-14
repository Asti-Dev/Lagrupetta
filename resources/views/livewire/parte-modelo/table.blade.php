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
        @foreach ($parteModelos as $parteModelo)
            <tr>
                <td class="d-flex justify-content-center" style="height: 100px" scope="row">
                    <a class="mx-1" wire:click.prevent="edit({{$parteModelo->id}})">
                        <i class="fas fa-edit  fa-lg"></i>
                    </a>
                    <form class="mx-1" style="width: min-content" wire:submit.prevent="destroy({{$parteModelo->id}})">

                        <button type="submit" onclick="return confirm('¿Estas seguro de borrar esta parte?')" title="delete" style="padding:0px; border: none; background-color:transparent;">
                            <i class="fas fa-trash fa-lg text-danger"></i>
                        </button>
                    </form>
                </td>
                <td>{{ $parteModelo->id }}</td>
                <td>{{ $parteModelo->nombre }}</td>
                <td>{{ $parteModelo->descripcion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $parteModelos->links() }} 