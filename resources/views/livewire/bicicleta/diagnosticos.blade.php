<div class="d-flex flex-column">
    <h4>Diagnosticos</h4>
    <div class="list-group">
        @foreach ($diagnosticos as $diagnostico )
        <a href="{{route('download.diagnostico.bicicleta', $diagnostico->id)}}" class="list-group-item list-group-item-action">Diagnostico #{{$diagnostico->serial}}</a>
        @endforeach
    </div>
    {{ $diagnosticos->links() }}
</div>
