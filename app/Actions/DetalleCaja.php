<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class DetalleCaja extends AbstractAction
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
            'class' => 'btn btn-sm btn-warning pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('cajas.cierre_caja', ['id' =>  $this->data->{$this->data->getKeyName()} ]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'detalle-cajas';
    }
}