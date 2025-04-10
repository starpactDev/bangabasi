<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\PackageDimension;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PackageDimensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Seed for products with IDs from 61 to 144
        foreach (range(61, 144) as $productId) {
            // Check if the product ID exists in the products table
            if (Product::find($productId)) {
                // Only insert into product_dimensions if the product_id exists
                PackageDimension::create([
                    'product_id'        => $productId,
                    'length'            => $faker->numberBetween(10, 100),  // Length in cm (10cm to 100cm)
                    'width'             => $faker->numberBetween(10, 50),   // Width in cm (10cm to 50cm)
                    'height'            => $faker->numberBetween(10, 50),   // Height in cm (10cm to 50cm)
                    'weight'            => $faker->randomFloat(2, 0.1, 10), // Weight in kg (0.1kg to 10kg)
                    'volumetric_weight' => ($faker->numberBetween(10, 100) * $faker->numberBetween(10, 50) * $faker->numberBetween(10, 50)) / 5000, // Volumetric weight in kg
                ]);
            }
        }
    }
}
