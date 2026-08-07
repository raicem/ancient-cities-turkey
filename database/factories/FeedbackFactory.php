<?php

namespace Database\Factories;

use App\Ruin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ruin = Ruin::factory()->create();

        return [
            'ruin_id' => $ruin->id,
            'ruin' => $ruin->slug,
            'body' => $this->faker->paragraph,
        ];
    }
}
