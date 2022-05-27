<?php

namespace App\Imports;

use App\Venta;
use Maatwebsite\Excel\Concerns\ToModel;

class VentaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Venta([
            'id' => $row[0] ? $row[0] : null,
            'sucursal_id'     => $row[1] ? $row[1] : null,
            'ticket'     => $row[2] ? $row[2] : null,
            'cliente_id'    => $row[3] ? $row[3] : null, 
            'created_at'    => $row[4] ? $row[4] : null, 
            'subtotal' => $row[5] ? $row[5] : 0,         
            'descuento' => $row[6] ? $row[6] : 0,
            'total' => $row[7] ? $row[7] : 0,
            'fiscal' => $row[8],
            'adicional' => $row[9],
            'register_id' => $row[10],
            'option_id' => $row[11],
            'status_id' => $row[12],

        ]);
    }
}
