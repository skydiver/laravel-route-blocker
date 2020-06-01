<?php

namespace Skydiver\LaravelRouteBlocker\Tests;

use Illuminate\Support\ServiceProvider;

class TestPackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/_setup/routes/Test.php');
        $this->loadViewsFrom(__DIR__ . '/_setup/views', 'test');
    }
}
