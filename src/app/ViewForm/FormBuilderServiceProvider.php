<?php

namespace App\ViewForm;

use Illuminate\Support\ServiceProvider;


class FormBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFormHelper();

        $this->app->singleton('viewform-builder', function ($app) {
            return new FormBuilder($app, $app['viewform-helper']);
        });

        $this->app->alias('viewform-builder', 'App\ViewForm\FormBuilder');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views/viewForm', 'viewform-builder');
    }

    public function provides()
    {
        return ['viewform-builder'];
    }

    protected function registerFormHelper()
    {
        $this->app->singleton('viewform-helper', function ($app) {
            $configuration = $app['config']->get('viewform-builder');
            return new FormHelper($app['view'], $configuration);
        });
        $this->app->alias('viewform-helper', 'App\ViewForm\FormHelper');
    }
}
