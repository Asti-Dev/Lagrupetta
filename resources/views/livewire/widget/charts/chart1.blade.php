<div wire:poll.10s class="card">
    <div class="card-header">Pedidos por Mes</div>

    <div class="card-body">
        <div class="row">
            <div class="col-4 form-group">
                <select class="form-control" wire:model='year'>
                    @foreach (range(date('Y'),2020) as $x)
                    <option value={{$x}}>{{$x}}</option>
                    @endforeach
                  </select>
            </div>
        </div>
    
    <div id="chart1" ></div>
    </div>
</div>

@push('scripts')
<script>
var options = {
    chart: {
      type: 'line',
      animations: {
          enabled: false,
      },
      zoom: {
          enabled: false,
      }
    },
    series: [{
      name: 'Pedidos',
      data: @json($pedidosPorMes)
    }],
    xaxis: {
      categories: @json($months)
    }
  }
  
  var chart = new ApexCharts(document.querySelector("#chart1"), options);
  
  chart.render();

  document.addEventListener('livewire:load', () => {
      @this.on('refreshChart', (chartData) => {
          chart.updateSeries([{
              data: chartData.pedidosPorMes
          }])
      })
  })
</script>
@endpush