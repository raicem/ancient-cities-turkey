<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CuratedLinksSpike6Test extends TestCase
{
    use RefreshDatabase;

    public function test_vet_and_fill_wave_applies(): void
    {
        $migration = require database_path('migrations/2026_09_26_000000_add_curated_links_spike_6.php');

        $herakleia = Ruin::factory()->create(['name' => 'Herakleia Test', 'slug' => 'herakleia']);
        $hyllarima = Ruin::factory()->create(['name' => 'Hyllarima Test', 'slug' => 'hyllarima']);
        $kaunos = Ruin::factory()->create(['name' => 'Kaunos Test', 'slug' => 'kaunos']);
        $hattusa = Ruin::factory()->create(['name' => 'Hattusa Test', 'slug' => 'hattusa']);

        Link::factory()->create([
            'ruin_id' => $herakleia->id,
            'description' => 'arkeolojigezginlerlogspot.com',
            'url' => 'http://arkeolojigezginleri.blogspot.com/2014/08/herakleia-latmos-herakleiasi.html',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $herakleia->id,
            'description' => 'duygucinar.com',
            'url' => 'https://web.archive.org/web/20170213171423/https://duygucinar.com/2017/02/12/herakleia-antik-kent-bafa-golu/',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $hyllarima->id,
            'description' => 'kariayolu.wordpress.com',
            'url' => 'https://kariayolu.wordpress.com/karya-kentleri/g-h-i/hyllarima/',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $kaunos->id,
            'description' => 'rotasenin.com',
            'url' => 'https://www.rotasenin.com/kaunos-antik-kenti',
            'language' => 'tr',
        ]);

        $migration->up();

        // VET deletes applied.
        $this->assertDatabaseMissing('links', ['url' => 'https://web.archive.org/web/20170213171423/https://duygucinar.com/2017/02/12/herakleia-antik-kent-bafa-golu/']);
        $this->assertDatabaseMissing('links', ['url' => 'https://kariayolu.wordpress.com/karya-kentleri/g-h-i/hyllarima/']);

        // VET relabel applied.
        $this->assertDatabaseHas('links', [
            'ruin_id' => $herakleia->id,
            'description' => 'arkeolojigezginleri.blogspot.com',
        ]);

        // URL refresh applied.
        $this->assertDatabaseMissing('links', ['url' => 'https://www.rotasenin.com/kaunos-antik-kenti']);
        $this->assertDatabaseHas('links', [
            'ruin_id' => $kaunos->id,
            'description' => 'rotasenin.com',
            'url' => 'https://www.rotasenin.com/kaunos-antik-kenti-dalyan-kral-mezarlari',
        ]);

        // Fills inserted.
        $this->assertDatabaseHas('links', [
            'ruin_id' => $hattusa->id,
            'description' => 'UNESCO',
            'url' => 'https://whc.unesco.org/en/list/377',
            'language' => 'en',
        ]);

        // Re-running is a no-op.
        $before = Link::count();
        $migration->up();

        $this->assertSame($before, Link::count());
    }

    public function test_rollback_removes_only_curated_links(): void
    {
        $migration = require database_path('migrations/2026_09_26_000000_add_curated_links_spike_6.php');

        $kedrai = Ruin::factory()->create(['name' => 'Kedrai Test', 'slug' => 'kedrai']);
        $kept = Link::factory()->create(['ruin_id' => $kedrai->id]);

        $migration->up();
        $migration->down();

        $this->assertDatabaseMissing('links', [
            'url' => 'https://ancientroutesturkiye.com/en/kedrai',
        ]);
        $this->assertDatabaseHas('links', ['id' => $kept->id]);
    }
}
