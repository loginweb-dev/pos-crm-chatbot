<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Banipay extends Model
{
    use SoftDeletes;
	protected $fillable = [
		'venta_id',
		'paymentId',
		'transactionGenerated',
		'urlTransaction'
	];
}
