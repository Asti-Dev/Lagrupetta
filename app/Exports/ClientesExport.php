<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithStrictNullComparison
{
    public function __construct($clientesIDs)
    {
        $this->clientesIDs = $clientesIDs;
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
            'Nombre Cliente',
            'telefono',
            'correo',
            'direccion',
            'Tipo Doc',
            'Nro Doc',
            'Fecha de Cumpleaños',
            'Fecha de creacion',
            'Cantidad de Pedidos',
            'Cantidad de Bicicletas'
        ];
    }

    public function map($cliente): array
    {
        return [
            $cliente->nombre_apellido ?? 'Vacio en BD',
            $cliente->telefono ?? 'Vacio en BD',
            $cliente->email ?? 'Vacio en BD',
            $cliente->direccion ?? 'Vacio en BD',
            $cliente->tipo_doc ?? 'Vacio en BD',
            $cliente->nro_doc ?? 'Vacio en BD',
            $cliente->fecha_cumpleanos ?? 'Vacio en BD',
            $cliente->created_at ?? 'Vacio en BD',
            $cliente->pedidos()->count() ?? 'Vacio en BD' ,
            $cliente->bicicletas()->count() ?? 'Vacio en BD',

        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cliente::with(['pedidos', 'bicicletas'])->find($this->clientesIDs);
    }
}
