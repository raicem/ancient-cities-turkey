<?php

namespace Tests\Feature;

use App\Link;
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
        $ruin = factory(Ruin::class)->create();

        $response = $this->get(route('ruins.show', ['locale' => 'tr', 'ruin' => $ruin->slug]));

        $this->assertStringContainsString($ruin->name_tr, $response->getContent());
        $this->assertStringContainsString($ruin->information_tr, $response->getContent());
    }

    public function test_it_can_display_information_about_a_ruin_in_english()
    {
        $this->withoutExceptionHandling();

        /** @var Ruin $ruin */
        $ruin = factory(Ruin::class)->create();

        $response = $this->get(route('ruins.show', ['locale' => 'en', 'ruin' => $ruin->slug]));

        $this->assertStringContainsString($ruin->name, $response->getContent());
        $this->assertStringContainsString($ruin->information, $response->getContent());
    }
}
