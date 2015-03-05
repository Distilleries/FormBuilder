<?php

return [
    'defaults'       => [
        'wrapper_class'       => 'form-group',
        'wrapper_error_class' => 'has-error',
        'label_class'         => 'control-label',
        'field_class'         => 'form-control',
        'error_class'         => 'help-block text-danger'
    ],
    'moxy_manager_path'=>'/assets/moxiemanager/plugin.min.js',
    // Templates
    'form'           => 'form-builder::form.partial.form',
    'text'           => 'form-builder::form.partial.text',
    'textarea'       => 'form-builder::form.partial.textarea',
    'button'         => 'form-builder::form.partial.button',
    'radio'          => 'form-builder::form.partial.radio',
    'checkbox'       => 'form-builder::form.partial.checkbox',
    'select'         => 'form-builder::form.partial.select',
    'choice'         => 'form-builder::form.partial.choice',
    'repeated'       => 'form-builder::form.partial.repeated',
    'child_form'     => 'form-builder::form.partial.child_form',
    'tinymce'        => 'form-builder::form.partial.tinymce',
    'tag'            => 'form-builder::form.partial.tag',
    'choice_area'    => 'form-builder::form.partial.choice_area',
    'address_picker' => 'form-builder::form.partial.address_picker',
    'choice_ajax'    => 'form-builder::form.partial.choice_ajax',
    'datepicker'     => 'form-builder::form.partial.datepicker',
    'upload'         => 'form-builder::form.partial.upload',

    'custom_fields'  => [
        'button'         => 'Distilleries\FormBuilder\Fields\ButtonType',
        'radio'          => 'Distilleries\FormBuilder\Fields\CheckableType',
        'checkbox'       => 'Distilleries\FormBuilder\Fields\CheckableType',
        'text'           => 'Distilleries\FormBuilder\Fields\InputType',
        'email'          => 'Distilleries\FormBuilder\Fields\InputType',
        'upload'         => 'Distilleries\FormBuilder\Fields\UploadType',
        'number'         => 'Distilleries\FormBuilder\Fields\InputType',
        'select'         => 'Distilleries\FormBuilder\Fields\SelectType',
        'textarea'       => 'Distilleries\FormBuilder\Fields\TextareaType',
        'tinymce'        => 'Distilleries\FormBuilder\Fields\Tinymce',
        'tag'            => 'Distilleries\FormBuilder\Fields\Tag',
        'choice'         => 'Distilleries\FormBuilder\Fields\ChoiceType',
        'form'           => 'Distilleries\FormBuilder\Fields\ChildFormType',
        'choice_area'    => 'Distilleries\FormBuilder\Fields\ChoiceArea',
        'address_picker' => 'Distilleries\FormBuilder\Fields\AddressPicker',
        'choice_ajax'    => 'Distilleries\FormBuilder\Fields\ChoiceAjax',
        'datepicker'     => 'Distilleries\FormBuilder\Fields\DatePicker',
    ]
];
