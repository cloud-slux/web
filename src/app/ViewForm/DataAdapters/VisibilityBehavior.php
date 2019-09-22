<?php

namespace App\ViewForm\DataAdapters;

class VisibilityBehavior {
    public $value = '';
    public $invisibleFields = [];

    public function __construct()
    {
    }

    public function withValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function withInvisiblefields($invisibleField)
    {
        $this->invisibleFields = array_merge($this->invisibleFields, array($invisibleField));
        return $this;
    }
}