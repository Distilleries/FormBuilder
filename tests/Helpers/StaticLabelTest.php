<?php

class StaticLabelTest extends FormTestCase {

    public function testYesNoArray()
    {
        $result = \Distilleries\FormBuilder\Helpers\StaticLabel::yesNo();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey(\Distilleries\FormBuilder\Helpers\StaticLabel::STATUS_OFFLINE, $result);
        $this->assertArrayHasKey(\Distilleries\FormBuilder\Helpers\StaticLabel::STATUS_ONLINE, $result);
    }

    public function testYes()
    {
        $result = \Distilleries\FormBuilder\Helpers\StaticLabel::yesNo(\Distilleries\FormBuilder\Helpers\StaticLabel::STATUS_ONLINE);

        $this->assertTrue(is_string($result));
        $this->assertEquals($this->app['translator']->trans('form-builder::form.yes'), $result);
    }

    public function testNa()
    {
        $result = \Distilleries\FormBuilder\Helpers\StaticLabel::yesNo(- 1);

        $this->assertTrue(is_string($result));
        $this->assertEquals($this->app['translator']->trans('form-builder::form.na'), $result);
    }
}