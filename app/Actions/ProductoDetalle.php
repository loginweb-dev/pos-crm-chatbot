<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class ProductoDetalle extends AbstractAction
{
    public function getTitle()
    {
        return 'Detalle';
    }

    public function getIcon()
    {
        return 'voyager-photos';
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
        return route('producto.detalle', ['id' => $this->data->{$this->data->getKeyName()} ]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'productos';
    }
}