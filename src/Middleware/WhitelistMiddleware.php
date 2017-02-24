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

            $allow = config('laravel-route-blocker.whitelist.' . $group);
            $ip    = $request->getClientIp();

            # SEARCH IN WHITELIST
            if(is_array($allow)) {
                foreach($allow as $addr) {
                    if(str_is($addr, $ip)) {
                        return $next($request);
                    }
                }
            }

            # REDIRECT OR THROW ERROR
            if(config('laravel-route-blocker.redirect_to') && filter_var(config('laravel-route-blocker.redirect_to'), FILTER_VALIDATE_URL)) {
                return redirect()->to(config('laravel-route-blocker.redirect_to'));
            } else {
                abort(config('laravel-route-blocker.response_status'), config('laravel-route-blocker.response_message'));
            }

        }

    }

?>
