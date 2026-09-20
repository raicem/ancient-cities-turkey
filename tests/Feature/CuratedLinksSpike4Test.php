<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CuratedLinksSpike4Test extends TestCase
{
    use RefreshDatabase;

    public function test_vet_and_fill_wave_applies(): void
    {
        $migration = require database_path('migrations/2026_09_24_000000_add_curated_links_spike_4.php');

        $bathonea = Ruin::factory()->create(['name' => 'Bathonea Test', 'slug' => 'bathonea']);
        $bayrakli = Ruin::factory()->create(['name' => 'Bayrakli Test', 'slug' => 'bayrakli-mound']);
        $asklepion = Ruin::factory()->create(['name' => 'Asklepion Test', 'slug' => 'asklepion']);
        $bubon = Ruin::factory()->create(['name' => 'Bubon Test', 'slug' => 'bubon']);

        Link::factory()->create([
            'ruin_id' => $bathonea->id,
            'description' => 'Bathonea.org',
            'url' => 'http://bathonea.org',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $bathonea->id,
            'description' => 'Arkeolojihaber',
            'url' => 'https://web.archive.org/web/20180708162238/http://arkeolojihaber.net/tag/bathonea-antik-kenti/',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $bayrakli->id,
            'description' => 'thoughtco.com',
            'url' => 'https://www.thoughtco.com/old-smyrna-turkey-greek-site-172034',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $asklepion->id,
            'description' => 'Vikipedi - Asklepios',
            'url' => 'https://tr.wikipedia.org/wiki/Asklepios',
            'language' => 'tr',
        ]);
        $keptWiki = Link::factory()->create([
            'ruin_id' => $asklepion->id,
            'description' => 'Wikipedia',
            'url' => 'https://en.wikipedia.org/wiki/Asclepeion',
            'language' => 'en',
        ]);

        $migration->up();

        // VET deletes applied, baseline wiki kept.
        $this->assertDatabaseMissing('links', ['ruin_id' => $bathonea->id, 'url' => 'http://bathonea.org']);
        $this->assertDatabaseMissing('links', ['url' => 'https://web.archive.org/web/20180708162238/http://arkeolojihaber.net/tag/bathonea-antik-kenti/']);
        $this->assertDatabaseMissing('links', ['ruin_id' => $asklepion->id, 'url' => 'https://tr.wikipedia.org/wiki/Asklepios']);
        $this->assertDatabaseHas('links', ['id' => $keptWiki->id]);

        // VET relabel fixes description and language.
        $this->assertDatabaseHas('links', [
            'ruin_id' => $bayrakli->id,
            'description' => 'thoughtco.com',
            'url' => 'https://www.thoughtco.com/old-smyrna-turkey-greek-site-172034',
            'language' => 'en',
        ]);

        // Fills inserted.
        $this->assertDatabaseHas('links', [
            'ruin_id' => $bubon->id,
            'description' => 'New York Times',
            'language' => 'en',
        ]);
        $this->assertSame(5, Link::where('ruin_id', $bubon->id)->count());
        $this->assertSame(4, Link::where('ruin_id', $bathonea->id)->count());

        // Re-running is a no-op.
        $before = Link::count();
        $migration->up();

        $this->assertSame($before, Link::count());
    }

    public function test_rollback_removes_only_curated_links(): void
    {
        $migration = require database_path('migrations/2026_09_24_000000_add_curated_links_spike_4.php');

        $blaundos = Ruin::factory()->create(['name' => 'Blaundos Test', 'slug' => 'blaundos']);
        $kept = Link::factory()->create(['ruin_id' => $blaundos->id]);

        $migration->up();
        $migration->down();

        $this->assertDatabaseMissing('links', [
            'url' => 'https://www.dailysabah.com/life/travel/the-ancient-city-of-blaundus-anatolias-stonehenge',
        ]);
        $this->assertDatabaseHas('links', ['id' => $kept->id]);
    }
}
