<?php

namespace App\Imports;

use App\Models\Repuesto;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RepuestoImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Repuesto::updateOrCreate(
                [
            	    'id' => $row['nro']
                ],
                [
                    'nombre' => $row['nombre'],
                    'precio' => $row['precio'],
                    'disponible' => ($row['disponible'] === 'NO') ? 1 : 0,
                    'activo' => ($row['apto_venta'] === 'NO') ? 1 : 0
                ]
            );
        }
    }

}
