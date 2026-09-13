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
            'official_site_url' => $this->faker->optional(0.5)->url,
            'tripadvisor' => $this->faker->url,
            'city_id' => City::factory()->create()->id,
            'district' => $this->faker->city,
            'site_type' => $this->faker->randomElement(['city', 'sanctuary', 'fortress', 'monument', 'religious-complex']),
            'other_names' => null,
            'is_unesco' => false,
        ];
    }
}
