<?php

class FormTest extends FieldTestCase {

    public function testNotAForm()
    {
        $this->disableExceptionHandling();

        try{
        
             $this->call('POST', 'field', [
                'fields' => [
                    'sub_form' => [
                        'type' => 'form',
                        'options' => [
                            'class' => new User
                        ]
                    ]
                ]
            ]);

        }catch (Exception $e){

            $this->assertEquals('Please provide instance of Form class.',$e->getMessage());
        }
    }
}