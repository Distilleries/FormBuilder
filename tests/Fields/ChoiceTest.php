<?php

class ChoiceTest extends FieldTestCase {

    public function testChoiceAreaRender()
    {

        $response = $this->call('POST', 'field', [
            'fields' => [
                'permission' => ['type' => 'choice_area', 'options' => []]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('permission');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\ChoiceArea', $field);
    }

    public function testRadioRender(){
        $response = $this->call('POST', 'field', [
            'fields' => [
                'choice_content' => ['type' => 'choice', 'options' =>  [
                    'expanded' => true,
                    'multiple' => false
                ]]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('choice_content');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\ChoiceType', $field);
    }
}