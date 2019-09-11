<?php

namespace App\ViewForm\Fields;

class DatePickerType extends FormField
{
    /**
     * @inheritdoc
     */
    protected function getTemplate()
    {
        return 'datepicker';
    }
}
