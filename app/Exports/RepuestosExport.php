<?php

namespace App\Exports;

use App\Models\Repuesto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RepuestosExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithStrictNullComparison
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
            'Nombre',
            'Precio',
            'Disponible',
            'Apto venta',
        ];
    }

    public function map($repuesto): array
    {
        return [
            $repuesto->nombre ?? 'Vacio en BD',
            $repuesto->precio ?? 'Vacio en BD',
            ($repuesto->disponible === 1) ? 'NO' : 'SI' ,
            ($repuesto->activo === 1) ? 'NO' : 'SI',

        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Repuesto::all();
    }
}
