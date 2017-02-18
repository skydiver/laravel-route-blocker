#Laravel Route Blocker

Block routes by IP

*(inspired on [Laravel Firewall](https://github.com/antonioribeiro/firewall))*

---

## Requirements
Laravel 5.1. 5.2, 5.3, 5.4

---

## Installation

1. To `composer.json` add:  
`"zofe/rapyd": "2.2.*"` for Laravel 5.2  
`"zofe/rapyd": "2.1.*"` for Laravel 5.1  
`"zofe/rapyd": "2.0.*"` for Laravel 5.0  
`"zofe/rapyd": "1.3.*"` for Laravel 4.*  




1. Require this package in your composer.json and run composer update:
`"skydiver/laravel-route-blocker": "1.0.*"` for Laravel 5.1, 5.2, 5.3
`"skydiver/laravel-route-blocker": "1.1.*"` for Laravel 5.4


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

* Put your protected routes inside a group and specify the whitelist parameter:
```
    Route::group(['middleware' => 'whitelist:my_group'], function() {

        Route::get('/demo', function () {
            return "DEMO";
        });

    });
```



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



## Notes

**You can create as many whitelists groups as you wish and protect differents set of routes with differents IPs**
