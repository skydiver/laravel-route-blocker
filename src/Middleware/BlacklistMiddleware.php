<?php

namespace Skydiver\LaravelRouteBlocker\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Str;

class BlacklistMiddleware extends BaseMiddleware
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $group)
    {

        $block = config('laravel-route-blocker.blacklist.' . $group);
        $ip    = $request->getClientIp();

        // SEARCH IN BLACKLIST
        if (is_array($block)) {
            foreach ($block as $addr) {
                if (Str::is($addr, $ip)) {
                    // REDIRECT OR THROW ERROR
                    return $this->handleNoAccess();
                }
            }
        }

        // REQUEST IS AUTHORIZED
        return $next($request);
    }
}
