<?php

namespace App\ViewForm\Fields;

class PickerType extends FormField
{
    /**
     * @inheritdoc
     */
    protected function getTemplate()
    {
        return 'picker';
    }
}
