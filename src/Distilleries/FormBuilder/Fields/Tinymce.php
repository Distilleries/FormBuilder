<?php namespace Distilleries\FormBuilder\Fields;

class Tinymce extends FormFieldsView {

    protected function getTemplate()
    {
        return 'tinymce';
    }


    protected function getDefaults()
    {

        return [
            'moxiemanager' => (\File::exists(public_path($this->formHelper->getConfig('moxy_manager_path')))?$this->formHelper->getConfig('moxy_manager_path'):false),

        ];
    }
}