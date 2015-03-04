<?php


abstract class FieldTestCase extends FormTestCase {

    protected $plainForm;


    protected function getEnvironmentSetUp($app)
    {

        parent::getEnvironmentSetUp($app);

        $app['router']->controller('field', 'FieldController');

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
        $form  = \FormBuilder::plain([
            'model' => $model
        ]);

        dd(get_class($form));

        $fields = $request->get('fields');

        foreach ($fields as $name => $field)
        {
            $form->add($name, $field['type'],$field['options']);
        }

        $form_content = view('form-builder::form.components.formgenerator.full', [
            'form' => $form
        ]);

        return view('form-builder::form.state.form', [
            'form' => $form_content
        ]);

    }
}