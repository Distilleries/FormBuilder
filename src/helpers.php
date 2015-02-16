<?php

    use Distilleries\FormBuilder\Fields\FormField;
    use Distilleries\FormBuilder\Form;

    if (!function_exists('form')) {

        function form(Form $form, array $options = [])
        {
            return $form->renderForm($options);
        }

    }

    if (!function_exists('form_start')) {

        function form_start(Form $form, array $options = [])
        {
            return $form->renderForm($options, true, false, false);
        }

    }

    if (!function_exists('form_end')) {

        function form_end(Form $form, $showFields = true)
        {
            return $form->renderRest(true, $showFields);
        }

    }

    if (!function_exists('form_rest')) {

        function form_rest(Form $form)
        {
            return $form->renderRest(false);
        }

    }

    if (!function_exists('form_row')) {

        function form_row(FormField $formField, array $options = [])
        {
            return $formField->render($options);
        }

    }

    if (!function_exists('form_label')) {

        function form_label(FormField $formField, array $options = [])
        {
            return $formField->render($options, true, false, false);
        }

    }

    if (!function_exists('form_widget')) {

        function form_widget(FormField $formField, array $options = [])
        {
            return $formField->render($options, false, true, false);
        }

    }

    if (!function_exists('form_errors')) {

        function form_errors(FormField $formField, array $options = [])
        {
            return $formField->render($options, false, false, true);
        }

    }

    if (!function_exists('prepare_attributes')) {

        function prepare_attributes($options)
        {
            $attributes = [];

            foreach ($options as $name => $option) {
                if ($option !== null) {
                    $attributes[] = $name . '="' . $option . '" ';
                }
            }

            return join('', $attributes);
        }

    }

    if (!function_exists('form_widget_view')) {

        function form_widget_view(FormField $formField, array $options = [])
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
            return $form->renderRestView(false);
        }

    }
