<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Golongan>
 */
class GolonganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'harga' => $this->faker->randomFloat(2, 1000, 10000),
        'golongan' => $this->faker->word,
        ];
    }
}
