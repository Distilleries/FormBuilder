<?php namespace Distilleries\FormBuilder\Fields;

class ChoiceAjax extends FormFieldsView {

    protected function getTemplate()
    {
        return 'choice_ajax';
    }

    protected function getDefaults()
    {
        return [
            'action'                 => '',
            'maximum_selection_size' => - 1,
            'multiple'               => 'false',
            'minimumInputLength'     => 2,
            'allowClear'             => 'true',
            'formatter'              => [
                'id'      => 'id',
                'libelle' => 'libelle',
            ]
        ];
    }
}