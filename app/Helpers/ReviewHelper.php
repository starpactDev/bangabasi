<?php

namespace App\Helpers;

use App\Models\Review;

class ReviewHelper
{
    /**
     * Get the average rating of active reviews for a product.
     *
     * @param int $productId
     * @return float
     */
    public static function getAverageRating($productId)
    {
        // Calculate the average rating of active reviews
        $averageRating = Review::where('product_id', $productId)
            ->where('status', 'active')
            ->avg('rating');

        // Return the average rating rounded to 1 decimal place
        return round($averageRating, 1);
    }
    public static function getReviewCount($productId)
    {
        // Count the number of active reviews
        return Review::where('product_id', $productId)
            ->where('status', 'active')
            ->count();
    }
}
