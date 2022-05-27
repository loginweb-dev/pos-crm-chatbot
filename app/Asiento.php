<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Asiento extends Model
{
	use SoftDeletes;
	protected $fillable = [
		'caja_id',
		'type',
		'monto',
		'concepto',
		'editor_id',
		'caja_status',
		'pago',
		'detalle_caja_id'
	];
}
