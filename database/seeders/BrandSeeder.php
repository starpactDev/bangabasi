<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $brands = [
                ['name' => 'Brand A', 'image' => '1.jpg', 'total_listing_products' => 1135],
                ['name' => 'Brand B', 'image' => '1.jpg', 'total_listing_products' => 785],
                ['name' => 'Brand C', 'image' => '1.jpg', 'total_listing_products' => 530],
                ['name' => 'Brand D', 'image' => '1.jpg', 'total_listing_products' => 299],
                ['name' => 'Brand E', 'image' => '1.jpg', 'total_listing_products' => 149],
            ];

            foreach ($brands as $brand) {
                DB::table('brands')->insert([
                    'brand_name' => $brand['name'],
                    'brand_image' => $brand['image'],
                    'total_listing_products' => $brand['total_listing_products'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
