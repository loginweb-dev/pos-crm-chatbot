<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DetalleVenta extends Model
{
    protected $fillable = [
		'producto_id',
		'venta_id',
		'precio',
		'cantidad',
		'total',
		'name',
		'foto',
		'description',
		'extra_name',
		'observacion'
	];
	public function venta()
	{
		return $this->belongsTo(Venta::class, 'venta_id');
	}	
}
