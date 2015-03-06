<?php

class ParentTest extends FieldTestCase {

    public function testChildren()
    {
        $response = $this->call('POST', 'field', [
            'fields' => [
                'choice_content' => ['type'    => 'choice', 'options' => [
                    'expanded' => false,
                    'multiple' => false
                ],
                'choices' => [
                    'option_test'=>'test'
                ]
                ]
            ]
        ]);

        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form     = $response->original->getData()['form']->getData()['form'];
        $field    = $form->getField('choice_content');
        $children = $field->getChildren();

        foreach ($children as $key=>$child)
        {
            $this->assertEquals(get_class($child),get_class($field->{$key}));
            $this->assertInstanceOf('Distilleries\FormBuilder\Fields\SelectType', $child);
        }
    }
}