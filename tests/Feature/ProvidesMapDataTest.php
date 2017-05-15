<?php

namespace Tests\Feature;

use App\Ruin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProvidesMapDataTest extends TestCase
{
    use DatabaseMigrations;

    public function testProvidesAllPointsAsJsonData()
    {
        $ruin = factory(Ruin::class)->create();
        $this->json('GET', '/api/ruins')
            ->assertStatus(200)
            ->assertJsonFragment([
                'type'       => 'Feature',
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => ["$ruin->longitude", "$ruin->latitude"]
                ],
                'properties' => [
                    'title' => $ruin->name,
                    'slug'  => $ruin->slug
                ]
            ]);
    }

    public function testProvidesARuinAsJson()
    {
        $ruin = factory(Ruin::class)->create();
        $this->json('GET', "/api/ruins/{$ruin->slug}")
            ->assertStatus(200)
            ->assertJson([
                'id' => $ruin->id,
                'slug' => $ruin->slug,
                'information' => $ruin->information
            ]);
    }
}
