<?php

namespace Tests\Unit;

use App\Ruin;
use App\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RuinTest extends TestCase
{
    use RefreshDatabase;

    public function test_ruins_may_have_links()
    {
        $ruin = factory(Ruin::class)->create();

        factory(Link::class)->create(['ruin_id' => $ruin->id]);

        $this->assertInstanceOf(Link::class, $ruin->links->first());
    }
}
