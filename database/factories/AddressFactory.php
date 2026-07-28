<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'label'       => $this->faker->randomElement(['Casa', 'Trabajo', 'Otro']),
            'recipient'   => $this->faker->name(),
            'street'      => $this->faker->streetAddress(),
            'city'        => $this->faker->city(),
            'state'       => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'phone'       => $this->faker->phoneNumber(),
            'is_default'  => false,
        ];
    }
}
