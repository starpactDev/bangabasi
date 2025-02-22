<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $reviews = [
            [
                'product_id' => 7,
                'user_id' => null,
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'rating' => 5,
                'status' => 'active',
                'review_message' => 'Amazing product! Highly recommend.',
            ],
            [
                'product_id' => 7,
                'user_id' => null,
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'rating' => 4,
                'status' => 'inactive',
                'review_message' => 'Good quality but delivery was slow.',
            ],
            [
                'product_id' => 7,
                'user_id' => null,
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'rating' => 3,
                'status' => 'active',
                'review_message' => 'Decent product for the price.',
            ],
            [
                'product_id' => 7,
                'user_id' => null,
                'name' => 'Bob Brown',
                'email' => 'bob.brown@example.com',
                'rating' => 2,
                'status' => 'inactive',
                'review_message' => 'Not as expected, could be better.',
            ],
            [
                'product_id' => 7,
                'user_id' => null,
                'name' => 'Carol Davis',
                'email' => 'carol.davis@example.com',
                'rating' => 1,
                'status' => 'active',
                'review_message' => 'Poor quality, not satisfied at all.',
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
