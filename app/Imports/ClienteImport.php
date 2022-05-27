<?php

namespace App\Imports;

use App\Cliente;
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
           
            // 'first_name'     => $row[0],
            // 'last_name'    => $row[1], 
            // 'display'    => $row[2], 
            // 'phone' => $row[3],

            'id' => $row[0],
            'display'    => $row[1], 
            'ci_nit' => $row[2],
            'phone' => $row[3]
           
           
        ]);
    }
}
