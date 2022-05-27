<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Models\User;
use Carbon\Carbon;
class Venta extends Model
{
	use SoftDeletes;
	protected $fillable = [
		'id',
		'cliente_id',
		'cupon_id',
		'option_id',
		'pago_id',
		'factura',
		'total',
		'descuento',
		'observacion',
		'register_id',
		'status_id',
		'caja_id',
		'caja_status',
		'delivery_id',
		'chofer_id',
		'sucursal_id',
		'subtotal',
		'ticket',
		'fiscal',
		'adicional',
		'created_at',
		'cantidad',
		'recibido',
		'cambio',
		'credito',
        'location',
        'pensionado_id',
        'status_credito',
        'codigo_control',
        'nro_factura'
	];

	protected $appends=['published'];
	public function getPublishedAttribute(){
		return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
	}
	public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
	public function delivery()
    {
        return $this->belongsTo(Mensajero::class, 'delivery_id');
    }
	public function chofer()
    {
        return $this->belongsTo(User::class, 'chofer_id');
    }
	public function pasarela()
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'status_id');
    }

    public function cupon()
    {
        return $this->belongsTo(Cupone::class, 'cupon_id');
    }
    public function pensionado()
    {
        return $this->belongsTo(Pensionado::class, 'pensionado_id');
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursale::class, 'sucursal_id');
    }
}
