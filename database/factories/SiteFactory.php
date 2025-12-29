<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Site>
 */
class SiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'url' => fake()->unique()->url(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'keywords' => fake()->word(),
            'marquee' => fake()->sentence(),
            'logo' => fake()->imageUrl(),
            'favicon' => fake()->imageUrl(),
            'card' => fake()->imageUrl()
        ];
    }
}
