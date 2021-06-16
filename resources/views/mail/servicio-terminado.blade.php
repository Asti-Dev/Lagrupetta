@component('mail::message')

<h1>Su bicicleta esta Terminada</h1>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td colspan="4" style="padding: 10px" width="33%" align="center">
{{$pedido->cliente->nombre . ' ' . $pedido->cliente->apellido}}
</td>
<td colspan="4" style="padding: 10px" width="33%" align="center">
{{$pedido->cliente->tipo_doc}} {{$pedido->cliente->nro_doc}}
</td>
<td colspan="4" style="padding: 10px" width="34%" align="center">
{{$pedido->cliente->direccion}}
</td>
</tr>
<tr>
<td colspan="12" style="padding: 10px" align="center">
Bicicleta: {{$pedido->bicicleta->marca}} {{$pedido->bicicleta->modelo}}
</td>
</tr>
<tr>
<td colspan="12" style="padding: 10px" align="center">
Su bicicleta ya se encuentra lista en el taller.<br><br>
Se adjunta el diagnostico su estado final.
</td>
</tr>
</table>

@endcomponent