<?php

return [
    'defaults'       => [
        'wrapper_class'       => 'form-group',
        'wrapper_error_class' => 'has-error',
        'label_class'         => 'control-label',
        'field_class'         => 'form-control',
        'error_class'         => 'help-block text-danger'
    ],
    // Templates
    'form'           => 'laravel-form-builder::form.partial.form',
    'text'           => 'laravel-form-builder::form.partial.text',
    'textarea'       => 'laravel-form-builder::form.partial.textarea',
    'button'         => 'laravel-form-builder::form.partial.button',
    'radio'          => 'laravel-form-builder::form.partial.radio',
    'checkbox'       => 'laravel-form-builder::form.partial.checkbox',
    'select'         => 'laravel-form-builder::form.partial.select',
    'choice'         => 'laravel-form-builder::form.partial.choice',
    'repeated'       => 'laravel-form-builder::form.partial.repeated',
    'child_form'     => 'laravel-form-builder::form.partial.child_form',
    'tinymce'        => 'laravel-form-builder::form.partial.tinymce',
    'tag'            => 'laravel-form-builder::form.partial.tag',
    'choice_area'    => 'laravel-form-builder::form.partial.choice_area',
    'address_picker' => 'laravel-form-builder::form.partial.address_picker',
    'choice_ajax'    => 'laravel-form-builder::form.partial.choice_ajax',
    'datepicker'     => 'laravel-form-builder::form.partial.datepicker',
    'upload'         => 'laravel-form-builder::form.partial.upload',

    'custom_fields'  => [
        'button'         => 'Distilleries\FormBuilder\Fields\ButtonType',
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
