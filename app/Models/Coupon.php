<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    // Define the table name (if it is not the plural form of the model name)
    protected $table = 'coupons';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'coupon_code',
        'discount_amount',
        'discount_percentage',
        'expiration_date',
    ];
}
