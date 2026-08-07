<?php

namespace Tests\Unit;

use App\Ruin;
use App\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RuinTest extends TestCase
{
    use RefreshDatabase;

    public function test_ruins_may_have_links()
    {
        $ruin = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $ruin->id]);

        $this->assertInstanceOf(Link::class, $ruin->links->first());
    }
}
