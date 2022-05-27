<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class ProductionSemiDetalle extends AbstractAction
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
        return 'add';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.detalle-production-semis.index', ['key' => 'production_semi_id', 'filter' => 'equals', 's' => $this->data->{$this->data->getKeyName()} ]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'production-semis';
    }
}