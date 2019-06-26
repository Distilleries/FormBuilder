<?php

use Illuminate\Contracts\Debug\ExceptionHandler;

abstract class FormTestCase extends \Orchestra\Testbench\BrowserKit\TestCase
{

    public function setUp(): void {

        parent::setUp();
        $this->app['Illuminate\Contracts\Console\Kernel']->call('vendor:publish', ['--all' => true]);
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

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }


    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
        $this->app->instance(ExceptionHandler::class, new class extends \Illuminate\Foundation\Exceptions\Handler
        {
            public function __construct()
            {
            }
            public function report(\Exception $e)
            {
            }
            public function render($request, \Exception $e)
            {
                throw $e;
            }
        }
        );
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
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
