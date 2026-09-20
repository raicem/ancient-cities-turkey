<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CuratedLinksSpike5Test extends TestCase
{
    use RefreshDatabase;

    public function test_vet_and_fill_wave_applies(): void
    {
        $migration = require database_path('migrations/2026_09_25_000000_add_curated_links_spike_5.php');

        $gobeklitepe = Ruin::factory()->create(['name' => 'Gobeklitepe Test', 'slug' => 'gobeklitepe']);
        $gordium = Ruin::factory()->create(['name' => 'Gordion Test', 'slug' => 'gordium']);
        $letoon = Ruin::factory()->create(['name' => 'Letoon Test', 'slug' => 'letoon']);
        $dara = Ruin::factory()->create(['name' => 'Dara Test', 'slug' => 'dara']);

        Link::factory()->create([
            'ruin_id' => $gobeklitepe->id,
            'description' => 'gobeklitepe.info',
            'url' => 'http://gobeklitepe.info',
            'language' => 'en',
        ]);
        Link::factory()->create([
            'ruin_id' => $gordium->id,
            'description' => 'deretepe.net',
            'url' => 'https://deretepe.net.tr/gezi-hikayeleri/tarihe-bir-yolculuk-yassihoyuk-ve-gordion-gezisi/',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $letoon->id,
            'description' => 'lycianturkey.com',
            'url' => 'http://lycianturkey.com/lycian_sites/letoon.htm',
            'language' => 'en',
        ]);

        $migration->up();

        // Checker-confirmed dead and hijacked links are gone.
        $this->assertDatabaseMissing('links', ['url' => 'http://gobeklitepe.info']);
        $this->assertDatabaseMissing('links', ['url' => 'http://lycianturkey.com/lycian_sites/letoon.htm']);

        // Stale label fixed.
        $this->assertDatabaseHas('links', [
            'ruin_id' => $gordium->id,
            'description' => 'deretepe.net.tr',
        ]);

        // Fills inserted.
        $this->assertDatabaseHas('links', [
            'ruin_id' => $dara->id,
            'description' => 'War History Network',
            'language' => 'en',
        ]);
        $this->assertSame(4, Link::where('ruin_id', $gobeklitepe->id)->count());

        // Re-running is a no-op.
        $before = Link::count();
        $migration->up();

        $this->assertSame($before, Link::count());
    }

    public function test_rollback_removes_only_curated_links(): void
    {
        $migration = require database_path('migrations/2026_09_25_000000_add_curated_links_spike_5.php');

        $hasankeyf = Ruin::factory()->create(['name' => 'Hasankeyf Test', 'slug' => 'hasankeyf']);
        $kept = Link::factory()->create(['ruin_id' => $hasankeyf->id]);

        $migration->up();
        $migration->down();

        $this->assertDatabaseMissing('links', [
            'url' => 'https://www.dw.com/en/hasankeyf-the-town-that-drove-away/a-77031487',
        ]);
        $this->assertDatabaseHas('links', ['id' => $kept->id]);
    }
}
