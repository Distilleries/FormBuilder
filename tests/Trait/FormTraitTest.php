<?php


class FormTraitTest extends TraitTestCase {

    public function testAdd()
    {

        $response = $this->call('GET', 'form/edit');
        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form = $response->original->getData()['form']->getData()['form'];
        $name = $form->getField('name');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\InputType', $name);
    }

    public function testEdit()
    {
        $response = $this->call('GET', 'form/edit/1');
        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form = $response->original->getData()['form']->getData()['form'];
        $name = $form->getField('name');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\InputType', $name);

    }

    public function testView()
    {
        $response = $this->call('GET', 'form/view/1');
        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form = $response->original->getData()['form']->getData()['form'];
        $name = $form->getField('name');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\InputType', $name);
    }

    public function testViewAll()
    {
        $response = $this->call('GET', 'validator/view-all/1');
        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form = $response->original->getData()['form']->getData()['form'];
        $name = $form->getField('name');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\InputType', $name);
    }

    public function testViewNotDisplayName()
    {
        $this->call('GET', 'validator');
        $this->assertResponseOk();
        $this->assertViewHas('form');
    }

    public function testPostAddRedirect()
    {
        $faker = Faker\Factory::create();
        $data  = [
            'name'  => $faker->name,
            'email' => $faker->email,
        ];

        $this->call('POST', 'form/edit', $data);
        $this->assertRedirectedTo('form');
    }

    public function testPostAdd()
    {
        $faker = Faker\Factory::create();
        $data  = [
            'name'  => $faker->name,
            'email' => $faker->email,
        ];

        $this->call('POST', 'form/edit', $data);

        $user = User::get()->last();

        $this->assertEquals($user->name, $data['name']);
        $this->assertEquals($user->email, $data['email']);
    }


    public function testPostAddRedirectError()
    {
        $oldUser = User::where('id', '=', 1)->get()->last();
        $faker   = Faker\Factory::create();
        $data    = [
            'name'  => $faker->name,
            'email' => 'email@test',
        ];

        $this->call('POST', 'validator/edit/1', $data);
        $this->assertRedirectedTo('/');
        $this->assertSessionHasErrors('email');
    }

    public function testPostUpdate()
    {

        $oldUser = User::where('id', '=', 1)->get()->last();
        $faker   = Faker\Factory::create();
        $data    = [
            'id'    => $oldUser->id,
            'name'  => $oldUser->name,
            'email' => $faker->email,
        ];

        $this->call('POST', 'form/edit/1', $data);

        $user = User::where('id', '=', 1)->get()->last();

        $this->assertEquals($user->id, $oldUser->id);
        $this->assertEquals($user->name, $oldUser->name);
        $this->assertEquals($user->email, $data['email']);

    }


    public function testPostUpdateRedirect()
    {

        $oldUser = User::where('id', '=', 1)->get()->last();
        $faker   = Faker\Factory::create();
        $data    = [
            'id'    => $oldUser->id,
            'name'  => $oldUser->name,
            'email' => $faker->email,
        ];

        $this->call('POST', 'form/edit/1', $data);
        $this->assertRedirectedTo('form');

    }

    public function testPostUpdateRedirectError()
    {
        $oldUser = User::where('id', '=', 1)->get()->last();
        $faker   = Faker\Factory::create();
        $data    = [
            'id'    => $oldUser->id,
            'email' => $faker->email,
        ];

        $this->call('POST', 'validator/edit/1', $data);
        $this->assertRedirectedTo('/');
        $this->assertSessionHasErrors('name');
    }

    public function testOverrideReturnBeforeSave()
    {
        $faker = Faker\Factory::create();
        $data  = [
            'name'  => $faker->name,
            'email' => $faker->email,
        ];

        $this->call('POST', 'save/edit', $data);
        $this->assertRedirectedTo('save');
    }

    public function testOverrideReturnAfterSave()
    {
        $faker = Faker\Factory::create();
        $data  = [
            'name'  => $faker->name,
            'email' => $faker->email,
        ];

        $this->call('POST', 'save-after/edit', $data);
        $this->assertRedirectedTo('save-after');
    }

    public function testEditSelectedChoice()
    {
        $response = $this->call('GET', 'form/edit-selected/1');
        $this->assertResponseOk();
        $this->assertViewHas('form');

        $form = $response->original->getData()['form']->getData()['form'];
        $name = $form->getField('name');
        $this->assertInstanceOf('Distilleries\FormBuilder\Fields\InputType', $name);

    }

    public function testPostAddSubFormRedirectError()
    {

        $faker = Faker\Factory::create();
        $data  = [
            'name'     => $faker->name,
            'email'    => 'email@test',
            'status'   => 1,
            'testform' => [
                'name' => 'other'
            ]
        ];

        $this->call('POST', 'form/edit-sub-form', $data);
        $this->assertRedirectedTo('/');
        $this->assertSessionHasErrors();
    }

    public function testPostAddSubFormRedirectNoError()
    {

        $faker = Faker\Factory::create();
        $data  = [
            'name'     => $faker->name,
            'email'    => $faker->email,
            'testform' => [
                'email'  => 'toto@toto.com',
                'name'   => 'toto'
            ]
        ];

        $this->call('POST', 'form/edit-sub-form', $data);
        $this->assertRedirectedTo('/form');
    }

    public function testOverrideAfterValidation()
    {
        $oldUser = User::where('id', '=', 1)->get()->last();
        $faker   = Faker\Factory::create();
        $data    = [
            'id'             => $oldUser->id,
            'name'           => $oldUser->name,
            'email'          => $faker->email,
            'after_validate' => true,
        ];

        $this->call('POST', 'validator/edit/1', $data);
        $this->assertRedirectedTo('/');
        $this->assertSessionHasErrors('after_validate');
    }
}
