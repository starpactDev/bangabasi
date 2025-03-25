<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderAmountBreakdown extends Model
{
    use HasFactory;
    
    // Define the table name
    protected $table = 'order_amount_breakdowns';

    // Define the fillable attributes (optional but recommended for mass assignment)
    protected $fillable = [
        'order_id',
        'platform_fee',
        'shipping_charge',
        'coupon_discount',
        'total_paid_by_customer',
        'admin_fee',
        'amount_to_seller',
    ];

    // Define any relationships if needed (e.g., order_id references an Order model)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

}
