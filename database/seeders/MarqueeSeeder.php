<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Marquee;

class MarqueeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Marquee::create([
            'text' => 'Take <span class="text-yellow-200">30% Off</span> when you spend ₹960 <a href="" class="uppercase text-white">SHOP Now</a>',
        ]);

        Marquee::create([
            'text' => 'Only in this week. <span class="text-yellow-200">Free Shipping</span> for all orders above ₹900 <a href="" class="uppercase text-white">SHOP Now</a>',
        ]);
        Marquee::create([
            'text' => 'Hurry! <span class="text-yellow-200">20% Off</span> on selected items. <a href="" class="uppercase text-white">Grab Now</a>',
        ]);
    
        Marquee::create([
            'text' => 'Limited time offer: <span class="text-yellow-200">Buy 1 Get 1 Free</span> on all accessories! <a href="" class="uppercase text-white">Shop Now</a>',
        ]);
    
        Marquee::create([
            'text' => 'Enjoy <span class="text-yellow-200">10% Cashback</span> on your first order over ₹500. <a href="" class="uppercase text-white">Start Shopping</a>',
        ]);
    }
}
