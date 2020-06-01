<?php

use Skydiver\LaravelRouteBlocker\Tests\TestPackageServiceProvider;

class RouteTest extends Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            TestPackageServiceProvider::class
        ];
    }

    /** @test */
    public function visit_test_route()
    {
        $response = $this->get('test');
        $response->assertSee('Private Page!');
        $response->assertStatus(200);
    }
}
