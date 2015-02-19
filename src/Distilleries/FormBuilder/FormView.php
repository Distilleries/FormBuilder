<?php namespace Distilleries\FormBuilder;

use Kris\LaravelFormBuilder\Form;

class FormView extends Form {


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function add($name, $type = 'text', array $options = [], $modify = false, $noOveride = false)
    {


        if (!isset($options['noInEditView']))
        {
            $options['noInEditView'] = false;
        }


        if (!empty($this->formOptions) && !empty($this->formOptions['do_not_display_' . $name]) && $this->formOptions['do_not_display_' . $name] === true)
        {
            $type = 'hidden';

            if (!empty($options) && !empty($options['selected']))
            {
                $options['default_value'] = $options['selected'];
            }

        }

        return parent::add($name, $type, $options, $modify);
    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function renderFormView(array $options = [])
    {
        return $this->view($options, $this->fields);
    }

    // ------------------------------------------------------------------------------------------------


    public function renderRestView()
    {
        $fields = $this->getUnrenderedFields();

        return $this->view([], $fields);
    }

    // ------------------------------------------------------------------------------------------------

    protected function view($options, $fields)
    {
        $formOptions = $this->formHelper->mergeOptions($this->formOptions, $options);

        return $this->formHelper->getView()
            ->make($this->formHelper->getConfig('form'))
            ->with(['showFields' => true])
            ->with(['showEnd' => false])
            ->with(['showStart' => false])
            ->with(['isNotEditable' => true])
            ->with('formOptions', $formOptions)
            ->with('fields', $fields)
            ->with('model', $this->getModel())
            ->render();
    }
}