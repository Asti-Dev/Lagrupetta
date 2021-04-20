<div style="max-height: 100vh" class="col-10 overflow-auto">
    <h4>Paquete: {{$nombre}}</h4>
    <table class="table table-bordered table-responsive-lg">
        <thead class="thead-dark">
            <tr class="">
                <th scope="col">No
                </th>
                <th scope="col">servicio
                </th>
                <th scope="col">precio
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicios as $servicio)
                <tr>
                    <td>{{ $servicio->id }}</td>
                    <td>{{ $servicio->nombre }}</td>
                    <td>{{ $servicio->precio }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>