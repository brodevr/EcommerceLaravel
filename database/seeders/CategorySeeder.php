<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Alimentos para Perros',  'slug' => 'alimentos-perros',  'description' => 'Alimentos secos, húmedos y snacks para perros.'],
            ['name' => 'Alimentos para Gatos',   'slug' => 'alimentos-gatos',   'description' => 'Alimentos secos, húmedos y snacks para gatos.'],
            ['name' => 'Accesorios',              'slug' => 'accesorios',        'description' => 'Camas, transportines, comederos y más.'],
            ['name' => 'Juguetes',                'slug' => 'juguetes',          'description' => 'Juguetes y entretenimiento para tu mascota.'],
            ['name' => 'Higiene y Salud',         'slug' => 'higiene-salud',     'description' => 'Piedras sanitarias, champús y cuidado general.'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
