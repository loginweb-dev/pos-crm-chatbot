<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProductionInsumo extends Model
{


	protected $fillable = [
		'type_insumo',
		'proveedor_id',
		'insumo_id',
		'production_id',
		'precio',
		'cantidad',
		'total',
        'elaborado_id'
	];
}
