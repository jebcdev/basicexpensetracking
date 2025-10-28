<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CashMovement>
 */
class CashMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = \App\Models\User::pluck('id')->random();
        $categoryId = \App\Models\Category::pluck('id')->random();
        return [
            'user_id' => $userId,
            'category_id' => $categoryId,
            'parent_id' => null,
            'type' => fake()->randomElement(\App\Enums\CashMovementType::values()),
            'amount' => fake()->numberBetween(0, 1000),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'date' => fake()->randomElement([
                // now()->subDays(15),
                // now()->subDays(7),
                now()->addDays(0),
                now()->addDays(7),
                now()->addDays(15),
                now(),
            ]),
            'is_recurrent' => false,
            'recurrent_period' => null,
        ];
    }
}
