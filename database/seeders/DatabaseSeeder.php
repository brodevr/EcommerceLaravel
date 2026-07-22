<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name'  => 'Admin PetFy',
            'email' => 'admin@petfy.com',
            'role'  => Role::Admin,
        ]);

        User::factory()->create([
            'name'  => 'Cliente Test',
            'email' => 'cliente@petfy.com',
            'role'  => Role::Cliente,
        ]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
