<?php

class TextAreaTest extends FieldTestCase {

    public function testRender()
    {

        $response = $this->call('POST', 'field', [
            'fields' => [
                'textarea' => ['type' => 'textarea', 'options' => []]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('textarea');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\TextAreaType', $field);
    }

}