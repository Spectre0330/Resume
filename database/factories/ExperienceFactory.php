<?php

namespace Database\Factories;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company' => fake()->company(),
            'role' => fake()->jobTitle(),
            'location' => fake()->city().', WA',
            'started_on' => fake()->dateTimeBetween('-6 years', '-2 years'),
            'ended_on' => fake()->dateTimeBetween('-2 years', 'now'),
            'bullets' => fake()->sentences(3),
        ];
    }

    /**
     * Indicate that the role is ongoing.
     */
    public function current(): static
    {
        return $this->state(fn (array $attributes): array => [
            'ended_on' => null,
        ]);
    }
}
