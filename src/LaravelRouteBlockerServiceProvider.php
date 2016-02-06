<?php

    namespace Skydiver\LaravelRouteBlocker;

    use Illuminate\Support\ServiceProvider;

    class LaravelRouteBlockerServiceProvider extends ServiceProvider {

        public function register() {

        }

        public function boot() {

            # PUBLISH CONFIG
            $this->publishes([__DIR__.'/config/config.php' => config_path('laravel-route-blocker.php')], 'config');

            # MERGE APP + PACKAGE CONFIG
            $this->mergeConfigFrom( __DIR__.'/config/config.php', 'laravel-route-blocker');

        }

    }

?>