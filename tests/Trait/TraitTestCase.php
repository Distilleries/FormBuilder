<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

abstract class TraitTestCase extends FormTestCase {


    public function setUp()
    {

        parent::setUp();

        $this->app['Illuminate\Contracts\Console\Kernel']->call('form:make', [
            'name'     => 'TestForm',
            '--fields' => 'id:hidden, name:text, email:email',
        ]);

        Schema::create('users', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->integer('status')->nullable();
            $table->timestamps();
        });

        User::create(['name' => 'John', 'email' => 'email@test', 'status' => \Distilleries\FormBuilder\Helpers\StaticLabel::STATUS_ONLINE]);
    }


    protected function getEnvironmentSetUp($app)
    {

        parent::getEnvironmentSetUp($app);

        $app['router']->controller('form', 'FormController');
        $app['router']->controller('validator', 'ValidationFormController');
        $app['router']->controller('save', 'SaveFormController');
        $app['router']->controller('save-after', 'AfterSaveFormController');

    }
}


use Distilleries\FormBuilder\FormValidator;

class TestForm extends FormValidator
{
    public static $rules        = [];
    public static $rules_update = null;

    public function buildForm()
    {
        $this
            ->add('id', 'hidden')
            ->add('name', 'text')
            ->add('email', 'email');

        $this->addDefaultActions();
    }
}


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'status'];

}


use Illuminate\Http\Request;

class FormController extends \Illuminate\Routing\Controller implements \Distilleries\FormBuilder\Contracts\FormStateContract {

    use \Distilleries\FormBuilder\States\FormStateTrait;

    public function __construct(User $model, TestForm $form)
    {
        $this->model = $model;
        $this->form  = $form;
    }

    public function getIndex()
    {

    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getEditSelected($id = '')
    {
        $model = (!empty($id)) ? $this->model->findOrFail($id) : $this->model;
        $form  = FormBuilder::create('TestSelectedForm', [
            'model' => $model
        ]);

        $form_content = view('form-builder::form.components.formgenerator.full', [
            'form' => $form
        ]);

        return view('form-builder::form.state.form', [
            'form' => $form_content
        ]);
    }


    public function postEditSubForm(Request $request)
    {
        $form = FormBuilder::create('TestSelectedForm', [
            'model' => $this->model
        ]);


        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $result = $this->beforeSave();

        if ($result != null)
        {
            return $result;
        }

        $result = $this->save($this->dataToSave($request), $request);

        if ($result != null)
        {
            return $result;
        }

        return redirect()->to(action($this->getControllerNameForAction().'@getIndex'));

    }

    // ------------------------------------------------------------------------------------------------
    public function postSearch()
    {

        $ids = Input::get('ids');


        if (!empty($ids))
        {
            $data = $this->model->whereIn($this->model->getKeyName(), $ids)->get();

            return Response::json($data);
        }

        $term  = Input::get('term');
        $page  = Input::get('page');
        $paged = Input::get('page_limit');

        if (empty($paged))
        {
            $paged = 10;
        }

        if (empty($page))
        {
            $page = 1;
        }
        if (empty($term))
        {
            $elements = array();
            $total    = 0;
        } else
        {
            $elements = $this->model->search($term)->take($paged)->skip(($page - 1) * $paged)->get();
            $total    = $this->model->search($term)->count();

        }

        return Response::json([
            'total'    => $total,
            'elements' => $elements
        ]);

    }

}



class TestValidatorForm extends FormValidator {

    public static $rules = [
        'email' => 'required|email|unique:users',
        'name'  => 'required',
    ];

    public static $rules_update = [
        'id'    => 'required',
        'email' => 'required|email|unique:users,email',
        'name'  => 'required'
    ];

    protected function getUpdateRules()
    {
        $key                           = $this->formHelper->getRequest()->get($this->model->getKeyName());
        static::$rules_update['email'] = 'required|email|unique:users,email,'.$key;

        return parent::getUpdateRules();
    }

    public function buildForm()
    {
        $this
            ->add('id', 'hidden')
            ->add('name', 'text')
            ->add('email', 'email', [
                'validation' => 'required,custom[email]',
            ])
            ->add('status', 'choice', [
                'choices'     => \Distilleries\FormBuilder\Helpers\StaticLabel::yesNo(),
                'empty_value' => '-',
                'validation'  => 'required',
                'selected'    => \Distilleries\FormBuilder\Helpers\StaticLabel::STATUS_ONLINE,
                'label'       => 'status'
            ]);

        $this->addDefaultActions();
    }


}


class TestSelectedForm extends FormValidator {

    public static $rules = [
        'email' => 'required|email|unique:users',
        'name'  => 'required',
    ];

    public static $rules_update = [
        'id'    => 'required',
        'email' => 'required|email|unique:users,email',
        'name'  => 'required'
    ];

    protected function getUpdateRules()
    {
        $key                           = $this->formHelper->getRequest()->get($this->model->getKeyName());
        static::$rules_update['email'] = 'required|email|unique:users,email,'.$key;

        return parent::getUpdateRules();
    }


    public function buildForm()
    {
        $this
            ->add('id', 'hidden')
            ->add('name', 'text')
            ->add('email', 'email', [
                'validation' => 'required,custom[email]',
            ])
            ->add('status', 'choice', [
                'choices'     => \Distilleries\FormBuilder\Helpers\StaticLabel::yesNo(),
                'empty_value' => '-',
                'validation'  => 'required',
                'label'       => 'status'
            ])
            ->add('testform', 'form', [
                'class' => FormBuilder::create('TestValidatorForm', [
                    'model' => new User
                ])
            ]);

        $this->addDefaultActions();
    }
}


class ValidationFormController extends \Illuminate\Routing\Controller implements \Distilleries\FormBuilder\Contracts\FormStateContract {

    use \Distilleries\FormBuilder\States\FormStateTrait;

    public function __construct(User $model, TestValidatorForm $form)
    {
        $this->model = $model;
        $this->form  = $form;
    }

    public function getIndex()
    {
        $model = (!empty($id)) ? $this->model->findOrFail($id) : $this->model;
        $form  = FormBuilder::create(get_class($this->form), [
            'model'                 => $model,
            'do_not_display_status' => true
        ]);

        $form_content = view('form-builder::form.components.formgenerator.full', [
            'form' => $form
        ]);

        return view('form-builder::form.state.form', [
            'form' => $form_content
        ]);
    }

    // ------------------------------------------------------------------------------------------------

    public function getViewAll($id)
    {
        $model = (!empty($id)) ? $this->model->findOrFail($id) : $this->model;
        $form  = FormBuilder::create(get_class($this->form), [
            'model' => $model
        ]);

        $form_content = view('form-builder::form.components.formgenerator.info_all', [
            'form'  => $form,
            'id'    => $id,
            'route' => $this->getControllerNameForAction().'@',
        ]);


        return view('form-builder::form.state.form', [
            'form' => $form_content
        ]);

    }

}


class SaveFormController extends \Illuminate\Routing\Controller implements \Distilleries\FormBuilder\Contracts\FormStateContract {

    use \Distilleries\FormBuilder\States\FormStateTrait;

    public function __construct(User $model, TestValidatorForm $form)
    {
        $this->model = $model;
        $this->form  = $form;
    }

    public function getIndex()
    {

    }

    // ------------------------------------------------------------------------------------------------

    protected function beforeSave()
    {
        return redirect()->to(action($this->getControllerNameForAction().'@getIndex'));
    }

}


class AfterSaveFormController extends \Illuminate\Routing\Controller implements \Distilleries\FormBuilder\Contracts\FormStateContract {

    use \Distilleries\FormBuilder\States\FormStateTrait;

    public function __construct(User $model, TestValidatorForm $form)
    {
        $this->model = $model;
        $this->form  = $form;
    }

    public function getIndex()
    {

    }

    // ------------------------------------------------------------------------------------------------

    protected function afterSave()
    {
        return redirect()->to(action($this->getControllerNameForAction().'@getIndex'));
    }

}