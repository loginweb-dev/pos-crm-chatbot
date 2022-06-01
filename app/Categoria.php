<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;

    // protected $appends=['published'];
	// public function getPublishedAttribute(){
	// 	return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
	// }
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
