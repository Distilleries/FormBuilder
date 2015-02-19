<?php namespace Distilleries\FormBuilder\Fields;

class ButtonType extends FormFieldsView
{
    protected function getTemplate()
    {
        return 'button';
    }

    protected function getDefaults()
    {
        return [
            'attr' => ['type' => $this->type]
        ];
    }
}
