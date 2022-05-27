<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class CompraProducto extends AbstractAction
{
    public function getTitle()
    {
        return 'Agregar Compra';
    }

    public function getIcon()
    {
        return 'voyager-buy';
    }

    public function getPolicy()
    {
        return 'browse';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('producto.comprar', ['id' =>  $this->data->{$this->data->getKeyName()} ]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'productos';
    }
}
