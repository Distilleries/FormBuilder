<?php

class UploadTypeTest extends FieldTestCase {

    public function testRender()
    {

        $response = $this->call('POST', 'field', [
            'fields' => [
                'upload_content' => ['type' => 'upload', 'options' => []]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('upload_content');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\UploadType', $field);
    }

}