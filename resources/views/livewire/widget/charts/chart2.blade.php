<div wire:poll.10s class="card">
    <div class="card-header">Pedidos por Area</div>

    <div class="card-body">
      <h5 class="card-title">Facturados: {{$facturados}}</h5>
    <div id="chart2" ></div>

    </div>
</div>

@push('scripts')
<script>
var options2 = {
    chart: {
      type: 'bar',
      animations: {
          enabled: false,
      },
      zoom: {
          enabled: false,
      }
    },
    series: [{
      name: 'Pedidos',
      data: @json($pedidosPorArea)
    }],
    xaxis: {
      categories: @json($areas)
    }
  }
  
  var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
  
  chart2.render();

  document.addEventListener('livewire:load', () => {
      @this.on('refreshChart2', (chartData) => {
          chart2.updateSeries([{
              data: chartData.pedidosPorArea
          }])
      })
  })
</script>
@endpush
