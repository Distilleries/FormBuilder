<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 11/02/2015
 * Time: 10:39 AM
 */

namespace Distilleries\FormBuilder;

use Kris\LaravelFormBuilder\Form;

class FormView extends Form {

    /**
     * Render full form
     *
     * @param array $options
     * @param bool $showFields
     * @return string
     */
    public function renderFormView(array $options = [])
    {
        return $this->view($options, $this->fields);
    }

    public function renderRestView($showFormEnd = true, $showFields = true)
    {
        $fields = $this->getUnrenderedFields();

        return $this->view([], $fields);
    }

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