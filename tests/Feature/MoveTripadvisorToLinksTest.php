<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MoveTripadvisorToLinksTest extends TestCase
{
    use RefreshDatabase;

    public function test_tripadvisor_urls_move_into_the_links_table(): void
    {
        $migration = require database_path('migrations/2026_09_20_000000_move_tripadvisor_to_links_table.php');

        // Restore the column so the test can seed pre-migration data.
        $migration->down();

        $ruin = Ruin::factory()->create();
        $url = 'https://www.tripadvisor.com.tr/Attraction_Review-g297962-d54';
        DB::table('ruins')->where('id', $ruin->id)->update(['tripadvisor' => $url]);

        $blank = Ruin::factory()->create();
        DB::table('ruins')->where('id', $blank->id)->update(['tripadvisor' => '']);

        $alreadyLinked = Ruin::factory()->create();
        Link::factory()->create([
            'ruin_id' => $alreadyLinked->id,
            'description' => 'Wikipedia',
            'url' => $url,
            'language' => 'en',
        ]);
        DB::table('ruins')->where('id', $alreadyLinked->id)->update(['tripadvisor' => $url]);

        $migration->up();

        $this->assertDatabaseHas('links', [
            'ruin_id' => $ruin->id,
            'description' => 'Tripadvisor',
            'url' => $url,
            'language' => 'en',
        ]);
        $this->assertDatabaseMissing('links', ['ruin_id' => $blank->id]);
        $this->assertSame(1, Link::where('ruin_id', $alreadyLinked->id)->count());
        $this->assertDatabaseMissing('links', [
            'ruin_id' => $alreadyLinked->id,
            'description' => 'Tripadvisor',
        ]);
        $this->assertFalse(Schema::hasColumn('ruins', 'tripadvisor'));
    }

    public function test_rollback_restores_the_column_and_urls(): void
    {
        $migration = require database_path('migrations/2026_09_20_000000_move_tripadvisor_to_links_table.php');

        $migration->down();

        $ruin = Ruin::factory()->create();
        $url = 'https://www.tripadvisor.com/Attraction_Review-g123-d456';
        DB::table('ruins')->where('id', $ruin->id)->update(['tripadvisor' => $url]);

        $migration->up();
        $migration->down();

        $this->assertDatabaseHas('ruins', ['id' => $ruin->id, 'tripadvisor' => $url]);
        $this->assertDatabaseMissing('links', [
            'ruin_id' => $ruin->id,
            'description' => 'Tripadvisor',
        ]);
    }
}
