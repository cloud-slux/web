<?php

namespace App\ViewForm\Fields;

class ChoiceType extends FormField
{
    /**
     * @inheritdoc
     */
    protected function getTemplate()
    {
        return 'choice';
    }
}
