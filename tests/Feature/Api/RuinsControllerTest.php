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
        $ruin = Ruin::factory()->count(2)->create([
            'site_type' => 'fortress',
            'is_unesco' => true,
            'official_site_url' => 'https://example.com/official',
        ]);
        $firstRuin = $ruin[0];
        $secondRuin = $ruin[1];

        $this->json('GET', route('api.ruins.list', ['locale' => 'tr']))
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => $firstRuin->name_tr,
                'slug' => $firstRuin->slug,
                'latitude' => $firstRuin->latitude,
                'longitude' => $firstRuin->longitude,
                'image' => $firstRuin->image,
                'city' => $firstRuin->city->name,
                'district' => $firstRuin->district,
                'site_type' => 'fortress',
                'is_unesco' => true,
                'official_site_link' => 'https://example.com/official',
            ])

            ->assertJsonFragment([
                'name' => $secondRuin->name_tr,
                'slug' => $secondRuin->slug,
                'latitude' => $secondRuin->latitude,
                'longitude' => $secondRuin->longitude,
            ]);
    }

    public function test_it_serves_all_ruins_in_the_database_in_english()
    {
        $ruin = Ruin::factory()->count(2)->create();
        $firstRuin = $ruin[0];
        $secondRuin = $ruin[1];

        $this->json('GET', route('api.ruins.list', ['locale' => 'en']))
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => $firstRuin->name,
                'slug' => $firstRuin->slug,
                'latitude' => $firstRuin->latitude,
                'longitude' => $firstRuin->longitude,
                'image' => $firstRuin->image,
                'city' => $firstRuin->city->name,
                'district' => $firstRuin->district,
            ])

            ->assertJsonFragment([
                'name' => $secondRuin->name,
                'slug' => $secondRuin->slug,
                'latitude' => $secondRuin->latitude,
                'longitude' => $secondRuin->longitude,
            ]);
    }

    public function test_index_is_publicly_cacheable()
    {
        Ruin::factory()->count(2)->create();

        $response = $this->json('GET', route('api.ruins.list', ['locale' => 'en']));

        $response->assertStatus(200);
        $cacheControl = $response->headers->get('Cache-Control');
        $this->assertStringContainsString('public', $cacheControl);
        $this->assertStringContainsString('s-maxage=3600', $cacheControl);
        $this->assertStringContainsString('stale-while-revalidate=86400', $cacheControl);
    }

    public function test_it_serves_a_detail_ruin_info_in_english()
    {
        /** @var Ruin $ruin */
        $ruin = Ruin::factory()->create();

        /** @var Link $turkishLink */
        $turkishLink = Link::factory()->create(['ruin_id' => $ruin->id, 'language' => 'tr']);

        /** @var Link $englishLink */
        $englishLink = Link::factory()->create(['ruin_id' => $ruin->id, 'language' => 'en']);

        $this->json('GET', route('api.ruins.show', ['ruin' => $ruin->slug, 'locale' => 'en']))
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $ruin->id,
                'name' => $ruin->name,
                'slug' => $ruin->slug,
                'latitude' => $ruin->latitude,
                'longitude' => $ruin->longitude,
                'information' => $ruin->information,
                'image' => $ruin->image,
                'official_site_link' => $ruin->official_site_url,
                'site_type' => $ruin->site_type,
                'other_names' => $ruin->other_names,
                'is_unesco' => $ruin->is_unesco,
                'city_id' => $ruin->city->id,
                'city' => $ruin->city->name,
                'district' => $ruin->district,
            ])
            ->assertJsonFragment([
                'description' => $turkishLink->description,
                'url' => $turkishLink->url,
                'language' => $turkishLink->language,
            ])->assertJsonFragment([
                'description' => $englishLink->description,
                'url' => $englishLink->url,
                'language' => $englishLink->language,
           ]);
    }

    public function test_it_serves_a_detail_ruin_info_in_turkish()
    {
        /** @var Ruin $ruin */
        $ruin = Ruin::factory()->create();

        /** @var Link $turkishLink */
        $turkishLink = Link::factory()->create(['ruin_id' => $ruin->id, 'language' => 'tr']);

        /** @var Link $englishLink */
        $englishLink = Link::factory()->create(['ruin_id' => $ruin->id, 'language' => 'en']);

        $this->json('GET', route('api.ruins.show', ['ruin' => $ruin->slug, 'locale' => 'tr']))
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $ruin->id,
                'name' => $ruin->name_tr,
                'slug' => $ruin->slug,
                'latitude' => $ruin->latitude,
                'longitude' => $ruin->longitude,
                'information' => $ruin->information_tr,
                'image' => $ruin->image,
                'official_site_link' => $ruin->official_site_url,
                'site_type' => $ruin->site_type,
                'other_names' => $ruin->other_names,
                'is_unesco' => $ruin->is_unesco,
                'city_id' => $ruin->city->id,
                'city' => $ruin->city->name,
                'district' => $ruin->district,
            ])
            ->assertJsonFragment([
                'description' => $turkishLink->description,
                'url' => $turkishLink->url,
                'language' => $turkishLink->language,
            ])->assertJsonFragment([
                'description' => $englishLink->description,
                'url' => $englishLink->url,
                'language' => $englishLink->language,
            ]);
    }
}
