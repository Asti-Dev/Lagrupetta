<?php

namespace App\Exports;

use App\Models\PedidoLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PedidoLogExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithStrictNullComparison
{

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
            'Estado',
            'Sub Estado',
            'Fecha de Creacion',
            'Fecha de Actualiacion',
        ];
    }

    public function map($pedidoLog): array
    {
        return [
            $pedidoLog->pedido_id,
            $pedidoLog->pedidoEstado->nombre . ' ' . ($pedidoLog->eliminado ? 'ANULADO' : ''),
            $pedidoLog->sub_estado,
            $pedidoLog->pedido->created_at,
            $pedidoLog->created_at,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PedidoLog::all();
    }
}
