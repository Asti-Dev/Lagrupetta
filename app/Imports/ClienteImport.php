<?php

namespace App\Imports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\ToModel;

class ClienteImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Cliente([
            'nombre_apellido' => $row[0],
            'telefono' => $row[1],
            'email' => $row[2],
            'tipo_doc' => $row[3],
            'nro_doc' => $row[4]
        ]);
    }
}
