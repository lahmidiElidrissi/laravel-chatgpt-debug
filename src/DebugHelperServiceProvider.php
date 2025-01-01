<?php

namespace lahmidielidrissi\DebugHelper;

use Illuminate\Support\ServiceProvider;

class DebugHelperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'debughelper');
    }

    public function register()
    {
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \lahmidielidrissi\DebugHelper\DebugHelperHandler::class
        );
    }
}
