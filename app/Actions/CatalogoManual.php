<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class CatalogoManual extends AbstractAction
{
    public function getTitle()
    {
        return 'WhatsApp';
    }

    public function getIcon()
    {
        return 'voyager-chat';
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
        return route('catalogo.enviar', ['id' =>  $this->data->{$this->data->getKeyName()} ]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'catalogos';
    }
}