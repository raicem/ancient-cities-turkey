<?php

namespace Tests\Feature;

use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RuinsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_display_information_about_a_ruin_in_turkish()
    {
        $this->withoutExceptionHandling();

        /** @var Ruin $ruin */
        $ruin = Ruin::factory()->create();

        $response = $this->get(route('ruins.show', ['locale' => 'tr', 'ruin' => $ruin->slug]));

        $this->assertStringContainsString($ruin->name_tr, $response->getContent());
        $this->assertStringContainsString($ruin->information_tr, $response->getContent());
    }

    public function test_it_can_display_information_about_a_ruin_in_english()
    {
        $this->withoutExceptionHandling();

        /** @var Ruin $ruin */
        $ruin = Ruin::factory()->create();

        $response = $this->get(route('ruins.show', ['locale' => 'en', 'ruin' => $ruin->slug]));

        $this->assertStringContainsString($ruin->name, $response->getContent());
        $this->assertStringContainsString($ruin->information, $response->getContent());
    }

    public function test_show_page_is_publicly_cacheable()
    {
        /** @var Ruin $ruin */
        $ruin = Ruin::factory()->create();

        $response = $this->get(route('ruins.show', ['locale' => 'en', 'ruin' => $ruin->slug]));

        $response->assertStatus(200);
        $cacheControl = $response->headers->get('Cache-Control');
        $this->assertStringContainsString('public', $cacheControl);
        $this->assertStringContainsString('s-maxage=3600', $cacheControl);
        $this->assertStringContainsString('stale-while-revalidate=86400', $cacheControl);
    }
}
