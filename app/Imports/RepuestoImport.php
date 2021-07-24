<?php

namespace App\Imports;

use App\Models\Repuesto;
use Maatwebsite\Excel\Concerns\ToModel;

class RepuestoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Repuesto([
            'nombre' => $row[0],
            'precio' => $row[1],
        ]);
    }
}
