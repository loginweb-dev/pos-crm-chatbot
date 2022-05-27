<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Production extends Model
{
    
	protected $fillable = [
		'producto_id',
		'cantidad',
		'valor',
		'description',
		'user_id',
	];
}
