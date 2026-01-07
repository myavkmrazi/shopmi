<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = DB::table('categories')->pluck('id')->toArray();
        $faker = fake('ru_RU');

        foreach ($categories as $category_id) {
            for ($i = 1; $i <= 10; $i++) {
                $title = $faker->unique()->sentence(3);
                $price = rand(50000, 500000); // цена в суммах (пример)
                $gallery = [];

                // Генерируем 3–5 картинок
                for ($g = 1; $g <= rand(3, 5); $g++) {
                    $gallery[] = 'public/img/products/' . rand(1, 10) . '.jpg';
                }

                DB::table('products')->insert([
                    'title' => $title,
                    'slug' => Str::slug($title, '-'),
                    'category_id' => $category_id,
                    'excerpt' => $faker->text(120),
                    'content' => $faker->paragraphs(3, true),
                    'price' => $price,
                    'old_price' => rand(0, $price + 20000),
                    'image' => 'public/img/products/' . rand(1, 10) . '.jpg',
                    'galery' => json_encode($gallery),
                    'is_hit' => rand(0, 1),
                    'is_new' => rand(0, 1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
