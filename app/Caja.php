<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use TCG\Voyager\Models\User;

class Caja extends Model
{
    use SoftDeletes;

	protected $appends=['published'];
	public function getPublishedAttribute(){        
		return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
	}
	public function sucursal()
    {
        return $this->belongsTo(Sucursale::class, 'sucursal_id');
    }
}
