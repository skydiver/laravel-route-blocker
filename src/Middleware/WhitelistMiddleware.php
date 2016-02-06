<?php

    namespace Skydiver\LaravelRouteBlocker\Middleware;

    use Closure;
    use Illuminate\Contracts\Auth\Guard;

    class WhitelistMiddleware {

        protected $auth;

        public function __construct(Guard $auth) {
            $this->auth = $auth;
        }

        public function handle($request, Closure $next, $group) {

            $allow = config('laravel-route-blocker.' . $group);
            $ip    = $request->getClientIp();

            if(!isset($allow) OR !in_array($ip, $allow)) {
                abort(config('laravel-route-blocker.response_status'), config('laravel-route-blocker.response_message'));
            }

            return $next($request);

        }

    }

?>