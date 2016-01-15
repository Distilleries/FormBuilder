<?php namespace Distilleries\FormBuilder;

use Illuminate\Html\HtmlBuilder;
use Illuminate\Html\FormBuilder as LaravelForm;
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
        $this->commands('Kris\LaravelFormBuilder\Console\FormMakeCommand');

        $this->registerHtmlIfNeeded();
        $this->registerFormIfHeeded();

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php',
            'laravel-form-builder'
        );

        $this->registerFormHelper();

        $this->app->singleton('laravel-form-builder', function ($app) {

            return new \Kris\LaravelFormBuilder\FormBuilder($app, $app['laravel-form-helper']);
        });

        $this->commands('Distilleries\FormBuilder\Console\FormMakeCommand');

        $this->alias();
    }

    protected function registerFormHelper()
    {
        $this->app->singleton('laravel-form-helper', function($app)
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
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'form-builder');

        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('form-builder.php')
        ]);
        $this->publishes([
            __DIR__.'/../../views'             => base_path('resources/views/vendor/form-builder'),
        ], 'views');


        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php',
            'form-builder'
        );
    }


    /**
     * Add Laravel Form to container if not already set
     */
    private function registerFormIfHeeded()
    {
        if (!$this->app->offsetExists('form')) {

            $this->app->singleton('form', function($app) {

                $form = new LaravelForm($app['html'], $app['url'], $app['session.store']->getToken());

                return $form->setSessionStore($app['session.store']);
            });

            if (! $this->aliasExists('Form')) {

                AliasLoader::getInstance()->alias(
                    'Form',
                    'Illuminate\Html\FormFacade'
                );
            }
        }
    }



    /**
     * Add Laravel Html to container if not already set
     */
    private function registerHtmlIfNeeded()
    {
        if (!$this->app->offsetExists('html')) {

            $this->app->singleton('html', function($app) {
                return new HtmlBuilder($app['url']);
            });

            if (! $this->aliasExists('Html')) {

                AliasLoader::getInstance()->alias(
                    'Html',
                    'Illuminate\Html\HtmlFacade'
                );
            }
        }
    }


    public function alias() {

        AliasLoader::getInstance()->alias(
            'FormBuilder',
            'Distilleries\FormBuilder\Facades\FormBuilder'
        );
        AliasLoader::getInstance()->alias(
            'Request',
            'Illuminate\Support\Facades\Request'
        );
        AliasLoader::getInstance()->alias(
            'Route',
            'Illuminate\Support\Facades\Route'
        );
        AliasLoader::getInstance()->alias(
            'File',
            'Illuminate\Support\Facades\File'
        );
        AliasLoader::getInstance()->alias(
            'Redirect',
            'Illuminate\Support\Facades\Redirect'
        );
    }


    /**
     * Check if an alias already exists in the IOC
     * @param $alias
     * @return bool
     */
    private function aliasExists($alias)
    {
        return array_key_exists($alias, AliasLoader::getInstance()->getAliases());
    }

}