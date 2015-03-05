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

    public function testRadioOptionChoiceRender(){
        $response = $this->call('POST', 'field', [
            'fields' => [
                'choice_content' => ['type' => 'choice', 'options' =>  [
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => \Distilleries\FormBuilder\Helpers\StaticLabel::yesNo()
                ]]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('choice_content');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\ChoiceType', $field);
    }

    public function testCheckboxRender(){
        $response = $this->call('POST', 'field', [
            'fields' => [
                'choice_content' => ['type' => 'choice', 'options' =>  [
                    'expanded' => true,
                    'multiple' => true
                ]]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('choice_content');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\ChoiceType', $field);
    }

    public function testSelectMultipleRender(){
        $response = $this->call('POST', 'field', [
            'fields' => [
                'choice_content' => ['type' => 'choice', 'options' =>  [
                    'expanded' => false,
                    'multiple' => true
                ]]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('choice_content');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\ChoiceType', $field);
    }

    public function testSelectRender(){
        $response = $this->call('POST', 'field', [
            'fields' => [
                'choice_content' => ['type' => 'choice', 'options' =>  [
                    'expanded' => false,
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

    public function testSelectTypeRender(){
        $response = $this->call('POST', 'field', [
            'fields' => [
                'choice_content' => ['type' => 'select', 'options' =>  []]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('choice_content');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\SelectType', $field);
    }

    public function testCheckTypeRender(){
        $response = $this->call('POST', 'field', [
            'fields' => [
                'choice_content' => ['type' => 'checkbox', 'options' =>  []]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('choice_content');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\CheckableType', $field);
    }

    public function testChoiceAjaxRender(){
        $response = $this->call('POST', 'field', [
            'fields' => [
                'choice_content' => ['type' => 'choice_ajax', 'options' =>  []]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form  = $response->original->getData()['form']->getData()['form'];
        $field = $form->getField('choice_content');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\ChoiceAjax', $field);
    }
}