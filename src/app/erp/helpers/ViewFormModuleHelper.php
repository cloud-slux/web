<?php

namespace App\erp\helpers;

use App\Http\Controllers\erp\ViewFormModule;
use Illuminate\Support\Collection;

class ViewFormModuleHelper {

    private $viewFormModule;

    public function __construct()
    {
        $this->viewFormModule = new ViewFormModule();
    }

    public function init()
    {
        $this->viewFormModule->init();
    }

    public function getModules()
    {
        return $this->viewFormModule->modules;
    }

    public function getModuleName($module)
    {
        $key = array_search($module, $this->viewFormModule->modules); // $key = 2;
        return $this->viewFormModule->modulesNames[$key];
    }

    public function getAllControllers()
    {
        return $this->viewFormModule->getAllControllers();
    }

    public function getFormsFromModule($module)
    {
        $controllers = $this->viewFormModule->getControllers($module);

        $forms = collect([]);

        foreach($controllers as $controller)
        {
            $name = $controller->form->name;
            $route = $controller->form->route;
            $icon = $controller->form->icon;

            $moduleView = new ModuleForm($name, $route, $icon);
            $forms->push($moduleView);
        }

        return $forms;
    }

    public function getFormByRouteName($routeName)
    {
        return $this->viewFormModule->getFormByRouteName($routeName);
    }

    public function setFormByRouteName($form)
    {
        return $this->viewFormModule->setFormByRouteName($form);
    }
}

class ModuleForm
{
    public $name;
    public $route;
    public $icon;

    public  function __construct($name, $route, $icon)
    {
        $this->name = $name;
        $this->route = $route;
        $this->icon = $icon;
    }
}
