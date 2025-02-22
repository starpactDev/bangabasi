<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViewSaleAboveDiscountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('view_sale_above_discounts')->insert([
            'discount' => 100,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
