<?php namespace Distilleries\FormBuilder\Fields;

class SelectType extends FormFieldsView
{

    protected function getTemplate()
    {
        return 'select';
    }

    public function getDefaults()
    {
        return [
            'choices' => [],
            'empty_value' => null,
            'selected' => null
        ];
    }
}