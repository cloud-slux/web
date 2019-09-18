<?php

namespace App\ViewForm;
use App\ViewForm\Fields\FormField;

class Form
{

    public $fields = [];

    public $model = [];

    public $name = null;

    public $singularName = null;

    public $alias = null;

    public $route = null;

    public $routeName = null;

    public $slug = null;

    public $icon = null;

    public $maps = [];

    public $pickers = [];

    public $formHelper;

    public $builded = false;

     /**
     * Set the form helper only on first instantiation.
     *
     * @param FormHelper $formHelper
     * @return $this
     */
    public function setFormHelper(FormHelper $formHelper)
    {
        $this->formHelper = $formHelper;
        return $this;
    }
    /**
     * Get form helper.
     *
     * @return FormHelper
     */
    public function getFormHelper()
    {
        return $this->formHelper;
    }


    public function buildForm()
    {
    }

    public function buildMaps()
    {
    }

    public function buildPickers()
    {
    }

    public function buildConditionalDisabling()
    {
    }

    public function add($name, $alias, $shortAlias, $type = 'text', $used, $browsed)
    {
        $this->addField($this->makeField($name, $alias, $shortAlias, $type, $used, $browsed));
        return $this;
    }

    protected function addField(FormField $field)
    {
        $this->fields[$field->name] = $field;
        return $this;
    }

    protected function makeField($name, $alias, $shortAlias, $type = 'text', $used, $browsed)
    {
        $fieldName = $this->getFieldName($name);
        $fieldType = $this->getFieldType($type);
        $field = new $fieldType($fieldName, $alias, $shortAlias, $type, $used, $browsed);
        return $field;
    }

    protected function getFieldName($name)
    {
        // $formName = $this->name;
        // if ($formName !== null) {
        //     if (strpos($formName, '[') !== false || strpos($formName, ']') !== false) {
        //         return $this->formHelper->transformToBracketSyntax(
        //             $this->formHelper->transformToDotSyntax(
        //                 $formName . '[' . $name . ']'
        //             )
        //         );
        //     }
        //     return $formName . '[' . $name . ']';
        // }
        return $name;
    }

    protected function getFieldType($type)
    {
        $fieldType = $this->formHelper->getFieldType($type);
        return $fieldType;
    }

    public function getBrowsedFields(){
        $browsedFields = array_filter($this->fields, function($field) {
            return $field->browsed === true;
          });
        return $browsedFields;
    }

    public function getFieldsByNames($names)
    {
        $mapNames = array_flip($names);

        $matchedFields = array_intersect_key($this->fields, $mapNames);
        return $matchedFields;
    }

    public function addMap($map)
    {
        $this->maps[$map] = [];
        return $this;
    }

    public function addPicker($arrayPick)
    {
        $this->pickers = array_merge($this->pickers, $arrayPick);
        return $this;
    }

}
