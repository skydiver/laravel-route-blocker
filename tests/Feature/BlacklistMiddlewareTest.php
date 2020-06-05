<?php

namespace Tests\Feature;

class BlacklistMiddlewareTest extends BaseTestCase
{
    /** @test */
    public function matching_ip_should_block_user_with_status_403()
    {
        $this->setGroup('blacklist', 'blocked-group', '127.0.0.1');
        $this->createRoute('/blocked', 'blacklist', 'blocked-group');
        $response = $this->get('/blocked');
        $response->assertSee('403');
        $response->assertStatus(403);
    }

    /** @test */
    public function matching_wildcard_ip_should_block_user_with_error_403()
    {
        $this->setGroup('blacklist', 'blocked-group', '127.0.0.*');
        $this->createRoute('/blocked', 'blacklist', 'blocked-group');
        $response = $this->get('/blocked');
        $response->assertSee('403');
        $response->assertStatus(403);
    }

    /** @test */
    public function non_matching_ip_should_return_status_200()
    {
        $this->setGroup('blacklist', 'blocked-group', '8.8.8.8');
        $this->createRoute('/allowed', 'blacklist', 'blocked-group');
        $response = $this->get('/allowed');
        $response->assertSee('ALLOWED');
        $response->assertStatus(200);
    }

    /** @test */
    public function non_matching_wildcard_ip_should_return_status_200()
    {
        $this->setGroup('blacklist', 'blocked-group', '8.8.*');
        $this->createRoute('/allowed', 'blacklist', 'blocked-group');
        $response = $this->get('/allowed');
        $response->assertSee('ALLOWED');
        $response->assertStatus(200);
    }

    /** @test */
    public function matching_ip_and_custom_status_should_return_status_404()
    {
        config(['laravel-route-blocker.response_status' => 404]);
        $this->setGroup('blacklist', 'blocked-group', '127.0.0.1');
        $this->createRoute('/blocked', 'blacklist', 'blocked-group');
        $response = $this->get('/blocked');
        $response->assertStatus(404);
    }

    /** @test */
    public function matching_ip_and_custom_response_should_return_status_403()
    {
        config(['laravel-route-blocker.response_message' => 'BLOCKED ROUTE']);
        $this->setGroup('blacklist', 'blocked-group', '127.0.0.1');
        $this->createRoute('/blocked', 'blacklist', 'blocked-group');
        $response = $this->get('/blocked');
        $response->assertSee('BLOCKED ROUTE');
        $response->assertStatus(403);
    }

    /** @test */
    public function matching_ip_should_redirect_user_to_login_page()
    {
        config(['laravel-route-blocker.redirect_to' => 'http://localhost/login']);
        $this->setGroup('blacklist', 'blocked-group', '127.0.0.1');
        $this->createRoute('/blocked', 'blacklist', 'blocked-group');
        $response = $this->get('/blocked');
        $response->assertRedirect('/login');
    }
}
