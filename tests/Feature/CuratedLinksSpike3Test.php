<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CuratedLinksSpike3Test extends TestCase
{
    use RefreshDatabase;

    public function test_vet_and_fill_wave_applies(): void
    {
        $migration = require database_path('migrations/2026_09_23_000000_add_curated_links_spike_3.php');

        $ainos = Ruin::factory()->create(['name' => 'Ainos Test', 'slug' => 'ainos']);
        $aizanoi = Ruin::factory()->create(['name' => 'Aizanoi Test', 'slug' => 'aizanoi']);
        $alahan = Ruin::factory()->create(['name' => 'Alahan Test', 'slug' => 'alahan-monastery']);
        $midas = Ruin::factory()->create(['name' => 'Midas Test', 'slug' => 'midas-monument']);
        $perge = Ruin::factory()->create(['name' => 'Perge Test', 'slug' => 'perge']);

        Link::factory()->create([
            'ruin_id' => $ainos->id,
            'description' => 'arkeolojihaber.net',
            'url' => 'https://web.archive.org/web/20171008090238/http://arkeolojihaber.net/tag/ainos-antik-kenti/',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $ainos->id,
            'description' => 'Tripadvisor',
            'url' => 'https://www.tripadvisor.com.tr/Attraction_Review-g652369-d4328393-Reviews-Enez_Castle-Edirne_Edirne_Province.html',
            'language' => 'en',
        ]);
        Link::factory()->create([
            'ruin_id' => $aizanoi->id,
            'description' => 'aizanoi.com',
            'url' => 'http://www.aizanoi.com',
            'language' => 'en',
        ]);
        Link::factory()->create([
            'ruin_id' => $alahan->id,
            'description' => 'Vikipedia',
            'url' => 'https://tr.wikipedia.org/wiki/Alahan_Manastırı',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $midas->id,
            'description' => 'Wikipedia (Midas)',
            'url' => 'https://en.wikipedia.org/wiki/Midas',
            'language' => 'en',
        ]);

        // Orphans: one rescuable (perge vibe), one pure duplicate.
        Link::factory()->create([
            'ruin_id' => 999999,
            'description' => 'turkeysforlife.com',
            'url' => 'http://www.turkeysforlife.com/2016/07/perge-ruins-antalya.html',
            'language' => 'en',
        ]);
        $pergeWiki = Link::factory()->create([
            'ruin_id' => $perge->id,
            'description' => 'Wikipedia',
            'url' => 'https://en.wikipedia.org/wiki/Perga',
            'language' => 'en',
        ]);
        Link::factory()->create([
            'ruin_id' => 999998,
            'description' => 'Wikipedia',
            'url' => 'https://en.wikipedia.org/wiki/Perga',
            'language' => 'en',
        ]);

        $migration->up();

        // VET deletes applied.
        $this->assertDatabaseMissing('links', ['url' => 'https://web.archive.org/web/20171008090238/http://arkeolojihaber.net/tag/ainos-antik-kenti/']);
        $this->assertDatabaseMissing('links', ['ruin_id' => $aizanoi->id, 'url' => 'http://www.aizanoi.com']);
        $this->assertDatabaseMissing('links', ['ruin_id' => $midas->id, 'url' => 'https://en.wikipedia.org/wiki/Midas']);

        // VET relabel applied.
        $this->assertDatabaseHas('links', [
            'ruin_id' => $ainos->id,
            'description' => 'Enez Castle (ancient acropolis)',
        ]);
        $this->assertDatabaseHas('links', [
            'ruin_id' => $alahan->id,
            'description' => 'Vikipedi',
            'url' => 'https://tr.wikipedia.org/wiki/Alahan_Manastırı',
        ]);

        // Orphan rescued to live perge; duplicate orphan deleted.
        $this->assertDatabaseHas('links', [
            'ruin_id' => $perge->id,
            'url' => 'http://www.turkeysforlife.com/2016/07/perge-ruins-antalya.html',
        ]);
        $this->assertSame(1, Link::where('url', 'https://en.wikipedia.org/wiki/Perga')->count());
        $this->assertDatabaseHas('links', ['id' => $pergeWiki->id]);
        $this->assertSame(0, Link::whereNotIn('ruin_id', Ruin::pluck('id'))->count());

        // Fills inserted.
        $this->assertDatabaseHas('links', [
            'ruin_id' => $ainos->id,
            'description' => 'GoTürkiye',
            'language' => 'en',
        ]);
        $this->assertDatabaseHas('links', [
            'ruin_id' => $aizanoi->id,
            'description' => 'Aizanoi Kazısı',
            'language' => 'tr',
        ]);

        // Re-running is a no-op.
        $before = Link::count();
        $migration->up();

        $this->assertSame($before, Link::count());
    }

    public function test_rollback_removes_only_curated_links(): void
    {
        $migration = require database_path('migrations/2026_09_23_000000_add_curated_links_spike_3.php');

        $adada = Ruin::factory()->create(['name' => 'Adada Test', 'slug' => 'adada']);
        $kept = Link::factory()->create(['ruin_id' => $adada->id]);

        $migration->up();
        $migration->down();

        $this->assertDatabaseMissing('links', [
            'url' => 'https://www.hurriyetdailynews.com/ancient-city-reveals-traces-of-17-centuries-of-uninterrupted-life-221078',
        ]);
        $this->assertDatabaseHas('links', ['id' => $kept->id]);
    }
}
