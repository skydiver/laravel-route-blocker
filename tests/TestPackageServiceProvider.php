<?php

namespace Skydiver\LaravelRouteBlocker\Tests;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Skydiver\LaravelRouteBlocker\Middleware\WhitelistMiddleware;

class TestPackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $path = __DIR__.'/../src/config/config.php';
        $this->mergeConfigFrom($path, 'laravel-route-blocker');

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('whitelist', WhitelistMiddleware::class);
    }
}
