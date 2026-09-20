<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CuratedLinksSpike2Test extends TestCase
{
    use RefreshDatabase;

    public function test_curated_links_are_inserted_idempotently(): void
    {
        $migration = require database_path('migrations/2026_09_22_000000_add_curated_links_spike_2.php');

        $aphrodisias = Ruin::factory()->create(['name' => 'Aphrodisias Test', 'slug' => 'aphrodisias']);
        $midas = Ruin::factory()->create(['name' => 'Midas Test', 'slug' => 'midas-monument']);
        $oinoanda = Ruin::factory()->create(['name' => 'Oenoanda Test', 'slug' => 'oinoanda']);

        // Pre-existing URL must not be duplicated.
        Link::factory()->create([
            'ruin_id' => $midas->id,
            'description' => 'Livius',
            'url' => 'https://www.livius.org/articles/place/yazilikaya-midas-city/',
            'language' => 'en',
        ]);

        $migration->up();

        $this->assertSame(4, Link::where('ruin_id', $aphrodisias->id)->count());
        $this->assertSame(3, Link::where('ruin_id', $midas->id)->count());
        $this->assertSame(3, Link::where('ruin_id', $oinoanda->id)->count());
        $this->assertDatabaseHas('links', [
            'ruin_id' => $oinoanda->id,
            'description' => 'Archaeology Magazine',
            'url' => 'https://archaeology.org/issues/july-august-2015/features/turkey-oinoanda-epicurean-inscription/',
            'language' => 'en',
        ]);

        $migration->up();

        $this->assertSame(4, Link::where('ruin_id', $aphrodisias->id)->count());
        $this->assertSame(3, Link::where('ruin_id', $midas->id)->count());
        $this->assertSame(3, Link::where('ruin_id', $oinoanda->id)->count());
    }

    public function test_rollback_removes_only_curated_links(): void
    {
        $migration = require database_path('migrations/2026_09_22_000000_add_curated_links_spike_2.php');

        $termessos = Ruin::factory()->create(['name' => 'Termessos Test', 'slug' => 'termessos']);
        $kept = Link::factory()->create(['ruin_id' => $termessos->id]);

        $migration->up();
        $migration->down();

        $this->assertDatabaseMissing('links', [
            'url' => 'https://www.whitman.edu/theatre/theatretour/turkeytravel/letter7/turkeyletter7.htm',
        ]);
        $this->assertDatabaseHas('links', ['id' => $kept->id]);
    }
}
