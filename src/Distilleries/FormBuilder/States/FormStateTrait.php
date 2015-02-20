<?php namespace Distilleries\FormBuilder\States;

use \FormBuilder;
use \Request;
use \Redirect;

trait FormStateTrait {

    /**
     * @var \Kris\LaravelFormBuilder\Form $form
     * Injected by the constructor
     */
    protected $form;

    /**
     * @var \Illuminate\Database\Eloquent\Model $model
     * Injected by the constructor
     */
    protected $model;


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getEdit($id = '')
    {
        $model = (!empty($id)) ? $this->model->findOrFail($id) : $this->model;
        $form  = FormBuilder::create(get_class($this->form), [
            'model' => $model
        ]);

        $form_content = view('form-builder::form.components.formgenerator.full', [
            'form' => $form
        ]);

        return view('form-builder::form.state.form',[
            'form'=>$form_content
        ]);
    }

    // ------------------------------------------------------------------------------------------------

    public function postEdit()
    {
        $form = FormBuilder::create(get_class($this->form), [
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

        $result = $this->save($this->dataToSave());

        if ($result != null)
        {
            return $result;
        }

        return Redirect::to(action($this->getControllerNameForAction().'@getIndex'));

    }

    // ------------------------------------------------------------------------------------------------

    protected function dataToSave()
    {
        return Request::only($this->model->getFillable());
    }

    // ------------------------------------------------------------------------------------------------

    protected function beforeSave()
    {
        return null;
    }

    // ------------------------------------------------------------------------------------------------

    protected function afterSave()
    {
        return null;
    }


    // ------------------------------------------------------------------------------------------------

    protected function save($data)
    {

        if (!empty($result))
        {
            return $result;
        }

        $primary = Request::get($this->model->getKeyName());
        if (empty($primary))
        {
            $this->model = $this->model->create($data);
        } else
        {
            $this->model = $this->model->find($primary);
            $this->model->update($data);
        }

        $result = $this->afterSave();

        if (!empty($result))
        {
            return $result;
        }

        return null;

    }


    // ------------------------------------------------------------------------------------------------

    public function getView($id)
    {
        $model = (!empty($id)) ? $this->model->findOrFail($id) : $this->model;
        $form  = FormBuilder::create(get_class($this->form), [
            'model' => $model
        ]);

        $form_content = view('form-builder::form.components.formgenerator.info', [
            'form'  => $form,
            'id'    => $id,
            'route' => !empty($action) ? $this->getControllerNameForAction(). '@' : '',
        ]);

        return view('form-builder::form.state.form');

    }

    // ------------------------------------------------------------------------------------------------

    protected function getControllerNameForAction() {

        $namespace = \Route::current()->getAction()['namespace'];
        $action    = explode('@', \Route::currentRouteAction());

        if (!empty($namespace))
        {
            $action[0] = ltrim(str_replace($namespace, '', $action[0]), '\\');
        }

        return $action[0];
    }
}