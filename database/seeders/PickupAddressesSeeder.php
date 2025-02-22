<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PickupAddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pickup_addresses')->insert([
            'user_id' => 1, // Assuming a user with ID 1 exists
            'building' => 'Block A, Apartment 302',
            'street' => 'Park Street',
            'locality' => 'Middleton Row',
            'landmark' => 'Near Park Hotel',
            'pincode' => '700016',
            'city' => 'Kolkata',
            'state' => 'West Bengal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
