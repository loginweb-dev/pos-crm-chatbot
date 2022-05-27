<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
	use SoftDeletes;
	protected $fillable = [
		'id',
		'first_name',
		'last_name',
		'display',
		'phone',
		'ci_nit',
		'email',
		'default'
	];

}
