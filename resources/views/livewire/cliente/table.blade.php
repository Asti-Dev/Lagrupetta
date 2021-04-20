<div>
<div class="d-flex align-items-strech my-1">
    <button wire:click.prevent="create" class="btn btn-success">
        Nuevo
    </button>
</div>
<table class="table table-bordered table-responsive-lg">
    <thead class="thead-dark">
        <tr class="">
            <th scope="col">Acciones</th>
            <th scope="col">No </th>
            <th scope="col">Nombre
            </th>
            <th scope="col">Descripcion
            </th>
            <th scope="col">Precio
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($paquetes as $paquete)
            <tr>
                <td class="d-flex justify-content-center" style="height: 100px" scope="row">
                    <a class="mx-1" wire:click.prevent="show({{$paquete->id}})" title="show">
                        <i class="fas fa-eye text-success  fa-lg"></i>
                    </a>
                    <a class="mx-1" wire:click.prevent="edit({{$paquete->id}})">
                        <i class="fas fa-edit  fa-lg"></i>
                    </a>
                    <form class="mx-1" style="width: min-content" wire:submit.prevent="destroy({{$paquete->id}})">

                        <button type="submit" onclick="return confirm('¿Estas seguro de borrar este paquete?')" title="delete" style="padding:0px; border: none; background-color:transparent;">
                            <i class="fas fa-trash fa-lg text-danger"></i>
                        </button>
                    </form>
                </td>
                <td>{{ $paquete->id }}</td>
                <td>{{ $paquete->nombre }}</td>
                <td>{{ $paquete->descripcion }}</td>
                <td>{{ $paquete->precio }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $paquetes->links('pagination::bootstrap-4') }} 
</div>