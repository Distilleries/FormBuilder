<?php

class AddressPickerTest extends FieldTestCase {

    public function testRender()
    {

        $response = $this->call('POST', 'field', [
            'fields' => [
                'address' => ['type' => 'address_picker', 'options' => []]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('address');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\AddressPicker', $field);
    }

}