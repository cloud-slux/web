<?php

namespace App\ViewForm\Fields;

class NumberType extends FormField
{
    /**
     * @inheritdoc
     */
    protected function getTemplate()
    {
        return 'number';
    }
}
