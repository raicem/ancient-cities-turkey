<?php

namespace Database\Factories;

use App\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Ruin>
 */
class RuinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word;

        return [
            'name' => $name,
            'name_tr' => $this->faker->word,
            'slug' => Str::slug($name),
            'latitude' => $this->faker->latitude(36, 42),
            'longitude' => $this->faker->longitude(26, 44),
            'information' => $this->faker->sentence,
            'information_tr' => $this->faker->sentence,
            'official_site' => $this->faker->boolean,
            'tripadvisor' => $this->faker->url,
            'foursquare' => $this->faker->url,
            'official_site_tr' => $this->faker->url,
            'official_site_en' => $this->faker->url,
            'city_id' => City::factory()->create()->id,
        ];
    }
}
