<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Models\User;
use Carbon\Carbon;

class Notificacione extends Model
{

    use SoftDeletes;
	protected $fillable = [
		'message'
	];
}
