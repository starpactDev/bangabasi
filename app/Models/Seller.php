<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_name', 
        'email', 
        'description', 
        'logo', 
        'registration_step', 
        'is_active'
    ];

    
    /**
     * Get the user that owns the seller.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pickupAddress()
    {
        return $this->hasOne(PickupAddress::class, 'user_id', 'user_id');
    }

    // Relationship with products
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id', 'user_id');
    }

    // Compute product count
    public function getProductCountAttribute()
    {
        return $this->products()->count();
    }

    // Compute average rating
    public function getAverageRatingAttribute()
    {
        return $this->products()
            ->join('reviews', 'products.id', '=', 'reviews.product_id')
            ->where('reviews.status', 'active')
            ->avg('reviews.rating') ?? 0;
    }

    // Compute total reviews
    public function getTotalReviewsAttribute()
    {
        return $this->products()
            ->join('reviews', 'products.id', '=', 'reviews.product_id')
            ->where('reviews.status', 'active')
            ->count();
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, OrderItem::class, 'seller_id', 'id', 'id', 'order_id');
    }

    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Product::class, 'user_id', 'product_id', 'user_id', 'id');
    }

}
