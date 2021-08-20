@component('mail::message')
# Pedido {{$pedido->id}}
Estos son los servicios sugeridos.
Se adjunta un pdf con el diagnostico

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td colspan="4" style="padding: 10px" width="33%" align="center">
{{$pedido->cliente->nombre_apellido}}
</td>
<td colspan="4" style="padding: 10px" width="33%" align="center">
{{$pedido->cliente->tipo_doc}} {{$pedido->cliente->nro_doc}}
</td>
<td colspan="4" style="padding: 10px" width="34%" align="center">
{{$pedido->cliente->direccion}}
</td>
</tr>
<tr>
<td colspan="10" style="padding: 10px" align="center">
Bicicleta: {{$pedido->bicicleta->marca}} {{$pedido->bicicleta->modelo}}
</td>
<td colspan="2" style="padding: 10px" align="center">
</td>
</tr>
@if (!empty($pedido->pedidoDetalle->paquetes()))
<tr>
<th colspan="4" style="padding: 10px" align="center">
Paquetes
</th>
<td colspan="8" style="padding: 10px" align="center">
<ul>   
@foreach ($pedido->pedidoDetalle->paquetes->unique(); as $paquete)
<li>
{{$paquete->nombre}} x{{$paquete->pedidoDetalles->find($pedido->pedidoDetalle->id)->pivot->cantidad}} 
: S/.{{$paquete->pedidoDetalles->find($pedido->pedidoDetalle->id)->pivot->precio_final}}
</li>
@endforeach
</ul>
</td>
</tr>
@endif
@if (!empty($pedido->pedidoDetalle->servicios()))
<tr>
<th colspan="4" style="padding: 10px" align="center">
Servicios
</th>
<td colspan="8" style="padding: 10px" align="center">
<ul>
@foreach ($pedido->pedidoDetalle->servicios()
->wherePivot('paquete_id', null)->get() as $servicio)
<li>
{{$servicio->nombre}} x{{$servicio->pedidoDetalles->find($pedido->pedidoDetalle->id)->pivot->cantidad}}
 : S/.{{$servicio->pedidoDetalles->find($pedido->pedidoDetalle->id)->pivot->precio_final}}
</li>
@endforeach
</ul>
</td>
</tr>
@endif
@if (!empty($pedido->pedidoDetalle->repuestos()))
<tr>
<th colspan="4" style="padding: 10px" align="center">
Repuestos
</th>
<td colspan="8" style="padding: 10px" align="center">
<ul>
@foreach ($pedido->pedidoDetalle->repuestos as $repuesto)
<li>
{{ $repuesto->nombre }} x {{$repuesto->pivot->cantidad}}
 : S/.{{$repuesto->pivot->precio_final}}
</li>
@endforeach
</ul>
</td>
</tr>
@endif
@if (!empty($pedido->pedidoDetalle->servicios()) || !empty($pedido->pedidoDetalle->paquetes()))
<tr>
<th colspan="4" style="padding: 10px" align="center">
Total
</th>
<td colspan="8" style="padding: 10px" align="center">
S/.{{$pedido->pedidoDetalle->precio_final}}
</td>
</tr>
@endif
@if (!empty($url))
<tr>
<th colspan="4" style="padding: 10px" align="center">
Explicacion
</th>
<td colspan="8" style="padding: 10px" align="center">
{{$pedido->pedidoDetalle->explicacion}}
</td>
</tr>
</table>
<b>
Caso se rechace la cotizacion, se cobrara el Diagnostico de forma obligatoria (Costo: S/.50.00)
</b>
<table>
<tr>
<td>
@component('mail::button', ['url' => $url['aceptar'],'color'=>'green'])
Aceptar
@endcomponent
</td>
<td>
@component('mail::button', ['url' => $url['rechazar'],'color'=>'red'])
Rechazar
@endcomponent
</td>
<td>
@component('mail::button', ['url' => 'https://api.whatsapp.com/send?phone=51943304475&text=Hola%2C%20deseo%20modificar%20mi%20pedido','color'=>'blue'])
Modificar
@endcomponent
</td>
</tr>
</table>
@endif



@endcomponent