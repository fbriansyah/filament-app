<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakeName = fake()->unique()->randomElement(['Admin', 'Writer', 'Editor', 'Staff', 'Worker']);
        $slug = Str::snake($fakeName);
        return [
            'name' => $fakeName,
            'slug' => $slug,
            'description' => fake()->text(100),
        ];
    }
}
