<?php

namespace Skydiver\LaravelRouteBlocker\Middleware;

class BaseMiddleware
{
    public function handleNoAccess()
    {
        // REDIRECT IF NEEDED
        $redirect_to = config('laravel-route-blocker.redirect_to');
        if (!empty($redirect_to) && filter_var($redirect_to, FILTER_VALIDATE_URL)) {
            return redirect()->to($redirect_to);
        }

        // THROW ERROR
        $response_status = config('laravel-route-blocker.response_status');
        $response_message = config('laravel-route-blocker.response_message');
        abort($response_status, $response_message);
    }
}
