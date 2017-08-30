<?php

    namespace Skydiver\LaravelRouteBlocker;

    use Illuminate\Support\ServiceProvider;
    use Skydiver\LaravelRouteBlocker\Console\GroupsList as GroupsList;

    class LaravelRouteBlockerServiceProvider extends ServiceProvider {

        public function register() {

        }

        public function boot() {

            # PUBLISH CONFIG
            $this->publishes([__DIR__.'/config/config.php' => config_path('laravel-route-blocker.php')], 'LaravelRouteBlocker');

            # MERGE APP + PACKAGE CONFIG
            $this->mergeConfigFrom( __DIR__.'/config/config.php', 'laravel-route-blocker');

            # REGISTER ARTISAN COMMANDS
            if(str_contains($this->app->version(), '5.4') || str_contains($this->app->version(), '5.5')) {

                # Laravel 5.4 / 5.5
                $this->app->singleton('route_blocker.groups_list.command', function($app){
                    return new GroupsList;
                });

            } else {

                # Laravel 5.1, 5.2, 5.3
                $this->app['route_blocker.groups_list.command'] = $this->app->share(function($app) {
                    return new GroupsList;
                });

            }

            $this->commands('route_blocker.groups_list.command');

        }

    }

?>
