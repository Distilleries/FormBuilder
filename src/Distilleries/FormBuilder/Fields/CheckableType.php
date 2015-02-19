<?php namespace Distilleries\FormBuilder\Fields;

class CheckableType extends FormFieldsView
{

    protected function getTemplate()
    {
        return $this->type;
    }

    public function getDefaults()
    {
        return [
            'attr' => ['class' => null],
            'default_value' => null,
            'label_attr' => ['id' => '', 'for' => ''],
            'checked' => false
        ];
    }
}