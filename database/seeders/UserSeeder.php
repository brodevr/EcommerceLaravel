<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Enums\Role;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──────────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@petfy.com'],
            [
                'name'              => 'Admin PetFy',
                'password'          => Hash::make('Admin1234'),
                'role'              => Role::Admin,
                'email_verified_at' => now(),
            ]
        );

        // ── Clientes demo ──────────────────────────────────────────────────
        $clientes = [
            ['name' => 'Ana García',    'email' => 'ana@petfy.com'],
            ['name' => 'Carlos López',  'email' => 'carlos@petfy.com'],
            ['name' => 'María Pérez',   'email' => 'maria@petfy.com'],
        ];

        foreach ($clientes as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'              => $data['name'],
                    'password'          => Hash::make('Cliente1234'),
                    'role'              => Role::Cliente,
                    'email_verified_at' => now(),
                ]
            );

            // Dirección principal
            if ($user->addresses()->count() === 0) {
                $user->addresses()->create([
                    'recipient'   => $data['name'],
                    'label'       => 'Casa',
                    'street'      => fake('es_AR')->streetAddress(),
                    'city'        => fake('es_AR')->city(),
                    'state'       => 'Buenos Aires',
                    'postal_code' => fake()->numerify('####'),
                    'phone'       => fake('es_AR')->phoneNumber(),
                    'is_default'  => true,
                ]);
            }
        }

        // ── Pedidos demo en distintos estados ──────────────────────────────
        $productos = Product::inRandomOrder()->take(6)->get();

        if ($productos->isEmpty()) {
            return;
        }

        $clienteUsers = User::where('role', Role::Cliente)->get();

        $estados = [
            OrderStatus::Pendiente,
            OrderStatus::Procesando,
            OrderStatus::Enviado,
            OrderStatus::Entregado,
            OrderStatus::Cancelado,
        ];

        foreach ($clienteUsers as $index => $cliente) {
            $address = $cliente->addresses()->first();

            foreach (array_slice($estados, 0, 3) as $status) {
                $items = $productos->random(rand(1, 3));
                $total = $items->sum('price');

                $order = Order::create([
                    'user_id'             => $cliente->id,
                    'shipping_address_id' => $address?->id,
                    'status'              => $status,
                    'total'               => $total,
                ]);

                foreach ($items as $producto) {
                    $order->items()->create([
                        'product_id' => $producto->id,
                        'quantity'   => rand(1, 3),
                        'unit_price' => $producto->price,
                    ]);
                }
            }
        }
    }
}
