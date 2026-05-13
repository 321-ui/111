<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MasterClass>
 */
class MasterClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'instructor_id' => User::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'date' => fake()->date(),
            'time' => fake()->randomElement(['09:00', '11:00', '13:00', '15:00']),
            'max_participants' => fake()->numberBetween(5, 20),
            'price' => fake()->randomFloat(2, 100, 5000),
        ];
    }
}
