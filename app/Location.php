<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Location extends Model
{
	use SoftDeletes;
    protected $fillable = ['cliente_id', 'latitud', 'longitud', 'descripcion', 'default'];
}
