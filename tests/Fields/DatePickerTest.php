<?php

class DatePickerTest extends FieldTestCase {

    public function testRender()
    {

        $response = $this->call('POST', 'field', [
            'fields' => [
                'date' => ['type' => 'datepicker', 'options' => []]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('date');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\DatePicker', $field);
    }

}