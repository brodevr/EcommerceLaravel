<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $perros    = Category::where('slug', 'alimentos-perros')->first();
        $gatos     = Category::where('slug', 'alimentos-gatos')->first();
        $accesorios = Category::where('slug', 'accesorios')->first();
        $juguetes  = Category::where('slug', 'juguetes')->first();
        $higiene   = Category::where('slug', 'higiene-salud')->first();

        $productos = [
            [
                'name'        => 'Krof Cat Adulto 7.5 kg',
                'description' => 'Alimento balanceado para gatos adultos. Rico en proteínas y vitaminas esenciales.',
                'price'       => 4200.00,
                'image'       => 'Krof-Cat-Adulto.jpg',
                'stock'       => 30,
                'categories'  => [$gatos->id],
            ],
            [
                'name'        => 'Pro Plan Active Mind 7+ 1.5 kg',
                'description' => 'Fórmula especial para gatos mayores de 7 años. Cuida la salud cognitiva.',
                'price'       => 6800.00,
                'image'       => 'Alimento-Pro-Plan-Cat-Active-Mind-7.jpg',
                'stock'       => 20,
                'categories'  => [$gatos->id],
            ],
            [
                'name'        => 'Pro Plan Urinary 1.5 kg',
                'description' => 'Dieta específica para el control de problemas urinarios en gatos.',
                'price'       => 7200.00,
                'image'       => 'Alimento-Pro-Plan-Cat-Urinary.jpg',
                'stock'       => 15,
                'categories'  => [$gatos->id],
            ],
            [
                'name'        => 'Eukanuba Small Adult 3 kg',
                'description' => 'Alimento premium para perros adultos de razas pequeñas. Proteína de pollo.',
                'price'       => 5900.00,
                'image'       => 'Eukanuba-Small-Adult.jpg',
                'stock'       => 25,
                'categories'  => [$perros->id],
            ],
            [
                'name'        => 'Comida para Perro 10 kg',
                'description' => 'Alimento completo para perros adultos de todas las razas.',
                'price'       => 3800.00,
                'image'       => 'Comida-Perro.jpg',
                'stock'       => 40,
                'categories'  => [$perros->id],
            ],
            [
                'name'        => 'Cama para Mascotas',
                'description' => 'Cama acolchada con bordes suaves. Ideal para perros y gatos de talla mediana.',
                'price'       => 8500.00,
                'image'       => 'Cama-Mascotas.jpg',
                'stock'       => 12,
                'categories'  => [$accesorios->id],
            ],
            [
                'name'        => 'Carrier Jet Ferplast 10–20 kg',
                'description' => 'Transporte seguro y ventilado para mascotas de hasta 20 kg. Apto para viajes.',
                'price'       => 15900.00,
                'image'       => 'Carrier-Jet-10-20-Ferplast-A.jpg',
                'stock'       => 8,
                'categories'  => [$accesorios->id],
            ],
            [
                'name'        => 'Comedero Felino Blanco',
                'description' => 'Comedero de cerámica antideslizante para gatos. Fácil de lavar.',
                'price'       => 1200.00,
                'image'       => 'Comedero-Felino-Blanco.jpg',
                'stock'       => 35,
                'categories'  => [$accesorios->id],
            ],
            [
                'name'        => 'Comedero Hueso Blanco',
                'description' => 'Comedero con diseño de hueso para perros pequeños y medianos.',
                'price'       => 950.00,
                'image'       => 'Comedero-Hueso-Blanco.jpg',
                'stock'       => 35,
                'categories'  => [$accesorios->id],
            ],
            [
                'name'        => 'Juguete Interactivo para Gato',
                'description' => 'Juguete con plumas y cascabel para estimular el instinto cazador del gato.',
                'price'       => 1800.00,
                'image'       => 'Juguete-Gato.jpg',
                'stock'       => 50,
                'categories'  => [$juguetes->id],
            ],
            [
                'name'        => 'Piedras Sanitarias Absorsol Premium 3 kg',
                'description' => 'Aglomerante de alta absorción. Elimina olores y facilita la limpieza.',
                'price'       => 2600.00,
                'image'       => 'Piedras-Sanitarias-Absorsol-Premium.jpg',
                'stock'       => 45,
                'categories'  => [$higiene->id],
            ],
            [
                'name'        => 'Rascador Torre con Pesa',
                'description' => 'Rascador estable con base pesada y poste de sisal natural.',
                'price'       => 5400.00,
                'image'       => 'Rascador-Pesa.jpg',
                'stock'       => 10,
                'categories'  => [$juguetes->id, $accesorios->id],
            ],
            [
                'name'        => 'Rascador Rampa con Pelota',
                'description' => 'Rascador inclinado con pelota colgante. Perfecto para gatos activos.',
                'price'       => 3900.00,
                'image'       => 'Rascador-Rampa-Con-Pelota.jpg',
                'stock'       => 14,
                'categories'  => [$juguetes->id],
            ],
        ];

        foreach ($productos as $data) {
            $cats = $data['categories'];
            unset($data['categories']);

            $product = Product::firstOrCreate(['name' => $data['name']], $data);
            $product->categories()->sync($cats);
        }
    }
}
