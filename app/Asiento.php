<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
	protected $appends=['published'];
	public function getPublishedAttribute(){
		return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
	}
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'pago');
    }
}
