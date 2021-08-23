<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PedidosExport implements FromCollection, WithHeadings, WithMapping
{
    private $pedidoIDs;

    public function __construct($pedidoIDs)
    {
        $this->pedidoIDs = $pedidoIDs;
    }

    public function headings(): array
    {
        return [
            'Nro Pedido',
            'Cliente',
            'Bicicleta',
        ];
    }

    public function map($pedido): array
    {
        return [
            $pedido->id ?? '',
            $pedido->cliente->nombre_apellido ?? '',
            $pedido->bicicleta->marca . ' ' . $pedido->bicicleta->modelo ?? '',
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
