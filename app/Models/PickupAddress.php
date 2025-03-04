<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'building', 'street', 'locality', 'landmark', 'pincode', 'city', 'state',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
