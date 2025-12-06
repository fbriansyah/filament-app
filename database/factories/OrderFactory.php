<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->lexify('????-????'),
            'discount' => fake()->randomFloat(2, 0, 1000),
            'scheduled_at' => fake()->dateTimeBetween('+1 week', '+1 month'),
            'status' => fake()->randomElement(['scheduled', 'inprogress', 'rescheduled', 'cancelled', 'done']),
            'address' => fake()->address(),
            'note' => fake()->text(),
        ];
    }
}
