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

    public function test_tripadvisor_links_are_listed_after_editorial_links()
    {
        $ruin = Ruin::factory()->create();

        Link::factory()->create([
            'ruin_id' => $ruin->id,
            'language' => 'en',
            'description' => 'Wikipedia',
            'url' => 'https://example.com/wiki',
        ]);
        Link::factory()->create([
            'ruin_id' => $ruin->id,
            'language' => 'en',
            'description' => 'Tripadvisor',
            'url' => 'https://example.com/tripadvisor',
        ]);
        Link::factory()->create([
            'ruin_id' => $ruin->id,
            'language' => 'en',
            'description' => 'Aphrodite of Knidos',
            'url' => 'https://example.com/aphrodite',
        ]);
        Link::factory()->create([
            'ruin_id' => $ruin->id,
            'language' => 'tr',
            'description' => 'Tripadvisor',
            'url' => 'https://example.com/tripadvisor-tr',
        ]);

        $this->assertSame(
            ['Aphrodite of Knidos', 'Wikipedia', 'Tripadvisor'],
            $ruin->englishLinks()->get()->pluck('description')->all()
        );
        $this->assertSame(
            ['Tripadvisor'],
            $ruin->turkishLinks()->get()->pluck('description')->all()
        );
    }
}
