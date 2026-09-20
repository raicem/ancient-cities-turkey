<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CuratedLinksSpike1Test extends TestCase
{
    use RefreshDatabase;

    public function test_curated_links_are_inserted_and_fixes_applied(): void
    {
        $migration = require database_path('migrations/2026_09_21_000000_add_curated_links_spike_1.php');

        $ephesus = Ruin::factory()->create(['name' => 'Ephesus Test', 'slug' => 'ephesus']);
        $knidos = Ruin::factory()->create(['name' => 'Knidos Test', 'slug' => 'knidos']);
        $aspendos = Ruin::factory()->create(['name' => 'Aspendos Test', 'slug' => 'aspendos']);
        $lysias = Ruin::factory()->create(['name' => 'Lysias Test', 'slug' => 'lysias']);

        Link::factory()->create([
            'ruin_id' => $knidos->id,
            'description' => 'Tripadvisor',
            'url' => 'https://www.tripadvisor.com.tr/Attraction_Review-g297962-d548021-Reviews-Termessos-Antalya_Turkish_Mediterranean_Coast.html',
            'language' => 'en',
        ]);
        Link::factory()->create([
            'ruin_id' => $aspendos->id,
            'description' => 'Ekşi Sözlük',
            'url' => 'https://eksisozluk.com/aspendos--79059',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $aspendos->id,
            'description' => 'Ekşi Sözlük (Aspendos Antik Tiyatrosu)',
            'url' => 'https://eksisozluk.com/aspendos-antik-tiyatrosu--48465',
            'language' => 'tr',
        ]);
        Link::factory()->create([
            'ruin_id' => $aspendos->id,
            'description' => 'Aspendos',
            'url' => 'https://tr.wikipedia.org/wiki/Aspendos',
            'language' => 'tr',
        ]);

        $migration->up();

        $this->assertDatabaseHas('links', [
            'ruin_id' => $ephesus->id,
            'description' => 'Britannica',
            'url' => 'https://www.britannica.com/topic/Seven-Sleepers-of-Ephesus',
            'language' => 'en',
        ]);
        $this->assertDatabaseHas('links', [
            'ruin_id' => $lysias->id,
            'description' => 'WildWinds',
            'url' => 'https://www.wildwinds.com/coins/greece/phrygia/lysias/i.html',
            'language' => 'en',
        ]);
        $this->assertSame(4, Link::where('ruin_id', $ephesus->id)->count());

        // Wrong-site Knidos link is gone, curated Knidos links are in.
        $this->assertDatabaseMissing('links', ['ruin_id' => $knidos->id, 'description' => 'Tripadvisor']);
        $this->assertSame(4, Link::where('ruin_id', $knidos->id)->count());

        // Aspendos dupe removed, label fixed, curated links added.
        $this->assertDatabaseMissing('links', ['url' => 'https://eksisozluk.com/aspendos-antik-tiyatrosu--48465']);
        $this->assertDatabaseHas('links', [
            'ruin_id' => $aspendos->id,
            'description' => 'Vikipedi',
            'url' => 'https://tr.wikipedia.org/wiki/Aspendos',
        ]);
        $this->assertSame(1, Link::where('ruin_id', $aspendos->id)->where('url', 'like', '%eksisozluk%')->count());

        // Re-running is a no-op (idempotent on URL).
        $migration->up();

        $this->assertSame(4, Link::where('ruin_id', $ephesus->id)->count());
        $this->assertSame(4, Link::where('ruin_id', $knidos->id)->count());
    }

    public function test_rollback_removes_only_curated_links(): void
    {
        $migration = require database_path('migrations/2026_09_21_000000_add_curated_links_spike_1.php');

        $ephesus = Ruin::factory()->create(['name' => 'Ephesus Test', 'slug' => 'ephesus']);
        $kept = Link::factory()->create(['ruin_id' => $ephesus->id]);

        $migration->up();
        $migration->down();

        $this->assertDatabaseMissing('links', [
            'url' => 'https://www.britannica.com/topic/Seven-Sleepers-of-Ephesus',
        ]);
        $this->assertDatabaseHas('links', ['id' => $kept->id]);
    }
}
