<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PedidosExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    private $pedidoIDs;

    public function __construct($pedidoIDs)
    {
        $this->pedidoIDs = $pedidoIDs;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function headings(): array
    {
        return [
            'Nro Pedido',
            'Creacion',
            'Ultima actualizacion',
            'Eliminado',
            'Cliente',
            'Bicicleta',
            'Observacion Cliente',
            'Estado',
            'Confirmacion',
            'Fecha de confirmacion',
            'Fecha de recojo aprox',
            'Ruta',
            'Chofer Recojo',
            'Direccion de Recojo',
            'Respuesta',
            'Fecha Respuesta',
            'Observacion Chofer',
            'Estado Recojo',
            'Fecha de Estado Recojo',
            'Fecha y Hora en Local',
            'Mecanico',
            'Nombre de Diagnostico',
            'Comentario del Mecanico',
            'Paquetes',
            'Servicios',
            'Repuestos',
            'Explicacion',
            'Precio Final',
            'Fecha de Entrega',
            'Estado de Cotizacion',
            'Fecha y Hora de Estado',
            'Mecanico de Revision',
            'Nombre de Informe Final',
            'Ruta',
            'Chofer Entrega',
            'Direccion de Entrega',
            'Respuesta',
            'Fecha Respuesta',
            'Estado Entrega',
            'Fecha de Estado Entrega',

        ];
    }

    public function map($pedido): array
    {

        $paquetes = '';
        $servicios = '';
        $repuestos = '';
        if (isset($pedido->pedidoDetalle->paquetes)) {
            foreach ($pedido->pedidoDetalle->paquetes->unique() as $paquete) {
                $paquetes .= ' ' . $paquete->nombre ;
            }
        }
        if (isset($pedido->pedidoDetalle->servicios)) {
            foreach ($pedido->pedidoDetalle->servicios()
        ->wherePivot('paquete_id', null)->get() as $servicio) {
            $servicios .= ' ' . $servicio->nombre ;
        }
        }
        if (isset($pedido->pedidoDetalle->repuestos)) {
            foreach ($pedido->pedidoDetalle->repuestos as $repuesto) {
                $repuestos .= ' ' . $repuesto->nombre ;
            }
        }
        
        

        return [
            $pedido->id ?? 'Vacio en BD',
            $pedido->created_at ?? 'Vacio en BD',
            $pedido->updated_at ?? 'Vacio en BD',
            $pedido->deleted_at ?? 'Vacio en BD',
            $pedido->cliente->nombre_apellido ?? '',
            $pedido->bicicleta->marca . ' ' . $pedido->bicicleta->modelo ?? 'Vacio en BD',
            $pedido->observacion_cliente ?? 'Vacio en BD' ,
            $pedido->pedidoEstado->nombre ?? 'Vacio en BD' ,
            $pedido->confirmacion ?? 'Vacio en BD' ,
            $pedido->fecha_hora_confirmacion ?? 'Vacio en BD' ,
            $pedido->fecha_recojo_aprox ?? 'Vacio en BD' ,
            $pedido->transporteRecojo->ruta ?? 'Vacio en BD' ,
            $pedido->transporteRecojo->choferTransporte->nombre_apellido ?? 'Vacio en BD' ,
            $pedido->transporteRecojo->direccion ?? 'Vacio en BD' ,
            $pedido->transporteRecojo->aceptar_chofer ?? 'Vacio en BD' ,
            $pedido->transporteRecojo->fecha_hora_aceptar_chofer ?? 'Vacio en BD' ,
            $pedido->transporteRecojo->observacion_chofer ?? 'Vacio en BD' ,
            $pedido->transporteRecojo->completado ?? 'Vacio en BD' ,
            $pedido->transporteRecojo->fecha_hora_completado ?? 'Vacio en BD' ,
            $pedido->transporteRecojo->fecha_hora_local ?? 'Vacio en BD' ,
            $pedido->pedidoDetalle->mecanicoUno->nombre_apellido ?? 'Vacio en BD' ,
            $pedido->pedidoDetalle->diagnostico->serial ?? 'Vacio en BD' ,
            $pedido->pedidoDetalle->diagnostico->comentario ?? 'Vacio en BD' ,
            $paquetes ?? 'Vacio en BD' ,
            $servicios ?? 'Vacio en BD' ,
            $repuestos ?? 'Vacio en BD' ,
            $pedido->pedidoDetalle->explicacion ?? 'Vacio en BD' ,
            $pedido->pedidoDetalle->precio_final ?? 'Vacio en BD' ,
            $pedido->pedidoDetalle->fecha_entrega_aprox ?? 'Vacio en BD' ,
            $pedido->pedidoDetalle->confirmacion ?? 'Vacio en BD' ,
            $pedido->pedidoDetalle->fecha_confirmacion ?? 'Vacio en BD' ,
            $pedido->revision->mecanicoUno->nombre_apellido ?? 'Vacio en BD' ,
            $pedido->revision->diagnostico->serial ?? 'Vacio en BD' ,
            $pedido->transporteEntrega->ruta ?? 'Vacio en BD' ,
            $pedido->transporteEntrega->choferTransporte->nombre_apellido ?? 'Vacio en BD' ,
            $pedido->transporteEntrega->direccion ?? 'Vacio en BD' ,
            $pedido->transporteEntrega->aceptar_chofer ?? 'Vacio en BD' ,
            $pedido->transporteEntrega->fecha_hora_aceptar_chofer ?? 'Vacio en BD' ,
            $pedido->transporteEntrega->observacion_chofer ?? 'Vacio en BD' ,
            $pedido->transporteEntrega->completado ?? 'Vacio en BD' ,
            $pedido->transporteEntrega->fecha_hora_completado ?? 'Vacio en BD' ,

        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pedido::with(['cliente', 'bicicleta', 'pedidoEstado','pedidoDetalle','revision', 'transportes'])->find($this->pedidoIDs);
    }
}
