<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CuratedLinksSpike7Test extends TestCase
{
    use RefreshDatabase;

    public function test_vet_and_fill_wave_applies(): void
    {
        $migration = require database_path('migrations/2026_09_27_000000_add_curated_links_spike_7.php');

        $mamure = Ruin::factory()->create(['name' => 'Mamure Test', 'slug' => 'mamure-castle']);
        $mausoleum = Ruin::factory()->create(['name' => 'Mausoleum Test', 'slug' => 'mausoleum-at-halicarnassus']);
        $kibyra = Ruin::factory()->create(['name' => 'Kibyra Test', 'slug' => 'kibyra']);

        Link::factory()->create([
            'ruin_id' => $mamure->id,
            'description' => 'Wikipedia',
            'url' => 'https://en.wikipedia.org/wiki/Aya_Tekla_Church',
            'language' => 'en',
        ]);
        Link::factory()->create([
            'ruin_id' => $mausoleum->id,
            'description' => 'Wikipedia (Halicarnassus)',
            'url' => 'https://en.wikipedia.org/wiki/Halicarnassus',
            'language' => 'en',
        ]);

        $migration->up();

        // Wrong-site and duplicate-city links are gone.
        $this->assertDatabaseMissing('links', ['ruin_id' => $mamure->id, 'url' => 'https://en.wikipedia.org/wiki/Aya_Tekla_Church']);
        $this->assertDatabaseMissing('links', ['ruin_id' => $mausoleum->id, 'url' => 'https://en.wikipedia.org/wiki/Halicarnassus']);

        // Fills inserted.
        $this->assertDatabaseHas('links', [
            'ruin_id' => $mamure->id,
            'description' => 'Ancient Route',
            'language' => 'en',
        ]);
        $this->assertSame(4, Link::where('ruin_id', $mamure->id)->count());
        $this->assertSame(6, Link::where('ruin_id', $kibyra->id)->count());

        // Re-running is a no-op.
        $before = Link::count();
        $migration->up();

        $this->assertSame($before, Link::count());
    }

    public function test_rollback_removes_only_curated_links(): void
    {
        $migration = require database_path('migrations/2026_09_27_000000_add_curated_links_spike_7.php');

        $melid = Ruin::factory()->create(['name' => 'Melid Test', 'slug' => 'melid']);
        $kept = Link::factory()->create(['ruin_id' => $melid->id]);

        $migration->up();
        $migration->down();

        $this->assertDatabaseMissing('links', [
            'url' => 'https://atlasanatolia.com/site/arslantepe',
        ]);
        $this->assertDatabaseHas('links', ['id' => $kept->id]);
    }
}
