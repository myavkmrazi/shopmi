<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = DB::table('categories')->pluck('id')->toArray();
        $faker = fake('ru_RU');

        $streetwearNames = [
            'Куртка Urban Tech Black', 'Худи Oversize Heavyweight',
            'Свитшот Cyberpunk Neon', 'Брюки Карго Tactical Cargo',
            'Кроссовки Wave Runner X', 'Футболка Minimalist White',
            'Кепка Street Icon', 'Рюкзак Waterproof Roll-Top',
            'Бомбер Flight Jacket Alpha', 'Джоггеры Techwear Stealth',
            'Куртка-Ветровка Reflective', 'Лонгслив Base Layer Grey',
            'Шорты Спортивные Mesh', 'Худи Zip-Up Charcoal',
        ];

        foreach ($categories as $category_id) {
            for ($i = 1; $i <= 10; $i++) {
                $baseTitle = $faker->randomElement($streetwearNames);
                $title = $baseTitle.' '.rand(100, 999);

                $price = rand(49, 249);

                $oldPrice = rand(0, 1) ? $price + rand(20, 70) : 0;

                $gallery = [];
                for ($g = 1; $g <= rand(3, 5); $g++) {
                    $gallery[] = 'public/img/products/'.rand(1, 10).'.jpg';
                }

                DB::table('products')->insert([
                    'title' => $title,
                    'slug' => Str::slug($title, '-'),
                    'category_id' => $category_id,
                    'excerpt' => $faker->text(120),
                    'content' => $faker->paragraphs(3, true),
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'image' => 'public/img/products/'.rand(1, 10).'.jpg',
                    'gallery' => json_encode($gallery),
                    'is_hit' => rand(0, 1),
                    'is_new' => rand(0, 1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
