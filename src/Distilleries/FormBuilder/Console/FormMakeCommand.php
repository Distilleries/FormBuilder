<?php namespace Distilleries\FormBuilder\Console;

class FormMakeCommand extends \Kris\LaravelFormBuilder\Console\FormMakeCommand
{

    protected function getStub()
    {
        return __DIR__.'/stubs/form-class-template.stub';
    }
}
