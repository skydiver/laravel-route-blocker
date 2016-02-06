laravel-route-blocker
====

Block routes by IP

*(inspired on [Laravel Firewall](https://github.com/antonioribeiro/firewall))*



## Installation

* Require this package in your composer.json and run composer update.
```
    "skydiver/laravel-route-blocker": "dev-master"
```

* After updating composer, add ServiceProvider to the providers array in config/app.php
```php
    Skydiver\LaravelRouteBlocker\LaravelRouteBlockerServiceProvider::class,
```

* Then publish the config file:
```
    $ php artisan vendor:publish --tag=LaravelRouteBlocker
```



## Usage

* Add middleware to `app/Http/Kernel.php` on `$routeMiddleware` array:
```
    'whitelist' => \Skydiver\LaravelRouteBlocker\Middleware\WhitelistMiddleware::class,
```

* Create a config group on `config/laravel-route-blocker.php` and insert your allowed IPs:
```
    'my_group' => [
        '127.0.0.1',
        '192.168.17.0',
    ],
```

* Put your protected routes inside a group and specify the whitelist parameter:
```
    Route::group(['middleware' => 'whitelist:my_group'], function() {

        Route::get('/demo', function () {
            return "DEMO";
        });

    });
```

**You can create as many whitelists groups as you wish and protect differents set of routes with differents IPs**
