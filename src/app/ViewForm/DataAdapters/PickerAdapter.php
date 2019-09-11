<?php

namespace App\ViewForm\DataAdapters;


class PickerAdapter {

    public $pickerRoute = '';
    public $pickerSchema = [];
    public $hiddenFields = [];
    public $pickerHooks = [];
    public $pickerPreFilter = '';
    public $pickerDisplayExpression = '';

    public function __construct()
    {
    }

    public function withRoute($pickerRoute)
    {
        $this->pickerRoute = $pickerRoute;
        return $this;
    }

    public function withSchema($pickerSchema)
    {
        $this->pickerSchema = $pickerSchema;
        return $this;
    }

    public function withPickerHiddenFields($pickerHiddenFields)
    {
        if(empty($pickerHiddenFields)){
            array_push($pickerHiddenFields, '_id');
        }

        if(!in_array( '_id', $pickerHiddenFields )){
            array_push($pickerHiddenFields, '_id');
        }


        $this->pickerHiddenFields = $pickerHiddenFields;
        return $this;
    }

    public function withPickerHooks($pickerHooks)
    {
        $this->pickerHooks = $pickerHooks;
        return $this;
    }

    public function withPickerPreFilter($pickerPreFilter)
    {
        $this->pickerPreFilter = $pickerPreFilter;
        return $this;
    }

    public function withPickerDisplayExpression($pickerDisplayExpression)
    {
        $this->pickerDisplayExpression = $pickerDisplayExpression;
        return $this;
    }
}





