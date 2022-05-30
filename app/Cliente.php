<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
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
		'default',
        'chatbot_id'
	];

    protected $appends=['published'];
	public function getPublishedAttribute(){
		return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
	}
}
