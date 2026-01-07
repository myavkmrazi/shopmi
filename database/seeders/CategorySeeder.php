<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['title' => 'Shoes', 'slug' => 'shoes', 'parent_id' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Jeans', 'slug' => 'jeans', 'parent_id' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Sportswear', 'slug' => 'sportswear', 'parent_id' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Coat', 'slug' => 'coat', 'parent_id' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Shirts', 'slug' => 'shirts', 'parent_id' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Men\'s Sportswear', 'slug' => 'mens-sportswear', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Women\'s Sportswear', 'slug' => 'womens-sportswear', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Baby\'s Sportswear', 'slug' => 'babys-sportswear', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
