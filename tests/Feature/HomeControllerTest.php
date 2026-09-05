<?php

namespace Tests\Feature;

use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_renders_the_homepage()
    {
        $this->get(route('ruins.index', ['locale' => 'en']))->assertStatus(200);
    }

    public function test_homepage_sets_no_cookies_for_anonymous_visitors()
    {
        $response = $this->get(route('ruins.index', ['locale' => 'en']));

        $response->assertStatus(200);
        $this->assertCount(0, $response->headers->getCookies());
    }

    public function test_homepage_inlines_the_ruins_list_for_the_spa()
    {
        /** @var Ruin $ruin */
        $ruin = Ruin::factory()->create();

        $response = $this->get(route('ruins.index', ['locale' => 'en']));

        $response->assertStatus(200);
        $this->assertStringContainsString('window.__INITIAL_RUINS__', $response->getContent());
        $this->assertStringContainsString($ruin->slug, $response->getContent());
    }

    public function test_homepage_is_publicly_cacheable()
    {
        $response = $this->get(route('ruins.index', ['locale' => 'en']));

        $response->assertStatus(200);
        $cacheControl = $response->headers->get('Cache-Control');
        $this->assertStringContainsString('public', $cacheControl);
        $this->assertStringContainsString('s-maxage=3600', $cacheControl);
        $this->assertStringContainsString('stale-while-revalidate=86400', $cacheControl);
    }
}
