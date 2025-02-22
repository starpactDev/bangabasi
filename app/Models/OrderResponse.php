<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_item_id',
        'channel_order_id',
        'shipment_id',
        'status',
        'status_code',
        'onboarding_completed_now',
        'awb_code',
        'courier_company_id',
        'courier_name',
        'new_channel',
        'packaging_box_error',
    ];
}
