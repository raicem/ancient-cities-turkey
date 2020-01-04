<?php

namespace Tests\Unit;

use App\Ruin;
use App\Link;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RuinTest extends TestCase
{
    use DatabaseMigrations;

    public function testRuinsMayHaveLinks()
    {
        $ruin = factory(Ruin::class)->create();

        factory(Link::class)->create(['ruin_id' => $ruin->id]);

        $this->assertInstanceOf(Link::class, $ruin->links->first());
    }
}
