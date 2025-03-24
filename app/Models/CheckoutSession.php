<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutSession extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'checkout_sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'user_id',
        'cart_data',
        'total_price',
        'coupon_discount',
        'shipping_fee',
        'platform_fee',
        'total_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */

    protected $casts = [
        'cart_data' => 'array', // Automatically cast to array
    ];

    /**
     * Get the user that owns the checkout session.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
