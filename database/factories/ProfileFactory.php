<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'headline' => fake()->jobTitle(),
            'bio' => fake()->paragraph(),
            'email' => fake()->safeEmail(),
            'location' => fake()->city().', WA',
            'phone' => fake()->phoneNumber(),
            'show_phone' => false,
            'github_url' => 'https://github.com/'.fake()->userName(),
            'linkedin_url' => 'https://linkedin.com/in/'.fake()->userName(),
        ];
    }

    /**
     * Indicate that the phone number is shown publicly.
     */
    public function withVisiblePhone(): static
    {
        return $this->state(fn (array $attributes): array => [
            'show_phone' => true,
        ]);
    }
}
