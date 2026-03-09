<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['name' => 'Football', 'category' => 'Sporting Goods', 'price' => 49.99, 'stocked' => true],
            ['name' => 'Baseball', 'category' => 'Sporting Goods', 'price' => 9.99, 'stocked' => true],
            ['name' => 'iPod Touch', 'category' => 'Electronics', 'price' => 99.99, 'stocked' => true],
            ['name' => 'iPhone 15', 'category' => 'Electronics', 'price' => 999.99, 'stocked' => false],
        ];

        foreach ($items as $item) {
            Product::create($item);
        }
    }
}
