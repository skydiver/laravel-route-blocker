<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Skydiver\LaravelRouteBlocker\Middleware\BlacklistMiddleware;
use Skydiver\LaravelRouteBlocker\Middleware\WhitelistMiddleware;

class BaseTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('whitelist', WhitelistMiddleware::class);
        $router->aliasMiddleware('blacklist', BlacklistMiddleware::class);

        config(['laravel-route-blocker.whitelist' => []]);
        config(['laravel-route-blocker.blacklist' => []]);
    }

    public function setGroup(string $type, string $name, string $ip) :void
    {
        config(["laravel-route-blocker.$type" => [
            $name => [$ip]
        ]]);
    }

    public function createRoute(string $route, string $middleware, string $group) :void
    {
        Route::get($route, function () use ($route) {
            return strtoupper($route);
        })->middleware("$middleware:$group");
    }
}
