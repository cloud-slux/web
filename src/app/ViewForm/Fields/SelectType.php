<?php

namespace App\ViewForm\Fields;

class SelectType extends FormField
{
    /**
     * @inheritdoc
     */
    protected function getTemplate()
    {
        return 'select';
    }
}
