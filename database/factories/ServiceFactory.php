<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->word(),
            "code" => fake()->lexify("????"),
            "price" => fake()->randomFloat(2, 10000, 1000000),
            "duration" => fake()->randomNumber(1),
            "unit" => fake()->randomElement(["minute", "hour", "day", "week", "month", "year"]),
            "place" => fake()->randomElement(["homecare", "onsite"]),
            "description" => fake()->text(100),
        ];
    }
}
