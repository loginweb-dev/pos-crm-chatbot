<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Models\User;
use Carbon\Carbon;

class Credito extends Model
{
    protected $fillable = [
        'venta_id',
        'cliente_id',
        'deuda',
        'cuota',
        'restante',
        'status'
    ];

    use SoftDeletes;
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
}
