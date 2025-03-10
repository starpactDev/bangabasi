<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformFee extends Model
{
    use HasFactory;

    // Define the table name (if it doesn't follow Laravel's naming convention)
    protected $table = 'platform_fees';

    // Define the fields that are mass assignable
    protected $fillable = [
        'amount', // Only the amount field is mass-assignable
    ];

    // Optionally, cast the 'amount' attribute to decimal (two decimal places)
    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
