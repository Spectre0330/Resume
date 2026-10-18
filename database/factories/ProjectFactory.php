<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(12),
            'tech' => fake()->randomElements(['PHP', 'Laravel', 'Python', 'C++', 'C#', 'Haskell'], 2),
            'repo_url' => 'https://github.com/'.fake()->userName().'/'.fake()->slug(2),
            'live_url' => null,
            'is_featured' => true,
        ];
    }
}
