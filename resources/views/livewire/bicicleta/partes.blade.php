<div>
    <h3>Estado actual Partes</h3>
    <table class="table table-borderless">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Parte</th>
            <th scope="col">Porcentaje</th>
            <th scope="col">Comentario</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($partes as $index => $parte)
            <tr>
                <th scope="row">{{$partes->firstItem() + $index}}</th>
                <td>{{$parte->parteModelo->nombre}}</td>
                <td>{{$parte->porcentaje ?? 'no definido'}}</td>
                <td>{{$parte->comentario ?? 'no definido'}}</td>
            </tr>
            @endforeach
        </tbody>
      </table>
      {{ $partes->links() }}
</div>
