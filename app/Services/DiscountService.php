<?php

namespace App\Services;

use App\Models\ViewSaleAboveDiscount;
use Illuminate\Support\Facades\Cache;

class DiscountService
{
    /**
     * Get the discount threshold from the database or cache it for efficiency.
     *
     * @return float
     */
    public function getDiscountThreshold()
    {
        return Cache::remember('discount_threshold', 60 , function () {
            return ViewSaleAboveDiscount::latest()->value('discount') ?? 0;
        });
    }
}
