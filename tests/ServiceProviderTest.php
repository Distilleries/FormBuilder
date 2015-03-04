<?php

class ServiceProviderTest extends FormTestCase {

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

}

