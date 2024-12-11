<?php

namespace Database\Factories;

use App\Models\User;
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
            'user_id' => User::factory(), // Creates a related User
            'status' => $this->faker->randomElement(['Pending', 'In-Progress', 'Completed']),
            'send_to_kitchen_time' => $this->faker->dateTimeBetween('now', '+2 hours'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
