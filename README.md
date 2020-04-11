# Laravel Route Blocker

Block routes by IP

*(inspired on [Laravel Firewall](https://github.com/antonioribeiro/firewall))*

---

## Requirements
Laravel 5.x, 6.x and 7.x

---

## Installation

1) Require the `skydiver/laravel-route-blocker` package in your `composer.json` and update your dependencies:

    ```bash
    $ composer require skydiver/laravel-route-blocker
    ```

2) Add service provider *(for Laravel 5.4 or below)*

    This package supports Laravel new [Package Discovery](https://laravel.com/docs/5.5/packages#package-discovery).

    If you are using Laravel < 5.5, you need to add `Skydiver\LaravelRouteBlocker\LaravelRouteBlockerServiceProvider::class` to your `config/app.php` providers array:

    ```php
    'providers' => [
        ...
        Skydiver\LaravelRouteBlocker\LaravelRouteBlockerServiceProvider::class,
    ]
    ```

3) Publish the config file:

    Run the following command to publish the package config file:

    ```bash
    $ php artisan vendor:publish --tag=LaravelRouteBlocker
    ```

---

## Usage

1) Register middleware in `app/Http/Kernel.php` on `$routeMiddleware` array:
    ```
        'whitelist' => \Skydiver\LaravelRouteBlocker\Middleware\WhitelistMiddleware::class,
    ```

2) Create a config group on `config/laravel-route-blocker.php` and insert your allowed IPs:
    ```
    'whitelist' => [
        'my_group' => [
            '127.0.0.1',
            '192.168.17.0',
            '10.0.1.*'
        ],
        'another_group' => [
            '8.8.8.*'
        ],
    ],
    ```

    Also, you can configure to throw an HTTP status code or redirect to a custom URL:
    ```
    'redirect_to'      => '',   // URL TO REDIRECT IF BLOCKED (LEAVE BLANK TO THROW STATUS)
    'response_status'  => 403,  // STATUS CODE (403, 404 ...)
    'response_message' => ''    // MESSAGE (COMBINED WITH STATUS CODE)
    ```

3) Put your protected routes inside a group and specify the whitelist parameter:
    ```
        Route::group(['middleware' => 'whitelist:my_group'], function() {

            Route::get('/demo', function () {
                return "DEMO";
            });

        });
    ```

---

## Artisan Commands
* To get a list of current IPs groups run:

    ```
        $ php artisan route:blocks:groups
    ```

    ```
        +---------+--------------+
        | Group   | IP           |
        +---------+--------------+
        | group1  | 127.0.0.1    |
        | group1  | 127.0.0.2    |
        | group1  | 192.168.17.0 |
        | group1  | 10.0.0.*     |
        | group2  | 8.8.8.8      |
        | group2  | 8.8.8.*      |
        | group2  | 8.8.4.4      |
        +---------+--------------+
    ```

---

## Notes

**You can create as many whitelists groups as you wish and protect differents set of routes with differents IPs**
