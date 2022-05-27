<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ComprasProducto extends Model
{
    use SoftDeletes;
	protected $fillable = [
		'producto_id',
        'title',
        'description',
        'editor_id',
        'cantidad',
        'costo',
        'proveedor_id',
        'total',
        'fecha_vencimiento',
        'presentacion_id',
        'laboratorio_id',
        'marca_id'
	];
}
