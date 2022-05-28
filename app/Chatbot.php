<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Chatbot extends Model
{
    use SoftDeletes;

    protected $fillable = [
		'phone',
		'message',
        'type',
        'created_at'
	];

    protected $appends=['published'];
	public function getPublishedAttribute(){
		return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
	}
}
