@extends('layouts.simple')


@section('content')
<table style="text-align: center" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="2">logo</td>
        <td colspan="6">
            <h2 >Lagrupetta</h2>
            <h3>Diagnostico {{$serial ?? ''}}</h3>
        </td>
        <td colspan="4">
            <div>lagrupetta.pe@gmail.com <br>
                Telf: 943 304 475  </div>

            <div><b> Vencimiento:</b> <br>
                {{$vencimiento ?? ''}}
            </div>
        </td>
    </tr>
    <tr style="text-align: left">
        <td style="padding-bottom: 5px " width="50%" colspan="6">
            <div>Cliente : {{$cliente ?? ''}}</div>
            <div>Bicicleta : {{$bicicleta ?? ''}}</div>
            @foreach ( $partes2 as $parte)
            @if ($parte['nombre'] != 'Inventario')
            <div>Nª serie de {{$parte['nombre'] ?? ''}} : {{$parte['detalle'] ?? ''}}</div>
            @endif
            @endforeach
        </td>
        <td style="padding-bottom: 5px" width="50%" colspan="6">
            <div>Color : {{$color ?? ''}}</div>
            <div>Tecnico : {{$mecanico ?? ''}}</div>
        </td>
    </tr>
    <tr>
        <td width="100%" colspan="12">
            <table style="text-align: center" border="1" width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="30%">Nombre Parte</th>
                        <th width="30%">Porcentaje de Calidad <br>
                             ( 0% Nuevo | 
                             75% Necesita cambio)</th>
                        <th width="40%">Comentario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($partes as $parte )
                    <tr>
                         <td>
                            {{$parte['nombre'] ?? ''}}
                        </td>
                        <td> {{$parte['porcentaje'] ?? ''}} </td>
                        <td> {{$parte['comentario'] ?? ''}} </td>
                     </tr>
                     @endforeach
                     @foreach ( $partes2 as $parte)
                     <tr>
                        <td>
                            {{$parte['nombre'] ?? ''}}
                       </td>
                       <td colspan="2">
                            {{$parte['comentario'] ?? ''}}
                        </td>
                    </tr>
                     @endforeach
                    <tr>
                         <td>
                             Comentario del Mecanico
                        </td>
                        <td colspan="2">
                            {{$parte['comentarioDiag'] ?? ''}}
                        </td>
                     </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>


@endsection