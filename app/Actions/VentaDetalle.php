<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class VentaDetalle extends AbstractAction
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
            'class' => 'btn btn-sm btn-dark pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.detalle-ventas.index', ['key' => 'venta_id', 'filter' => 'equals', 's' => $this->data->{$this->data->getKeyName()} ]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'ventas';
    }
}