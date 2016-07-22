<?php namespace Distilleries\FormBuilder\Fields;

class FolderChooser extends FormFieldsView {

    protected function getTemplate()
    {
        return 'folder_chooser';
    }


    protected function getDefaults()
    {

        return [
            'label_chooser' => trans('forms.browse'),
            'badge_class'   => 'badge-success badge-roundless'
        ];
    }
}