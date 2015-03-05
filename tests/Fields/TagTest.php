<?php

class TagTest extends FieldTestCase {

    public function testRender()
    {

        $response = $this->call('POST', 'field', [
            'fields' => [
                'tag' => ['type' => 'tag', 'options' => []]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('tag');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\Tag', $field);
    }

    public function testNotInEditViewRender()
    {

        $response = $this->call('POST', 'field', [
            'fields' => [
                'tag' => ['type' => 'tag', 'options' => ['noInEditView'=>true]]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('tag');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\Tag', $field);
    }

    public function testInEditViewWithOptionRender()
    {

        $response = $this->call('POST', 'field', [
            'fields' => [
                'tag' => ['type' => 'tag', 'options' => ['noInEditView'=>false]]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('tag');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\Tag', $field);
    }

}