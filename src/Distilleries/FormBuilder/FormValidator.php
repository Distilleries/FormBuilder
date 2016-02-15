<?php namespace Distilleries\FormBuilder;

use \Validator;
use \Redirect;

class FormValidator extends FormView {

    public static $rules = [];
    public static $rules_update = null;

    // ------------------------------------------------------------------------------------------------

    protected $hasError = false;
    protected $validation = null;
    protected $formOptions = [
        'method' => 'POST',
        'url'    => null,
    ];

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    /**
     * @param string $name
     * @param string $type
     * @param array $options
     * @param bool $modify
     * @param bool $noOveride
     * @return $this
     */
    public function add($name, $type = 'text', array $options = [], $modify = false, $noOveride = false)
    {

        $defaultClass = $this->formHelper->getConfig('defaults.field_class').' ';
        if (empty($options['attr']['class']))
        {
            $options['attr']['class'] = '';
        }

        if (empty($noOveride))
        {
            $options['attr']['class'] = $defaultClass.' '.$options['attr']['class'].' ';
        }

        if (!empty($options) && isset($options['validation']))
        {

            $options['attr']['class'] .= ' validate['.$options['validation'].']'.' ';
            unset($options['validation']);
        }

        return parent::add($name, $type, $options, $modify);
    }

    // ------------------------------------------------------------------------------------------------

    public function validateAndRedirectBack()
    {
        return Redirect::back()->withErrors($this->validate())->withInput($this->formHelper->getRequest()->all());

    }

    // ------------------------------------------------------------------------------------------------

    public function validate()
    {
        if ($this->validation == null)
        {

            $fields = $this->getFields();

            foreach ($fields as $field)
            {
                if ($field->getType() == 'form')
                {

                    $validation = Validator::make($this->formHelper->getRequest()->get($field->getName(),[]), $field->getClass()->getRules());

                    if ($validation->fails())
                    {
                        $this->hasError   = true;
                        $this->validation = $validation;

                        return $this->validation;
                    }
                }
            }

            $validation = Validator::make($this->formHelper->getRequest()->all(), $this->getRules());

            if ($validation->fails())
            {
                $this->hasError = true;
            }

            $this->validation = $validation;
        }

        return $this->validation;
    }

    // ------------------------------------------------------------------------------------------------

    public function hasError()
    {

        if ($this->validation == null)
        {
            $this->validate();
        }

        return $this->hasError;
    }


    // ------------------------------------------------------------------------------------------------

    public function addDefaultActions()
    {
        $this->add('submit', 'submit',
            [
                'label' => trans('form-builder::form.save'),
                'attr'  => [
                    'class' => 'btn green'
                ],
            ], false, true)
            ->add('back', 'button',
                [
                    'label' => trans('form-builder::form.back'),
                    'attr'  => [
                        'class'   => 'btn default',
                        'onclick' => 'window.history.back()'
                    ],
                ], false, true);

    }

    // ------------------------------------------------------------------------------------------------

    protected function getRules()
    {
        $key = !empty($this->model) ? $this->formHelper->getRequest()->get($this->model->getKeyName()) : null;

        return ($this->getUpdateRules() == null || empty($key)) ? $this->getGeneralRules() : $this->getUpdateRules();
    }

    // ------------------------------------------------------------------------------------------------

    protected function getGeneralRules()
    {

        return static::$rules;
    }

    // ------------------------------------------------------------------------------------------------

    protected function getUpdateRules()
    {

        return static::$rules_update;
    }
}