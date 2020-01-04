<?php

namespace Tests\Feature\Api;

use App\Link;
use App\Ruin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RuinsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_serves_all_ruins_in_the_database_in_turkish()
    {
        $ruin = factory(Ruin::class, 2)->create();
        $firstRuin = $ruin[0];
        $secondRuin = $ruin[1];

        $this->json('GET', route('api.ruins.list', ['locale' => 'tr']))
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => $firstRuin->name_tr,
                'slug' => $firstRuin->slug,
                'latitude' => $firstRuin->latitude . 0,
                'longitude' => $firstRuin->longitude . 0,
            ])
            ->assertJsonFragment([
                'name' => $secondRuin->name_tr,
                'slug' => $secondRuin->slug,
                'latitude' => $secondRuin->latitude . 0,
                'longitude' => $secondRuin->longitude . 0,
            ]);
    }

    public function test_it_serves_all_ruins_in_the_database_in_english()
    {
        $ruin = factory(Ruin::class, 2)->create();
        $firstRuin = $ruin[0];
        $secondRuin = $ruin[1];

        $this->json('GET', route('api.ruins.list', ['locale' => 'en']))
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => $firstRuin->name,
                'slug' => $firstRuin->slug,
                'latitude' => $firstRuin->latitude . 0,
                'longitude' => $firstRuin->longitude . 0,
            ])
            ->assertJsonFragment([
                'name' => $secondRuin->name,
                'slug' => $secondRuin->slug,
                'latitude' => $secondRuin->latitude . 0,
                'longitude' => $secondRuin->longitude . 0,
            ]);
    }

    public function test_it_serves_a_detail_ruin_info_in_english()
    {
        /** @var Ruin $ruin */
        $ruin = factory(Ruin::class)->create();

        /** @var Link $turkishLink */
        $turkishLink = factory(Link::class)->create(['ruin_id' => $ruin->id, 'language' => 'tr']);

        /** @var Link $englishLink */
        $englishLink = factory(Link::class)->create(['ruin_id' => $ruin->id, 'language' => 'en']);

        $this->json('GET', route('api.ruins.show', ['slug' => $ruin->slug, 'locale' => 'en']))
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $ruin->id,
                'name' => $ruin->name,
                'slug' => $ruin->slug,
                'latitude' => $ruin->latitude . 0,
                'longitude' => $ruin->longitude . 0,
                'information' => $ruin->information,
                'image' => $ruin->image,
                'tripadvisor' => $ruin->tripadvisor,
                'foursquare' => $ruin->foursquare,
                'official_site' => (int)$ruin->official_site,
                'official_site_link' => $ruin->official_site_en,
                'city_id' => $ruin->city->id,
            ])
            ->assertJsonFragment([
                'id' => $turkishLink->id,
                'ruin_id' => $ruin->id,
                'description' => $turkishLink->description,
                'url' => $turkishLink->url,
                'language' => $turkishLink->language,
                'created_at' => $turkishLink->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $turkishLink->updated_at->format('Y-m-d H:i:s'),
            ])->assertJsonFragment([
                'id' => $englishLink->id,
                'ruin_id' => $ruin->id,
                'description' => $englishLink->description,
                'url' => $englishLink->url,
                'language' => $englishLink->language,
                'created_at' => $englishLink->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $englishLink->updated_at->format('Y-m-d H:i:s'),
            ]);
    }

    public function test_it_serves_a_detail_ruin_info_in_turkish()
    {
        /** @var Ruin $ruin */
        $ruin = factory(Ruin::class)->create();

        /** @var Link $turkishLink */
        $turkishLink = factory(Link::class)->create(['ruin_id' => $ruin->id, 'language' => 'tr']);

        /** @var Link $englishLink */
        $englishLink = factory(Link::class)->create(['ruin_id' => $ruin->id, 'language' => 'en']);

        $this->json('GET', route('api.ruins.show', ['slug' => $ruin->slug, 'locale' => 'tr']))
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $ruin->id,
                'name' => $ruin->name_tr,
                'slug' => $ruin->slug,
                'latitude' => $ruin->latitude . 0,
                'longitude' => $ruin->longitude . 0,
                'information' => $ruin->information_tr,
                'image' => $ruin->image,
                'tripadvisor' => $ruin->tripadvisor,
                'foursquare' => $ruin->foursquare,
                'official_site' => (int)$ruin->official_site,
                'official_site_link' => $ruin->official_site_tr,
                'city_id' => $ruin->city->id,
            ])
            ->assertJsonFragment([
                'id' => $turkishLink->id,
                'ruin_id' => $ruin->id,
                'description' => $turkishLink->description,
                'url' => $turkishLink->url,
                'language' => $turkishLink->language,
                'created_at' => $turkishLink->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $turkishLink->updated_at->format('Y-m-d H:i:s'),
            ])->assertJsonFragment([
                'id' => $englishLink->id,
                'ruin_id' => $ruin->id,
                'description' => $englishLink->description,
                'url' => $englishLink->url,
                'language' => $englishLink->language,
                'created_at' => $englishLink->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $englishLink->updated_at->format('Y-m-d H:i:s'),
            ]);
    }
}
