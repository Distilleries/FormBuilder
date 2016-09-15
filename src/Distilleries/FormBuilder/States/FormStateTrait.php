<?php namespace Distilleries\FormBuilder\States;

use \FormBuilder;
use Illuminate\Http\Request;

trait FormStateTrait {

    /**
     * @var \Kris\LaravelFormBuilder\Form $form
     * Injected by the constructor
     */
    protected $form;
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

        return view('form-builder::form.state.form', [
            'form'=>$form_content
        ]);
    }

    // ------------------------------------------------------------------------------------------------

    public function postEdit(Request $request)
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

        $result = $this->save($this->dataToSave($request), $request);

        if ($result != null)
        {
            return $result;
        }

        return redirect(action($this->getControllerNameForAction().'@getIndex'));

    }

    // ------------------------------------------------------------------------------------------------

    protected function dataToSave(Request $request)
    {
        return $request->only($this->model->getFillable());
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

    protected function save($data, Request $request)
    {

        $primary = $request->get($this->model->getKeyName());
        if (empty($primary))
        {
            $this->model = $this->model->create($data);
        } else
        {
            $this->model = $this->model->find($primary);
            $this->model->update($data);
        }

        return $this->afterSave();
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
            'route' => $this->getControllerNameForAction().'@',
        ]);


        return view('form-builder::form.state.form', [
            'form'=>$form_content
        ]);

    }

    // ------------------------------------------------------------------------------------------------

    protected function getControllerNameForAction() {

        $action = explode('@', \Route::currentRouteAction());

        return '\\'.$action[0];
    }
}