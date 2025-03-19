<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemBreakdown extends Model
{
    use HasFactory;
    
    // Define the table name
    protected $table = 'order_item_breakdowns';

    // Define the fillable attributes (for mass assignment protection)
    protected $fillable = [
        'order_item_id',
        'seller_id',
        'platform_fee',
        'shipping_charge',
        'coupon_discount',
        'item_total',
        'amount_to_seller',
    ];

    // Define any relationships (for example, this could belong to an OrderItem model)
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    // Define the relationship to the Seller (if there is a Seller model)
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
