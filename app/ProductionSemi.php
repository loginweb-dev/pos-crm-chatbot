<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProductionSemi extends Model
{
    protected $fillable = [
		'producto_semi_id',
		'cantidad',
		'valor',
		'description',
		'user_id',
	];

}
