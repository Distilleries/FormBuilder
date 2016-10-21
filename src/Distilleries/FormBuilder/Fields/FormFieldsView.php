<?php namespace Distilleries\FormBuilder\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

abstract class FormFieldsView extends FormField {

    public function view(array $options = [], $showLabel = true, $showField = true, $showError = false)
    {

        $this->rendered = true;
        $options        = $this->prepareOptions($options);

        if (!$this->needsLabel($options))
        {
            $showLabel = false;
        }

        if (!empty($options['noInEditView']) && $options['noInEditView'] === true) {
            return '';
        }

        if (isset($options['default_value'])) {
            $options['value'] = $options['default_value'];
        }

        return $this->formHelper->getView()->make(
            $this->template, [
                'name'      => $this->name,
                'type'      => $this->type,
                'options'   => $options,
                'noEdit'    => true,
                'showLabel' => $showLabel,
                'showField' => $showField,
                'showError' => $showError
            ])
            ->render();
    }
}