# Laravel Route Blocker

Block routes by IP

*(inspired on [Laravel Firewall](https://github.com/antonioribeiro/firewall))*

---

## Requirements
Laravel 5.x, 6.x, 7.x and 8.x

---

## Installation

1) To install through composer, run the following command from terminal:

    ```bash
    $ composer require skydiver/laravel-route-blocker
    ```

3) Publish the config file:

    Run the following command to publish the package config file:

    ```bash
    $ php artisan vendor:publish --tag=LaravelRouteBlocker
    ```

<details>
<summary>Still using Laravel 5.4 or below?</summary>

Please add service provider to your `config/app.php` providers array:
```php
'providers' => [
    ...
    Skydiver\LaravelRouteBlocker\LaravelRouteBlockerServiceProvider::class,
]
```
</details>

---

## Usage

1) Register middlewares in `app/Http/Kernel.php` on `$routeMiddleware` array:
    ```
        'blacklist' => \Skydiver\LaravelRouteBlocker\Middleware\BlacklistMiddleware::class,
        'whitelist' => \Skydiver\LaravelRouteBlocker\Middleware\WhitelistMiddleware::class,
    ```
* Blacklist allows all traffic except matching rules.
* Whitelist blocks all traffic except matching rules.
* You can register both or just a single middleware.

2) Create a config group on `config/laravel-route-blocker.php` and insert your allowed/blocked IPs:
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
        'blacklist' => [
            'blocked_ips' => [
                '127.0.0.1',
                '192.168.100.0',
            ],
            'blocked_ips2' => [
                '8.8.8.8',
            ],
        ],
    ```

    * You can create as many blacklist/whitelists groups as you wish and protect differents set of routes with differents IPs

    Also, you can configure to throw an HTTP status code or redirect to a custom URL:
    ```
    'redirect_to'      => '',   // URL TO REDIRECT IF BLOCKED (LEAVE BLANK TO THROW STATUS)
    'response_status'  => 403,  // STATUS CODE (403, 404 ...)
    'response_message' => ''    // MESSAGE (COMBINED WITH STATUS CODE)
    ```

3) Put your protected routes inside a group and specify the whitelist parameter:
    ```
        // Only IPs matched on "my_group" will be allowed to access route
        Route::group(['middleware' => 'whitelist:my_group'], function() {

            Route::get('/demo', function () {
                return "DEMO";
            });

        });

        // Only IPs matched on "my_group" will be blocked to access route
        Route::group(['middleware' => 'blacklist:blocked_ips'], function() {

            Route::get('/private', function () {
                return "Private Page";
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
        +-----------------+--------------+-----------+
        | Group           | IP           | Type      |
        +-----------------+--------------+-----------+
        | allowed_group_1 | 127.0.0.1    | whitelist |
        | allowed_group_1 | 127.0.0.2    | whitelist |
        | allowed_group_1 | 192.168.17.0 | whitelist |
        | allowed_group_1 | 10.0.0.*     | whitelist |
        | allowed_group_2 | 8.8.8.8      | whitelist |
        | allowed_group_2 | 8.8.8.*      | whitelist |
        | allowed_group_2 | 8.8.4.4      | whitelist |
        | blocked_ips_1   | 127.0.0.1    | blacklist |
        | blocked_ips_1   | 127.0.0.2    | blacklist |
        | blocked_ips_1   | 192.168.17.0 | blacklist |
        | blocked_ips_1   | 10.0.0.*     | blacklist |
        | blocked_ips_2   | 8.8.8.8      | blacklist |
        | blocked_ips_2   | 8.8.8.*      | blacklist |
        | blocked_ips_2   | 8.8.4.4      | blacklist |
        +-----------------+--------------+-----------+
    ```

---

## Testing
To manually run test suite:
```
vendor/bin/phpunit --verbose
```

Test files inside `tests/Feature` should be run by GitHub action only.