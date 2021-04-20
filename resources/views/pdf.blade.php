@extends('layouts.simple')


@section('content')
<table style="text-align: center" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="2">logo</td>
        <td colspan="6">
            <h1 style="color: green">Titulo</h1>
            <h3>Diagnostico M-02</h3>
        </td>
        <td colspan="4">
            <div>contacto</div>
            <div>vencimiento</div>
        </td>
    </tr>
    <tr style="text-align: left">
        <td style="padding: 2rem 3rem" width="50%" colspan="6">
            <div>Cliente</div>
            <div>Bicicleta</div>
            <div>Nª serie del Cuadro</div>
            <div>Nª serie de la suspension</div>
            <div>Nª serie de los frenos</div>
        </td>
        <td style="padding: 2rem 3rem" width="50%" colspan="6">
            <div>Color</div>
            <div>Tecnico</div>
        </td>
    </tr>
    <tr>
        <td width="100%" colspan="12">
            <table border="1" width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="40%">Nombre Parte</th>
                        <th width="20%">Porcentaje de Calidad <br>
                             ( 0% Nuevo | <br>
                             75%+ Necesita cambio)</th>
                        <th width="40%">Datos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                         <td>
                             item
                        </td>
                        <td> x </td>
                        <td> x </td>
                     </tr>
                    <tr>
                         <td>
                             item
                        </td>
                        <td> x </td>
                        <td> x </td>
                     </tr>
                    <tr>
                         <td>
                             item
                        </td>
                        <td colspan="2">
                            Algo de texto
                        </td>
                     </tr>
                    <tr>
                         <td>
                             item
                        </td>
                        <td colspan="2">
                            Algo de texto
                        </td>
                     </tr>
                    <tr>
                         <td>
                             item
                        </td>
                        <td colspan="2">
                            Algo de texto
                        </td>
                     </tr>
                    <tr>
                         <td>
                             item
                        </td>
                        <td colspan="2">
                            Algo de texto
                        </td>
                     </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>


@endsection