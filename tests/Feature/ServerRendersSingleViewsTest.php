<?php

namespace Tests\Feature;

use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ServerRendersSingleViewsTest extends TestCase
{
    use RefreshDatabase;

    public function testServerSideRendersSingleViews()
    {
        $ruin = factory(Ruin::class)->create();
        $this->get("/{$ruin->slug}")
            ->assertStatus(200)
            ->assertSee($ruin->name);
    }
}
