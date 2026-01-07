<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('filter_groups')->insert([
            ['id' => 1, 'title' => 'Color'],
            ['id' => 2, 'title' => 'Clothing size'],
            ['id' => 3, 'title' => 'Shoe size'],
        ]);

        DB::table('category_filters')->insert([
            ['category_id' => 1, 'filter_group_id' => 1],
            ['category_id' => 1, 'filter_group_id' => 3],
            ['category_id' => 2, 'filter_group_id' => 1],
            ['category_id' => 2, 'filter_group_id' => 2],
            ['category_id' => 4, 'filter_group_id' => 1],
            ['category_id' => 4, 'filter_group_id' => 2],
            ['category_id' => 6, 'filter_group_id' => 1],
            ['category_id' => 6, 'filter_group_id' => 2],
        ]);

        DB::table('filters')->insert([
            ['id' => 1, 'title' => 'Black', 'filter_group_id' => 1],
            ['id' => 2, 'title' => 'White', 'filter_group_id' => 1],
            ['id' => 3, 'title' => 'Red', 'filter_group_id' => 1],
            ['id' => 4, 'title' => 'Yellow', 'filter_group_id' => 1],
            ['id' => 5, 'title' => 'XS', 'filter_group_id' => 2],
            ['id' => 6, 'title' => 'S', 'filter_group_id' => 2],
            ['id' => 7, 'title' => 'M', 'filter_group_id' => 2],
            ['id' => 8, 'title' => 'L', 'filter_group_id' => 2],
            ['id' => 9, 'title' => 'XL', 'filter_group_id' => 2],
            ['id' => 10, 'title' => '37', 'filter_group_id' => 3],
            ['id' => 11, 'title' => '38', 'filter_group_id' => 3],
            ['id' => 12, 'title' => '39', 'filter_group_id' => 3],
            ['id' => 13, 'title' => '40', 'filter_group_id' => 3],
            ['id' => 14, 'title' => '41', 'filter_group_id' => 3],
            ['id' => 15, 'title' => '42', 'filter_group_id' => 3],
            ['id' => 16, 'title' => '43', 'filter_group_id' => 3],
        ]);

        DB::table('filter_products')->insert([
            // category 1
            ['filter_id' => 1, 'product_id' => 1, 'filter_group_id' => 1],
            ['filter_id' => 1, 'product_id' => 2, 'filter_group_id' => 1],
            ['filter_id' => 1, 'product_id' => 4, 'filter_group_id' => 1],
            ['filter_id' => 1, 'product_id' => 6, 'filter_group_id' => 1],
            ['filter_id' => 1, 'product_id' => 7, 'filter_group_id' => 1],
            ['filter_id' => 1, 'product_id' => 9, 'filter_group_id' => 1],
            ['filter_id' => 1, 'product_id' => 10, 'filter_group_id' => 1],
            ['filter_id' => 2, 'product_id' => 5, 'filter_group_id' => 1],
            ['filter_id' => 2, 'product_id' => 8, 'filter_group_id' => 1],
            ['filter_id' => 10, 'product_id' => 1, 'filter_group_id' => 3],
            ['filter_id' => 10, 'product_id' => 2, 'filter_group_id' => 3],
            ['filter_id' => 10, 'product_id' => 4, 'filter_group_id' => 3],
            ['filter_id' => 11, 'product_id' => 2, 'filter_group_id' => 3],
            ['filter_id' => 15, 'product_id' => 5, 'filter_group_id' => 3],
            ['filter_id' => 3, 'product_id' => 3, 'filter_group_id' => 1],
            ['filter_id' => 3, 'product_id' => 7, 'filter_group_id' => 1],
            ['filter_id' => 3, 'product_id' => 9, 'filter_group_id' => 1],

            // category 2
            ['filter_id' => 1, 'product_id' => 11, 'filter_group_id' => 1],
            ['filter_id' => 1, 'product_id' => 12, 'filter_group_id' => 1],
            ['filter_id' => 1, 'product_id' => 14, 'filter_group_id' => 1],
            ['filter_id' => 2, 'product_id' => 15, 'filter_group_id' => 1],
            ['filter_id' => 2, 'product_id' => 18, 'filter_group_id' => 1],
            ['filter_id' => 5, 'product_id' => 11, 'filter_group_id' => 2],
            ['filter_id' => 6, 'product_id' => 12, 'filter_group_id' => 2],
            ['filter_id' => 8, 'product_id' => 14, 'filter_group_id' => 2],
            ['filter_id' => 9, 'product_id' => 15, 'filter_group_id' => 2],

            // category 4
            ['filter_id' => 1, 'product_id' => 21, 'filter_group_id' => 1],
            ['filter_id' => 1, 'product_id' => 22, 'filter_group_id' => 1],
            ['filter_id' => 1, 'product_id' => 24, 'filter_group_id' => 1],
            ['filter_id' => 2, 'product_id' => 25, 'filter_group_id' => 1],
            ['filter_id' => 2, 'product_id' => 28, 'filter_group_id' => 1],
            ['filter_id' => 5, 'product_id' => 21, 'filter_group_id' => 2],
            ['filter_id' => 6, 'product_id' => 22, 'filter_group_id' => 2],
            ['filter_id' => 8, 'product_id' => 24, 'filter_group_id' => 2],
            ['filter_id' => 9, 'product_id' => 25, 'filter_group_id' => 2],
        ]);
    }
}
