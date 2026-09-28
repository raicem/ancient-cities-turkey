<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CuratedLinksSpike8Test extends TestCase
{
    use RefreshDatabase;

    public function test_vet_and_fill_wave_applies(): void
    {
        $migration = require database_path('migrations/2026_09_28_000000_add_curated_links_spike_8.php');

        $metropolis = Ruin::factory()->create(['name' => 'Metropolis Test', 'slug' => 'metropolis']);
        $nysa = Ruin::factory()->create(['name' => 'Nysa Test', 'slug' => 'nysa']);
        $parion = Ruin::factory()->create(['name' => 'Parion Test', 'slug' => 'parion']);
        $pedasa = Ruin::factory()->create(['name' => 'Pedasa Test', 'slug' => 'pedasa']);
        $myra = Ruin::factory()->create(['name' => 'Myra Test', 'slug' => 'myra']);

        Link::factory()->create([
            'ruin_id' => $nysa->id,
            'description' => 'Vikipedi',
            'url' => 'https://tr.wikipedia.org/wiki/Nysa',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $metropolis->id,
            'description' => 'arkeolojihaber.net',
            'url' => 'https://web.archive.org/web/20190222170951/http://www.izmirmuzesi.gov.tr/antik-yerlesim-alanlari-metropolis.aspx',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $parion->id,
            'description' => 'Troia Vakfı',
            'url' => 'https://troiavakfi.com/harita/parion-biga/',
            'language' => 'en',
        ]);
        Link::factory()->create([
            'ruin_id' => $pedasa->id,
            'description' => 'livelovethank.com',
            'url' => 'http://livelovethank.com/pedasa-antik-kentinde-oksijen-carpmasi/',
            'language' => 'tr',
        ]);

        $migration->up();

        // VET deletes applied (disambiguation page, frozen snapshot).
        $this->assertDatabaseMissing('links', ['ruin_id' => $nysa->id, 'url' => 'https://tr.wikipedia.org/wiki/Nysa']);
        $this->assertDatabaseMissing('links', ['url' => 'https://web.archive.org/web/20190222170951/http://www.izmirmuzesi.gov.tr/antik-yerlesim-alanlari-metropolis.aspx']);

        // URL refresh fixes scheme and language.
        $this->assertDatabaseMissing('links', ['url' => 'https://troiavakfi.com/harita/parion-biga/']);
        $this->assertDatabaseHas('links', [
            'ruin_id' => $parion->id,
            'url' => 'http://troiavakfi.com/harita/parion-biga/',
            'language' => 'tr',
        ]);
        $this->assertDatabaseHas('links', [
            'ruin_id' => $pedasa->id,
            'url' => 'https://livelovethank.com/tr/pedasa-antik-kentinde-oksijen-carpmasi/',
        ]);

        // Fills inserted.
        $this->assertDatabaseHas('links', [
            'ruin_id' => $myra->id,
            'description' => 'National Geographic',
            'language' => 'en',
        ]);
        $this->assertSame(4, Link::where('ruin_id', $myra->id)->count());

        // Re-running is a no-op.
        $before = Link::count();
        $migration->up();

        $this->assertSame($before, Link::count());
    }

    public function test_rollback_removes_only_curated_links(): void
    {
        $migration = require database_path('migrations/2026_09_28_000000_add_curated_links_spike_8.php');

        $patara = Ruin::factory()->create(['name' => 'Patara Test', 'slug' => 'patara']);
        $kept = Link::factory()->create(['ruin_id' => $patara->id]);

        $migration->up();
        $migration->down();

        $this->assertDatabaseMissing('links', [
            'url' => 'https://www.jpost.com/archaeology/archaeology-around-the-world/article-844316',
        ]);
        $this->assertDatabaseHas('links', ['id' => $kept->id]);
    }
}
