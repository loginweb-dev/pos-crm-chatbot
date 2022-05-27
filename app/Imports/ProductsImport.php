<?php

namespace App\Imports;

use App\Producto;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // return new Producto([
        //     'name'     => $row[0],
        //     'description'    => $row[1],
        //     'precio' => $row[2],
        //     'categoria_id' => $row[3],
        //     'sku'=> $row[4],
        //     'description_long'=> $row[5],
        //     'precio_compra'=> $row[6],
        //     'vencimiento'=> $row[7],
        //     'laboratorio_id'=> $row[8],
        //     'stock'=> $row[9],
        // ]);

        //$fecha=date('Y-m-d', strtotime($row[6]));
        $fecha= $row[6] ? date('Y-m-d', $row[6]) : null;
        //echo $fecha;
        return new Producto([
            'name'     => $row[0],
            'title'    => $row[1],
            'etiqueta' => $row[2],
            'precio' => $row[3],
            'laboratorio_id'=> $row[4],
            'precio_compra'=> $row[5],
            'vencimiento'=> $fecha,
            'stock'=> $row[7],
            'categoria_id'=> $row[8],
            'sucursal_id'=>1
        ]);
    }
}
