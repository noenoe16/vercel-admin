<?php

namespace Native\Mobile\Providers;

use Illuminate\Support\ServiceProvider;
use Native\Mobile\System;

class SystemServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(System::class, function () {
            return new System;
        });
    }
}