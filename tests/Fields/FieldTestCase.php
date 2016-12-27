<?php


abstract class FieldTestCase extends FormTestCase {

    protected $plainForm;


    protected function getEnvironmentSetUp($app)
    {

        parent::getEnvironmentSetUp($app);

        $app['router']->post('field', 'FieldController@postIndex');


    }

}


use Illuminate\Http\Request;

class FieldController extends \Illuminate\Routing\Controller {


    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function postIndex(Request $request)
    {
        $model = $this->model;

        $form = app('Distilleries\FormBuilder\FormValidator')
        ->setFormHelper(app('laravel-form-helper'))
        ->setFormBuilder(new  Kris\LaravelFormBuilder\FormBuilder(app(),app('laravel-form-helper')))
        ->setFormOptions([
            'model' => $model
        ]);

        $fields = $request->get('fields');

        foreach ($fields as $name => $field)
        {

            $form->add($name, $field['type'],$field['options']);
        }

        $form_content = view('form-builder::form.components.formgenerator.info_all', [
            'form' => $form
        ]);

        return view('form-builder::form.state.form', [
            'form' => $form_content
        ]);

    }
}