<?php

namespace App\ViewForm\Fields;

class InputType extends FormField
{
    /**
     * @inheritdoc
     */
    protected function getTemplate()
    {
        return 'text';
    }
}
