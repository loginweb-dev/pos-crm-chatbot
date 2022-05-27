<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class CompraProductoDetalle extends AbstractAction
{
    public function getTitle()
    {
        return 'Detalle';
    }

    public function getIcon()
    {
        return 'voyager-helm';
    }

    public function getPolicy()
    {
        return 'browse';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-default pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.compras-productos.index', ['key' => 'producto_id', 'filter' => 'equals', 's' => $this->data->{$this->data->getKeyName()} ]);

    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'productos';
    }
}
