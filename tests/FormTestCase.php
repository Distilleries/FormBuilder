<?php


abstract class FormTestCase extends \Orchestra\Testbench\BrowserKit\TestCase
{

    public function setUp(){

        parent::setUp();
        $this->app['Illuminate\Contracts\Console\Kernel']->call('vendor:publish');
        $this->refreshApplication();
    }

    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'KernelTestCase');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', array(
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ));
    }


    protected function getPackageProviders($application)
    {
        return [
            'Distilleries\FormBuilder\FormBuilderServiceProvider'
        ];
    }

    protected function getPackageAliases($application)
    {
        return [
            'FormBuilder'   => 'Distilleries\FormBuilder\Facades\FormBuilder'
        ];
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

}

use Orchestra\Testbench\Http\Kernel as BaseKernel;
class Kernel extends BaseKernel
{

    protected $bootstrappers = [];

    protected $middleware = [
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
    ];
}
