<?php

class ServiceProviderTest extends FormTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('form-builder.cloudinary.enabled', true);
        $app['config']->set('form-builder.cloudinary.cloud_name', 'test_cloud_name');
        $app['config']->set('form-builder.cloudinary.api_key', 'test_api_key');
        $app['config']->set('form-builder.cloudinary.api_secret', 'test_api_secret');
    }

    public function testService()
    {
        $service = $this->app->getProvider('Distilleries\FormBuilder\FormBuilderServiceProvider');
        $facades = $service->provides();

        $this->assertTrue(['laravel-form-builder'] == $facades);
        $service->boot();
        $service->register();
    }

    public function testHelper()
    {
        $helper = $this->app->make('Kris\LaravelFormBuilder\FormHelper');
        $this->assertEquals($this->app->view, $helper->getView());
        $this->assertEquals($this->app->request, $helper->getRequest());
    }

    public function testCloudinaryConfig()
    {
        $config = Cloudinary::config();

        $this->assertThat(
            $config,
            $this->arrayHasKey('cloud_name')
        );
        $this->assertThat(
            $config['cloud_name'],
            $this->equalTo('test_cloud_name')
        );
        $this->assertThat(
            $config,
            $this->arrayHasKey('api_key')
        );
        $this->assertThat(
            $config['api_key'],
            $this->equalTo('test_api_key')
        );
        $this->assertThat(
            $config,
            $this->arrayHasKey('api_secret')
        );
        $this->assertThat(
            $config['api_secret'],
            $this->equalTo('test_api_secret')
        );
    }
}

