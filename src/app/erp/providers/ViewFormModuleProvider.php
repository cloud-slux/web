<?php

namespace App\erp\providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use App\erp\facades\ViewFormModuleFacade;

class ViewFormModuleProvider extends ServiceProvider
{

    public function boot(){
        ViewFormModuleFacade::init();
    }

    public function register()
    {
        App::bind('viewformmodule', function()
        {
            return new \App\erp\helpers\ViewFormModuleHelper;
        });
    }
}
