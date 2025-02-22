<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    use HasFactory;
    // Add 'review_id' and 'image_path' to the fillable property
    protected $fillable = ['review_id', 'image_path'];

    // Optional: Define the relationship with the Review model
    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
