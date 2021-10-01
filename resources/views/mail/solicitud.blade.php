@component('mail::message')
@if (empty($url))

<h1>Su solicitud de recojo ha sido cancelada.</h1>
@else
<h1>Le damos la bienvenida a nuestro Taller</h1>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td colspan="4" style="padding: 10px" width="33%" align="center">
{{$pedido->cliente->nombre_apellido}}
</td>
<td colspan="4" style="padding: 10px" width="33%" align="center">
{{$pedido->cliente->tipo_doc}} {{$pedido->cliente->nro_doc}}
</td>
<td colspan="4" style="padding: 10px" width="34%" align="center">
{{$pedido->transporteRecojo->distrito}}, {{$pedido->transporteRecojo->direccion}}
</td>
</tr>
<tr>
<td colspan="8" style="padding: 10px" align="center">
Bicicleta: {{$pedido->bicicleta->marca}} {{$pedido->bicicleta->modelo}}
</td>
<td colspan="4"> 
</td>
</tr>
<tr>
<th colspan="4" style="padding: 10px" align="center">
Observacion
</th>
<td colspan="8" style="padding: 10px" align="center">
{{$pedido->observacion_cliente}}
</td>
</tr>
</table>
<br><br>
<b>
Fecha de Recojo: {{$hoy}} Rango: {{$pedido->rango_recojo}}
</b>
<table>
</table>
@endif

@endcomponent