<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Compra extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'description',
        'editor_id',
        'cantidad',
        'costo',
        'proveedor_id',
        'insumo_id',
        'unidad_id',
        'total'
    ];
}
