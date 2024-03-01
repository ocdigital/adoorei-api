<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brand = $this->faker->randomElement(['Apple', 'Samsung', 'Google', 'OnePlus', 'Sony']);
        $model = $this->faker->word . ' ' . $this->faker->randomElement(['X', 'Pro', 'Lite', 'Max', 'Ultra']);

        return [
            'name' => $brand . ' ' . $model,
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'description' => $this->faker->paragraph,
        ];
    }
}
