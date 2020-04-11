<?php

namespace Skydiver\LaravelRouteBlocker\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Str;

class WhitelistMiddleware
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
        $redirect_to = config('laravel-route-blocker.redirect_to');
        if (!empty($redirect_to) && filter_var($redirect_to, FILTER_VALIDATE_URL)) {
            return redirect()->to($redirect_to);
        } else {
            $response_status = config('laravel-route-blocker.response_status');
            $response_message = config('laravel-route-blocker.response_message');
            abort($response_status, $response_message);
        }
    }
}
