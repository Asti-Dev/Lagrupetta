<div wire:poll.10s class="card">
    <div class="card-header">Pedidos por Distrito</div>

    <div class="card-body">
        <div class="row">
          <div class="col form-group pl-0">
            <label for="fechaIni">Desde:</label>
            <input type="date" class="form-control" id="fechaIni" wire:model='fechaIni'>
          </div>
          <div class="col form-group pl-0 ">
            <label for="fechaFin">Hasta:</label>
            <input type="date" class="form-control" id="fechaFin" wire:model='fechaFin'>
          </div>
        </div>
    
    <div id="chart3" ></div>
    </div>
</div>

@push('scripts')
<script>
var options3 = {
    chart: {
      type: 'bar',
      animations: {
          enabled: false,
      },
      
      zoom: {
          enabled: false,
      },
      height: 500
    },
    plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
    },
    series: [{
      name: 'Pedidos',
      data: @json($pedidosPorDistrito)
    }],
    xaxis: {
      categories: @json($distritos)
    }
  }
  
  var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
  
  chart3.render();

  document.addEventListener('livewire:load', () => {
      @this.on('refreshChart3', (chartData) => {
          chart3.updateSeries([{
              data: chartData.pedidosPorDistrito
          }])
      })
  })
</script>
@endpush
