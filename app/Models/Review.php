<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'user_id',
        'name',
        'email',
        'rating',
        'review_message',
        'status',
    ];

    public function scopeActive($query)
{
    return $query->where('status', 'active');
}
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function review_images(){
        return $this->hasMany(ReviewImage::class);
    }

    /**
     * Get the user that submitted the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
