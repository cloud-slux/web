<?php


namespace App\Http\Controllers\erp;

use Illuminate\Support\Collection;


class ViewFormModule
{

    public $modules;
    public $modulesNames;


    public function getModules()
    {
        return $this->modules;
    }

    public function getModulesNames()
    {
        return $this->modulesNames;
    }

    public $instances;

    public function getInstances()
    {
        return $this->instances;
    }

    public function __construct()
    {
        $this->modules = ['financial', 'management', 'relationship'];
        $this->modulesNames = ['Financeiro', 'Gerenciamento', 'Relacionamentos'];
    }

    public function init()
    {
        $this->instances = collect([]);

        foreach($this->modules as $module)
        {
            $this->initControllers($module);
        }
    }

    public function initControllers($module)
    {
        $controllers = collect([]);

        $finder = new \Symfony\Component\Finder\Finder();
        $finder->files()->name('*Controller.php')->in(base_path().'/app/Http/Controllers/erp/'.$module);


        foreach ($finder as $file) {
            $ns = __NAMESPACE__.'\\'.$module;
            // if ($relativePath = $file->getRelativePath()) {
            //     $ns .= '\\'.strtr($relativePath, '/', '\\');
            // }
            $class = $ns.'\\'.$file->getBasename('.php');

            $r = new \ReflectionClass($class);
            $i = $r->newInstance();
            $controllers->push($i);
            //dd($r);
        }

        $this->instances->put($module, $controllers);
    }

    public function getControllers($module)
    {
        if(isset($this->instances[$module]))
        {
            return $this->instances[$module];
        }
    }

    public function getAllControllers()
    {
        $controllers = collect([]);
        foreach($this->modules as $module)
        {
            $moduleControllers = $this->getControllers($module);

            foreach($moduleControllers as $controller)
            {
                $controllers->push($controller);
            }
        }
        return $controllers;
    }

    public function getFormByRouteName($name)
    {
        foreach($this->modules as $module)
        {
            $moduleControllers = $this->getControllers($module);

            foreach($moduleControllers as $controller)
            {
                if($controller->form->routeName == $name)
                {
                    return $controller->form;
                }
            }
        }
    }

    public function setFormByRouteName($form)
    {
        foreach($this->modules as $module)
        {
            $moduleControllers = $this->getControllers($module);

            foreach($moduleControllers as $controller)
            {
                if($controller->form->routeName == $form->routeName)
                {
                    return $controller->form = $form;
                }
            }
        }
    }

}
