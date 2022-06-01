<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Cart extends Model
{
    use SoftDeletes;

    protected $fillable = [
		'product_id',
		'chatbot_id',
        'precio',
        'cantidad'
	];

	protected $appends=['published'];
	public function getPublishedAttribute(){
		return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
	}
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }
    // public function chatbot()
    // {
    //     return $this->belongsTo(Chatbot::class, 'chatbot_id');
    // }
}
