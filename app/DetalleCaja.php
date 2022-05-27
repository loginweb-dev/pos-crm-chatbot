<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DetalleCaja extends Model
{
	protected $fillable = [
		'created_at',
		'updated_at',
		'deleted_at',
		'cantidad_ventas',
		'importe_inicial',
		'total_ventas',
		'ingresos',
		'egresos',
		'caja_id',
		'description',
		'editor_id',
		'venta_efectivo',
		'venta_banipay',
		'venta_tarjeta',
		'venta_transferencia',
		'venta_qr',
		'venta_tigomoney',
		'cantidad_efectivo',
		'cantidad_tarjeta',
		'cantidad_banipay',
		'cantidad_transferencia',
		'cantidad_qr',
		'cantidad_tigomoney',
		'efectivo_entregado',
		'cortes',
		'ingreso_efectivo',
		'ingreso_linea',
		'egreso_efectivo',
		'egreso_linea'
	];
}
