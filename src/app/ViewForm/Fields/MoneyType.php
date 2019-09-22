<?php

namespace App\ViewForm\Fields;

class MoneyType extends FormField
{
    /**
     * @inheritdoc
     */
    protected function getTemplate()
    {
        return 'money';
    }
}
