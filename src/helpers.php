<?php


if (!function_exists('form_widget_view')) {

    function form_widget_view(\Distilleries\FormBuilder\Fields\FormFieldsView $formField, array $options = [])
    {
        return $formField->view($options, false, true, false);
    }

}

if (!function_exists('form_view')) {

    function form_view(\Distilleries\FormBuilder\FormView $form, array $options = [])
    {
        return $form->renderFormView($options);
    }

}

if (!function_exists('form_rest_view')) {

    function form_rest_view(\Distilleries\FormBuilder\FormView $form)
    {
        return $form->renderRestView();
    }

}