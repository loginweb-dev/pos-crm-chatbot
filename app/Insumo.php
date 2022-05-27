<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Insumo extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'stock'
    ];
    
}
