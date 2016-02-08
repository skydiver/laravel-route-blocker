<?php

    namespace Skydiver\LaravelRouteBlocker;

    use Illuminate\Support\ServiceProvider;
    use Skydiver\LaravelRouteBlocker\Console\GroupsList as GroupsList;

    class LaravelRouteBlockerServiceProvider extends ServiceProvider {

        public function register() {

        }

        public function boot() {

            # PUBLISH CONFIG
            $this->publishes([__DIR__.'/config/config.php' => config_path('laravel-route-blocker.php')], 'config');

            # MERGE APP + PACKAGE CONFIG
            $this->mergeConfigFrom( __DIR__.'/config/config.php', 'laravel-route-blocker');

            # REGISTER ARTISAN COMMANDS
            $this->app['route_blocker.groups_list.command'] = $this->app->share(function($app) {
                return new GroupsList;
            });
            $this->commands('route_blocker.groups_list.command');

        }

    }

?>