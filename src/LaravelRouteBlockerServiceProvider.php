<?php

namespace Skydiver\LaravelRouteBlocker;

use Illuminate\Support\ServiceProvider;
use Skydiver\LaravelRouteBlocker\Console\GroupsList as GroupsList;

class LaravelRouteBlockerServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        $path = __DIR__.'/config/config.php';
        // PUBLISH CONFIG
        $this->publishes([$path => config_path('laravel-route-blocker.php')], 'LaravelRouteBlocker');

        // MERGE APP + PACKAGE CONFIG
        $this->mergeConfigFrom($path, 'laravel-route-blocker');

        // REGISTER ARTISAN COMMANDS
        if (version_compare($this->app->version(), '5.4', '>=')) {
            // Laravel 5.4 and superior
            $this->app->singleton('route_blocker.groups_list.command', function ($app) {
                return new GroupsList;
            });
        } else {
            // Laravel 5.1, 5.2, 5.3
            $this->app['route_blocker.groups_list.command'] = $this->app->share(function ($app) {
                return new GroupsList;
            });
        }

        $this->commands('route_blocker.groups_list.command');
    }
}
