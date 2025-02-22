<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class LogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('logos')->insert([

            [
                'image_path' => 'white_logo.png',
                'location' => 'footer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => 'bangabasi_logo_black.png',
                'location' => 'user_authentication',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => 'logo.png',
                'location' => 'admin_header',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => 'logo_side.png',
                'location' => 'mobile_menu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => 'logo.png',
                'location' => 'admin_authentication',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => 'bangabasi_logo.png',
                'location' => 'admin_header_minified',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
