<?php

namespace Skydiver\LaravelRouteBlocker\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Str;

class WhitelistMiddleware extends BaseMiddleware
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $group)
    {

        $allow = config('laravel-route-blocker.whitelist.' . $group);
        $ip    = $request->getClientIp();

        // SEARCH IN WHITELIST
        if (is_array($allow)) {
            foreach ($allow as $addr) {
                if (Str::is($addr, $ip)) {
                    return $next($request);
                }
            }
        }

        // REDIRECT OR THROW ERROR
        return $this->handleNoAccess();
    }
}
