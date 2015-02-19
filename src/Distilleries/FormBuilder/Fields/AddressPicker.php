<?php namespace Distilleries\FormBuilder\Fields;

class AddressPicker extends FormFieldsView {

    protected function getTemplate()
    {
        return 'address_picker';
    }

    protected function getDefaults()
    {
        return [
            'default_value' => [
                'lat'     => 0,
                'lng'     => 0,
                'street'  => '',
                'city'    => '',
                'country' => '',
                'state'   => '',
                'default' => '',
            ]
        ];
    }
}
