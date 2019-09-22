<?php

namespace App\ViewForm\DataAdapters;

class VisibilityAdapter {
    public $behaviors = [];

    public function __construct()
    {
    }

    public function withBehavior($behavior)
    {
        $this->behaviors = array_merge($this->behaviors, array($behavior));
        return $this;
    }  
}