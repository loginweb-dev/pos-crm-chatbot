<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
	use SoftDeletes;
	protected $fillable = [
		'name',
        'categoria_id',
		'description',
        'image',
		'precio',
		'stock',
        'production',
        'description_long',
        'precio_compra',
        'images',
        'vencimiento',
        'type_producto_id',
        'extra',
        'extras',
        'ecommerce',
        'presentacion_id',
        'laboratorio_id',
        'marca_id',
        'title',
        'lote',
        'registro_sanitario',
        'origen',
        'sku',
        'etiqueta',
        'sucursal_id',
        'mixta'
	];

	public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class, 'laboratorio_id');
    }
    public function presentacion()
    {
        return $this->belongsTo(Presentacione::class, 'presentacion_id');
    }

}
