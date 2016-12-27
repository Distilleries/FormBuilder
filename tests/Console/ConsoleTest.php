<?php

class ConsoleTest extends FormTestCase
{

    public function testConsoleCreateForm()
    {
        $this->app['Illuminate\Contracts\Console\Kernel']->call('make:form', [
            'name' => 'TestForm',
            '--fields' => 'test1:hidden, test2:text',
        ]);

        $file = $this->app['path'].'/TestForm.php';
        require_once($file);

        $this->assertFileExists($file);
        File::delete($file);
    }

}
