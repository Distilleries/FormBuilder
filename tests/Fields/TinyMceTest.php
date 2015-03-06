<?php

class TinyMceTest extends FieldTestCase {

    public function testRender()
    {

        $response = $this->call('POST', 'field', [
            'fields' => [
                'tiny_content' => ['type' => 'tinymce', 'options' => []]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('tiny_content');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\Tinymce', $field);
    }

}