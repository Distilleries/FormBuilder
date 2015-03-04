<?php

use Orchestra\Testbench\Http\Kernel as BaseKernel;
class KernelTestCase extends BaseKernel
{

    protected $bootstrappers = [];

    protected $middleware = [
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
    ];
}
