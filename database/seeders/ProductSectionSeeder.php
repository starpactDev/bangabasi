<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'name' => 'Today’s Popular Picks',
                'slug' => 'todays-popular-picks',

                'sort_order' => 1,
            ],
            [
                'name' => 'Most Wishes For In Clothing',
                'slug' => 'most-wishes-for-in-clothing',

                'sort_order' => 2,
            ],
            [
                'name' => 'Handpicked Products For You',
                'slug' => 'handpicked-products-for-you',
                
                'sort_order' => 3,
            ],
        ];

        foreach ($sections as $section) {
            DB::table('product_sections')->updateOrInsert(
                ['slug' => $section['slug']], // Check for existing records
                $section // Update or insert
            );
        }
    }
}
