<?php

class FormTest extends FieldTestCase {

    public function testNotAForm()
    {

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

            // Use to handle https://phpunit.de/manual/current/en/risky-tests.html 
            $this->assertTrue(true);

        }catch (Exception $e){

            $this->assertEquals('Please provide instance of Form class.',$e->getMessage());
        }
    }
}