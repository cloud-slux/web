<?php

namespace App\ViewForm\Fields;

abstract class FormField {

    public $name;

    public $alias;

    public $shortAlias;

    public $type;

    public $used;

    public $browsed;

    public $visible;

    public function __construct($name, $alias, $shortAlias, $type, $used, $browsed)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->shortAlias = $shortAlias;
        $this->type = $type;
        $this->used = $used;
        if(!$used)
        {
            $browsed = false;
        }
        $this->browsed = $browsed;
        $this->visible = true;
        //$this->formHelper = $this->parent->getFormHelper();
    }

        /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    abstract protected function getTemplate();

    protected function getViewTemplate()
    {
        return $this->parent->getTemplatePrefix() . $this->getOption('template', $this->template);
    }

    public function renderField()
    {
        return '';
    }

}
