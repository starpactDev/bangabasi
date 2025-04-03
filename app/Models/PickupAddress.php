<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PickupAddress extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id', 'building', 'street', 'locality', 'landmark', 'pincode', 'city', 'state',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
