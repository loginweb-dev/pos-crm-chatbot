<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DetalleProductionSemi extends Model
{
    
    protected $fillable = [
		'proveedor_id',
		'insumo_id',
		'production_semi_id',
		'precio',
		'cantidad',
		'total',
	];
}
