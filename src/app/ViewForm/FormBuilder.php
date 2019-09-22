<?php

namespace App\ViewForm;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Redis;

use App\erp\facades\ViewFormModuleFacade;

class FormBuilder
{
    /**
     * @var Container
     */
    protected $container;
    /**
     * @var FormHelper
     */
    protected $formHelper;

    public function __construct(Container $container, FormHelper $formHelper)
    {
        $this->container = $container;
        $this->formHelper = $formHelper;
    }

    public function create($formClass)
    {
        $class = $this->getNamespaceFromConfig() . $formClass;
        if (!class_exists($class)) {
            throw new \InvalidArgumentException(
                'Form class with name ' . $class . ' does not exist.'
            );
        }
        $form = $this->container->make($class);

        $form->setFormHelper($this->formHelper);

        $form->buildForm();

        $form->buildMaps();
        $form->builded  = true;
        $this->mapCaching($form);

        ViewFormModuleFacade::setFormByRouteName($form);

        $form->buildPickers();

        $form->buildConditionalVisibility();

        $form->buildDefaults();

        return $form;
    }

    protected function mapCaching($form){
        foreach($form->maps as  $map => $value)
        {
            $mapKey = $form->routeName.':'.$map;
            $hash =  Redis::hgetall($mapKey);
            $form->maps[$map] = $hash;
        }
    }

    protected function getNamespaceFromConfig()
    {
        $namespace = $this->formHelper->getConfig('default_namespace');
        if (!$namespace) {
            return '';
        }
        return $namespace . '\\';
    }
}
