<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => ucwords($this->faker->words(3, true)),
            'description' => $this->faker->paragraph(),
            'price'       => $this->faker->randomFloat(2, 100, 5000),
            'image'       => 'placeholder.jpg',
            'stock'       => $this->faker->numberBetween(0, 100),
            'is_active'   => true,
        ];
    }
}
