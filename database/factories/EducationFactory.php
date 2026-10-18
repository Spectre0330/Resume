<?php

namespace Database\Factories;

use App\Models\Education;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Education>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'institution' => fake()->company().' University',
            'credential' => 'B.S. '.fake()->word(),
            'started_on' => fake()->dateTimeBetween('-8 years', '-5 years'),
            'ended_on' => fake()->dateTimeBetween('-4 years', '-1 years'),
            'details' => fake()->sentences(2),
        ];
    }
}
