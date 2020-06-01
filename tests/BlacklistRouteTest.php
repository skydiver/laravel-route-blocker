<?php

use Illuminate\Support\Facades\Route;
use Skydiver\LaravelRouteBlocker\Tests\TestPackageServiceProvider;

class BlacklistRouteTest extends Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/group1', function () {
            return 'Group #1 Page';
        })->middleware('blacklist:blocked_ips_1');

        Route::get('/group2', function () {
            return 'Group #2 Page';
        })->middleware('blacklist:blocked_ips_2');
    }

    protected function getPackageProviders($app)
    {
        return [
            TestPackageServiceProvider::class
        ];
    }

    public function test_allowed_route()
    {
        $response = $this->get('/group2');
        $response->assertSee('Group #2 Page');
        $response->assertStatus(200);
    }

    public function test_forbidden_route_returns_error_403()
    {
        $response = $this->get('/group1');
        $response->assertSee('Forbidden');
        $response->assertStatus(403);
    }

    public function test_forbidden_route_returns_error_404()
    {
        config(['laravel-route-blocker.response_status' => 404]);
        $response = $this->get('/group1');
        $response->assertSee('Not Found');
        $response->assertStatus(404);
    }

    public function test_forbidden_route_returns_custom_error_message()
    {
        config(['laravel-route-blocker.response_message' => 'Custom Error']);
        $response = $this->get('/group1');
        $response->assertSee('Custom Error');
        $response->assertStatus(403);
    }

    public function test_forbidden_route_redirect_to_login_page()
    {
        config(['laravel-route-blocker.redirect_to' => url()->current() . '/login']);
        $response = $this->get('/group1');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
