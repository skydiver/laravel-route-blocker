<?php

namespace Tests\Feature;

class WhitelistMiddlewareTest extends BaseTestCase
{
    /** @test */
    public function matching_ip_should_return_status_200()
    {
        $this->setGroup('whitelist', 'allowed-group', '127.0.0.1');
        $this->createRoute('/allowed', 'whitelist', 'allowed-group');
        $response = $this->get('/allowed');
        $response->assertSee('ALLOWED');
        $response->assertStatus(200);
    }

    /** @test */
    public function matching_wildcard_ip_should_return_status_200()
    {
        $this->setGroup('whitelist', 'allowed-group', '127.0.0.*');
        $this->createRoute('/allowed', 'whitelist', 'allowed-group');
        $response = $this->get('/allowed');
        $response->assertSee('ALLOWED');
        $response->assertStatus(200);
    }

    /** @test */
    public function non_matching_ip_should_return_status_403()
    {
        $this->setGroup('whitelist', 'allowed-group', '8.8.8.8');
        $this->createRoute('/allowed', 'whitelist', 'allowed-group');
        $response = $this->get('/allowed');
        $response->assertSee('403');
        $response->assertStatus(403);
    }

    /** @test */
    public function non_matching_wildcard_ip_should_return_status_403()
    {
        $this->setGroup('whitelist', 'allowed-group', '8.8.*');
        $this->createRoute('/allowed', 'whitelist', 'allowed-group');
        $response = $this->get('/allowed');
        $response->assertSee('403');
        $response->assertStatus(403);
    }

    /** @test */
    public function non_matching_ip_and_custom_status_should_return_status_404()
    {
        config(['laravel-route-blocker.response_status' => 404]);
        $this->setGroup('whitelist', 'allowed-group', '8.8.8.8');
        $this->createRoute('/allowed', 'whitelist', 'allowed-group');
        $response = $this->get('/allowed');
        $response->assertStatus(404);
    }

    /** @test */
    public function non_matching_ip_and_custom_response_should_return_status_403()
    {
        config(['laravel-route-blocker.response_message' => 'FORBIDDEN ROUTE']);
        $this->setGroup('whitelist', 'allowed-group', '8.8.8.8');
        $this->createRoute('/allowed', 'whitelist', 'allowed-group');
        $response = $this->get('/allowed');
        $response->assertSee('FORBIDDEN ROUTE');
        $response->assertStatus(403);
    }

    /** @test */
    public function non_matching_ip_should_redirect_user_to_login_page()
    {
        config(['laravel-route-blocker.redirect_to' => 'http://localhost/login']);
        $this->setGroup('whitelist', 'allowed-group', '8.8.8.8');
        $this->createRoute('/allowed', 'whitelist', 'allowed-group');
        $response = $this->get('/allowed');
        $response->assertRedirect('/login');
    }
}
