<div class="d-flex flex-column">
    <h4>Diagnosticos</h4>
    <div class="list-group">
        @foreach ($diagnosticos as $diagnostico )
        <a href="{{route('download.diagnostico.bicicleta', $diagnostico->id)}}" class="list-group-item list-group-item-action">
            <div class="d-flex justify-content-between">
                @if ($diagnostico->salida == 1)
                <p>Informe Final #{{$diagnostico->serial}}</p>
                @else
                <p>Diagnostico #{{$diagnostico->serial}}</p>
                @endif
                <span>{{date('d/m/Y h:i A',strtotime($diagnostico->created_at))}}</span>
            </div>
        </a>
        @endforeach
    </div>
    {{ $diagnosticos->links() }}
</div>
