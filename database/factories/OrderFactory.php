<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'status'  => $this->faker->randomElement(OrderStatus::cases()),
            'total'   => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
