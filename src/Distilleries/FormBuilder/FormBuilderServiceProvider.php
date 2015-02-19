<?php namespace Distilleries\FormBuilder;

use Kris\LaravelFormBuilder\FormHelper;
use Illuminate\Foundation\AliasLoader;

class FormBuilderServiceProvider extends \Kris\LaravelFormBuilder\FormBuilderServiceProvider {


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        $this->commands('Distilleries\FormBuilder\Console\FormMakeCommand');
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php',
            'form-builder'
        );


        AliasLoader::getInstance()->alias(
            'File',
            'Illuminate\Support\Facades\File'
        );


    }

    protected function registerFormHelper()
    {
        $this->app->bindShared('laravel-form-helper', function($app)
        {

            $configuration = $app['config']->get('form-builder');

            return new FormHelper($app['view'], $app['request'], $configuration);
        });

        $this->app->alias('laravel-form-helper', 'Kris\LaravelFormBuilder\FormHelper');
    }


    public function boot()
    {

        parent::boot();

        $this->loadViewsFrom(__DIR__.'/../../views', 'form-builder');

        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('form-builder.php')
        ]);
        $this->publishes([
            __DIR__.'/../../views'             => base_path('resources/views/vendor/form-builder'),
        ], 'views');


    }
}