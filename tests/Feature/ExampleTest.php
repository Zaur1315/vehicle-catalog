<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_active_public_pages_are_available(): void
    {
        foreach (['/inventory', '/finance', '/trade-in', '/about', '/contact', '/privacy-policy', '/terms', '/sitemap.xml', '/robots.txt'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_retired_pages_permanently_redirect_to_contact(): void
    {
        foreach (['/service', '/delivery', '/warranty-return'] as $uri) {
            $this->get($uri)
                ->assertStatus(301)
                ->assertRedirect('/contact');
        }
    }
}
